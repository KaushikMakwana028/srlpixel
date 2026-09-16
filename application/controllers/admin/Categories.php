<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Strict Admin Authentication Guard
        if (!$this->session->userdata('admin_logged_in') || $this->session->userdata('admin_role') != 1) {
            $this->session->set_flashdata('error', 'Authentication required. Please sign in to access the Admin Panel.');
            redirect('admin/login');
            return;
        }
    }

    /**
     * List all categories
     */
    public function index()
    {
        $data['title'] = 'Categories Management - SRL Pixel Admin';
        $data['breadcrumb'] = 'Categories';

        $limit = 10;
        $page = 1;
        $offset = 0;
        $total = $this->General_model->count_filtered_data('categories');
        $total_pages = max(1, ceil($total / $limit));

        $data['categories'] = $this->General_model->get_paginated_data('categories', [], [], $limit, $offset, 'id DESC');
        $data['offset'] = $offset;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page'] = $page;
        $data['total_pages'] = $total_pages;
        $data['pagination'] = $this->General_model->render_pagination_html($page, $total_pages, $total, $limit);

        $this->load->view('admin/header', $data);
        $this->load->view('admin/categories/index', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * AJAX endpoint for server-side search, filter and pagination
     */
    public function ajax_list()
    {
        $page   = max(1, (int)$this->input->get_post('page'));
        $limit  = in_array((int)$this->input->get_post('limit'), [5, 10, 25, 50, 100]) ? (int)$this->input->get_post('limit') : 10;
        $search = trim($this->input->get_post('search') ?? '');
        $status = $this->input->get_post('status');

        $where = [];
        if ($status !== '' && $status !== null) {
            $where['status'] = (int)$status;
        }

        $like = [];
        if (!empty($search)) {
            $like['name'] = $search;
            $like['slug'] = $search;
            $like['description'] = $search;
        }

        $total = $this->General_model->count_filtered_data('categories', $where, $like);
        $total_pages = max(1, ceil($total / $limit));
        if ($page > $total_pages && $total > 0) {
            $page = $total_pages;
        }
        $offset = ($page - 1) * $limit;

        $categories = $this->General_model->get_paginated_data('categories', $where, $like, $limit, $offset, 'id DESC');

        $html = $this->load->view('admin/categories/_rows', [
            'categories' => $categories,
            'offset'     => $offset
        ], TRUE);

        $pagination = $this->General_model->render_pagination_html($page, $total_pages, $total, $limit);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success'     => true,
                'html'        => $html,
                'pagination'  => $pagination,
                'total'       => $total,
                'page'        => $page,
                'total_pages' => $total_pages
            ]));
    }

    /**
     * Add new category
     */
    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('name', 'Category Name', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $name = $this->input->post('name', TRUE);
                $slug = url_title($this->input->post('slug') ? $this->input->post('slug') : $name, 'dash', TRUE);
                $description = $this->input->post('description', TRUE);
                $status = $this->input->post('status') ? 1 : 0;

                // Handle Image Upload
                $image_name = NULL;
                if (!empty($_FILES['image']['name'])) {
                    $config['upload_path']   = './uploads/categories/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
                    $config['max_size']      = 2048; // Max 2MB
                    $config['encrypt_name']  = TRUE;

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();
                        $image_name  = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('admin/categories/add');
                        return;
                    }
                }

                $insert_data = [
                    'name'        => $name,
                    'slug'        => $slug,
                    'parent_id'   => 0,
                    'description' => $description,
                    'image'       => $image_name,
                    'status'      => $status,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s')
                ];

                $insert_id = $this->General_model->insert('categories', $insert_data);
                if ($insert_id) {
                    $this->session->set_flashdata('success', 'Category "' . $name . '" created successfully.');
                    redirect('admin/categories');
                    return;
                } else {
                    $this->session->set_flashdata('error', 'Failed to save category. Please try again.');
                }
            }
        }

        $data['title'] = 'Add New Category - SRL Pixel Admin';
        $data['breadcrumb'] = 'Add Category';
        $data['category'] = NULL;
        $data['is_edit'] = FALSE;

        $this->load->view('admin/header', $data);
        $this->load->view('admin/categories/form', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Edit existing category
     */
    public function edit($id = NULL)
    {
        if (empty($id)) {
            redirect('admin/categories');
            return;
        }

        $category = $this->General_model->getOne('categories', ['id' => $id]);
        if (!$category) {
            $this->session->set_flashdata('error', 'Category not found.');
            redirect('admin/categories');
            return;
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('name', 'Category Name', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('description', 'Description', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $name = $this->input->post('name', TRUE);
                $slug = url_title($this->input->post('slug') ? $this->input->post('slug') : $name, 'dash', TRUE);
                $description = $this->input->post('description', TRUE);
                $status = $this->input->post('status') ? 1 : 0;

                $image_name = $category->image;
                if (!empty($_FILES['image']['name'])) {
                    $config['upload_path']   = './uploads/categories/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
                    $config['max_size']      = 2048; // Max 2MB
                    $config['encrypt_name']  = TRUE;

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('image')) {
                        // Remove old image if present
                        if (!empty($category->image) && file_exists('./uploads/categories/' . $category->image)) {
                            @unlink('./uploads/categories/' . $category->image);
                        }
                        $upload_data = $this->upload->data();
                        $image_name  = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('admin/categories/edit/' . $id);
                        return;
                    }
                }

                $update_data = [
                    'name'        => $name,
                    'slug'        => $slug,
                    'description' => $description,
                    'image'       => $image_name,
                    'status'      => $status,
                    'updated_at'  => date('Y-m-d H:i:s')
                ];

                $this->General_model->update('categories', ['id' => $id], $update_data);
                $this->session->set_flashdata('success', 'Category updated successfully.');
                redirect('admin/categories');
                return;
            }
        }

        $data['title'] = 'Edit Category - SRL Pixel Admin';
        $data['breadcrumb'] = 'Edit Category';
        $data['category'] = $category;
        $data['is_edit'] = TRUE;

        $this->load->view('admin/header', $data);
        $this->load->view('admin/categories/form', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Delete category
     */
    public function delete($id = NULL)
    {
        if (!empty($id)) {
            $category = $this->General_model->getOne('categories', ['id' => $id]);
            if ($category) {
                if (!empty($category->image) && file_exists('./uploads/categories/' . $category->image)) {
                    @unlink('./uploads/categories/' . $category->image);
                }
                $this->General_model->delete('categories', ['id' => $id]);
                $this->session->set_flashdata('success', 'Category removed successfully.');
            }
        }
        redirect('admin/categories');
    }

    /**
     * Quick status toggle
     */
    public function status($id = NULL)
    {
        if (!empty($id)) {
            $category = $this->General_model->getOne('categories', ['id' => $id]);
            if ($category) {
                $new_status = ($category->status == 1) ? 0 : 1;
                $this->General_model->update('categories', ['id' => $id], ['status' => $new_status]);
                $this->session->set_flashdata('success', 'Category status updated to ' . ($new_status ? 'Active' : 'Inactive') . '.');
            }
        }
        redirect('admin/categories');
    }
}
