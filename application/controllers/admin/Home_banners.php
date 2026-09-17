<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_banners extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Strict Admin Authentication Guard
        if (!$this->session->userdata('admin_logged_in') || $this->session->userdata('admin_role') != 1) {
            $this->session->set_flashdata('error', 'Authentication required. Please sign in to access the Admin Panel.');
            redirect('admin/login');
            return;
        }

        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    /**
     * List all home banners
     */
    public function index()
    {
        $data['title'] = 'Home Banners - SRL Pixel Admin';
        $data['breadcrumb'] = 'Home Banners';

        $limit = 10;
        $page = 1;
        $offset = 0;

        $total = $this->General_model->count_filtered_data('home_banners');
        $total_pages = max(1, ceil($total / $limit));

        $banners = $this->General_model->get_paginated_data('home_banners', [], [], $limit, $offset, 'display_order ASC, id DESC');

        $data['banners'] = $banners;
        $data['offset'] = $offset;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page'] = $page;
        $data['total_pages'] = $total_pages;
        $data['pagination'] = $this->General_model->render_pagination_html($page, $total_pages, $total, $limit);

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home_banners/index', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * AJAX endpoint for live search, filter and pagination
     */
    public function ajax_list()
    {
        $page   = max(1, (int)$this->input->get_post('page'));
        $limit  = in_array((int)$this->input->get_post('limit'), [5, 10, 25, 50, 100]) ? (int)$this->input->get_post('limit') : 10;
        $search = trim($this->input->get_post('search') ?? '');
        $status = $this->input->get_post('status');
        $type   = $this->input->get_post('banner_type');
        $sort   = $this->input->get_post('sort') ?? 'display_order';

        $where = [];
        if ($status !== '' && $status !== null) {
            $where['status'] = (int)$status;
        }
        if (!empty($type)) {
            $where['banner_type'] = $type;
        }

        $like = [];
        if (!empty($search)) {
            $like['title']       = $search;
            $like['subtitle']    = $search;
            $like['button_text'] = $search;
        }

        $order_by = 'display_order ASC, id DESC';
        if ($sort === 'newest') {
            $order_by = 'id DESC';
        } elseif ($sort === 'oldest') {
            $order_by = 'id ASC';
        } elseif ($sort === 'display_order') {
            $order_by = 'display_order ASC, id DESC';
        }

        $total = $this->General_model->count_filtered_data('home_banners', $where, $like);
        $total_pages = max(1, ceil($total / $limit));
        if ($page > $total_pages && $total > 0) {
            $page = $total_pages;
        }
        $offset = ($page - 1) * $limit;

        $banners = $this->General_model->get_paginated_data('home_banners', $where, $like, $limit, $offset, $order_by);

        $html = $this->load->view('admin/home_banners/_rows', [
            'banners' => $banners,
            'offset'  => $offset
        ], TRUE);

        $pagination = $this->General_model->render_pagination_html($page, $total_pages, $total, $limit);

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'html'        => $html,
            'pagination'  => $pagination,
            'total'       => $total,
            'page'        => $page,
            'total_pages' => $total_pages,
            'limit'       => $limit
        ]));
    }

    /**
     * Add new home banner
     */
    public function add()
    {
        $data['title'] = 'Add Banner - SRL Pixel Admin';
        $data['breadcrumb'] = 'Add Banner';
        $data['banner'] = null;
        $data['is_edit'] = false;

        $this->form_validation->set_rules('title', 'Banner Title', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('subtitle', 'Subtitle', 'trim|max_length[255]');
        $this->form_validation->set_rules('button_text', 'Button Text', 'trim|max_length[100]');
        $this->form_validation->set_rules('button_link', 'Button Link', 'trim|max_length[255]');
        $this->form_validation->set_rules('badge_text', 'Badge Text', 'trim|max_length[100]');
        $this->form_validation->set_rules('banner_type', 'Banner Type', 'trim|max_length[50]');
        $this->form_validation->set_rules('display_order', 'Display Order', 'trim|numeric');

        if ($this->form_validation->run() === TRUE) {
            // Upload Banner Image
            $upload_path = './uploads/banners/';
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, true);
            }

            $banner_image = '';
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path']   = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png|webp|gif';
                $config['max_size']      = 5120; // 5MB
                $config['encrypt_name']  = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    $banner_image = $upload_data['file_name'];
                } else {
                    $data['upload_error'] = $this->upload->display_errors('', '');
                    $this->load->view('admin/header', $data);
                    $this->load->view('admin/home_banners/form', $data);
                    $this->load->view('admin/footer', $data);
                    return;
                }
            } else {
                $data['upload_error'] = 'Please select a banner image.';
                $this->load->view('admin/header', $data);
                $this->load->view('admin/home_banners/form', $data);
                $this->load->view('admin/footer', $data);
                return;
            }

            $start_date = $this->input->post('start_date');
            $end_date   = $this->input->post('end_date');

            $save_data = [
                'title'         => $this->input->post('title', TRUE),
                'subtitle'      => $this->input->post('subtitle', TRUE) ?: null,
                'button_text'   => $this->input->post('button_text', TRUE) ?: null,
                'button_link'   => $this->input->post('button_link', TRUE) ?: null,
                'badge_text'    => $this->input->post('badge_text', TRUE) ?: null,
                'image'         => $banner_image,
                'banner_type'   => $this->input->post('banner_type', TRUE) ?: 'home',
                'display_order' => (int)$this->input->post('display_order'),
                'start_date'    => !empty($start_date) ? $start_date : null,
                'end_date'      => !empty($end_date) ? $end_date : null,
                'status'        => $this->input->post('status') ? 1 : 0
            ];

            $this->General_model->insert('home_banners', $save_data);
            $this->session->set_flashdata('success', 'Home banner created successfully!');
            redirect('admin/home_banners');
            return;
        }

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home_banners/form', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Edit existing home banner
     */
    public function edit($id = null)
    {
        $id = (int)$id;
        $banner = $this->General_model->getOne('home_banners', ['id' => $id]);

        if (!$banner) {
            $this->session->set_flashdata('error', 'Banner not found.');
            redirect('admin/home_banners');
            return;
        }

        $data['title'] = 'Edit Banner - SRL Pixel Admin';
        $data['breadcrumb'] = 'Edit Banner';
        $data['banner'] = $banner;
        $data['is_edit'] = true;

        $this->form_validation->set_rules('title', 'Banner Title', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('subtitle', 'Subtitle', 'trim|max_length[255]');
        $this->form_validation->set_rules('button_text', 'Button Text', 'trim|max_length[100]');
        $this->form_validation->set_rules('button_link', 'Button Link', 'trim|max_length[255]');
        $this->form_validation->set_rules('badge_text', 'Badge Text', 'trim|max_length[100]');
        $this->form_validation->set_rules('banner_type', 'Banner Type', 'trim|max_length[50]');
        $this->form_validation->set_rules('display_order', 'Display Order', 'trim|numeric');

        if ($this->form_validation->run() === TRUE) {
            $banner_image = $banner->image;

            if (!empty($_FILES['image']['name'])) {
                $upload_path = './uploads/banners/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, true);
                }

                $config['upload_path']   = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png|webp|gif';
                $config['max_size']      = 5120;
                $config['encrypt_name']  = TRUE;

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $upload_data = $this->upload->data();
                    // Delete previous image if exists
                    if (!empty($banner->image) && file_exists('./uploads/banners/' . $banner->image) && !in_array($banner->image, ['banner_1.png', 'banner_2.jpg', 'banner_3.jpg'])) {
                        @unlink('./uploads/banners/' . $banner->image);
                    }
                    $banner_image = $upload_data['file_name'];
                } else {
                    $data['upload_error'] = $this->upload->display_errors('', '');
                    $this->load->view('admin/header', $data);
                    $this->load->view('admin/home_banners/form', $data);
                    $this->load->view('admin/footer', $data);
                    return;
                }
            }

            $start_date = $this->input->post('start_date');
            $end_date   = $this->input->post('end_date');

            $update_data = [
                'title'         => $this->input->post('title', TRUE),
                'subtitle'      => $this->input->post('subtitle', TRUE) ?: null,
                'button_text'   => $this->input->post('button_text', TRUE) ?: null,
                'button_link'   => $this->input->post('button_link', TRUE) ?: null,
                'badge_text'    => $this->input->post('badge_text', TRUE) ?: null,
                'image'         => $banner_image,
                'banner_type'   => $this->input->post('banner_type', TRUE) ?: 'home',
                'display_order' => (int)$this->input->post('display_order'),
                'start_date'    => !empty($start_date) ? $start_date : null,
                'end_date'      => !empty($end_date) ? $end_date : null,
                'status'        => $this->input->post('status') ? 1 : 0
            ];

            $this->General_model->update('home_banners', ['id' => $id], $update_data);
            $this->session->set_flashdata('success', 'Banner updated successfully!');
            redirect('admin/home_banners');
            return;
        }

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home_banners/form', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Toggle banner active / inactive status
     */
    public function toggle_status($id = null)
    {
        $id = (int)$id;
        $banner = $this->General_model->getOne('home_banners', ['id' => $id]);

        if (!$banner) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => 'Banner not found.'
                ]));
                return;
            }
            $this->session->set_flashdata('error', 'Banner not found.');
            redirect('admin/home_banners');
            return;
        }

        $new_status = ($banner->status == 1) ? 0 : 1;
        $this->General_model->update('home_banners', ['id' => $id], ['status' => $new_status]);

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success'    => true,
                'new_status' => $new_status,
                'message'    => 'Banner status updated to ' . ($new_status == 1 ? 'Active' : 'Inactive') . '.'
            ]));
            return;
        }

        $this->session->set_flashdata('success', 'Banner status updated successfully!');
        redirect('admin/home_banners');
    }

    /**
     * Delete banner
     */
    public function delete($id = null)
    {
        $id = (int)$id;
        $banner = $this->General_model->getOne('home_banners', ['id' => $id]);

        if (!$banner) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => 'Banner not found.'
                ]));
                return;
            }
            $this->session->set_flashdata('error', 'Banner not found.');
            redirect('admin/home_banners');
            return;
        }

        // Delete image file if exists
        if (!empty($banner->image) && file_exists('./uploads/banners/' . $banner->image) && !in_array($banner->image, ['banner_1.png', 'banner_2.jpg', 'banner_3.jpg'])) {
            @unlink('./uploads/banners/' . $banner->image);
        }

        $this->General_model->delete('home_banners', ['id' => $id]);

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => true,
                'message' => 'Banner deleted successfully.'
            ]));
            return;
        }

        $this->session->set_flashdata('success', 'Banner deleted successfully.');
        redirect('admin/home_banners');
    }
}
