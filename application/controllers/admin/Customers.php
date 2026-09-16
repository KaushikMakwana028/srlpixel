<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

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
     * List all registered customers (role = 0)
     */
    public function index()
    {
        $data['title'] = 'Customer Management - SRL Pixel Admin';
        $data['breadcrumb'] = 'Customers';

        $limit = 10;
        $page = 1;
        $offset = 0;
        $where = ['role' => 0];

        $total = $this->General_model->count_filtered_data('user', $where);
        $total_pages = max(1, ceil($total / $limit));

        $data['customers'] = $this->General_model->get_paginated_data('user', $where, [], $limit, $offset, 'id DESC');
        $data['offset'] = $offset;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page'] = $page;
        $data['total_pages'] = $total_pages;
        $data['pagination'] = $this->General_model->render_pagination_html($page, $total_pages, $total, $limit);

        $this->load->view('admin/header', $data);
        $this->load->view('admin/customers/index', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * AJAX endpoint for server-side customers search, filter, and pagination
     */
    public function ajax_list()
    {
        $page   = max(1, (int)$this->input->get_post('page'));
        $limit  = in_array((int)$this->input->get_post('limit'), [5, 10, 25, 50, 100]) ? (int)$this->input->get_post('limit') : 10;
        $search = trim($this->input->get_post('search') ?? '');
        $status = $this->input->get_post('status');

        $where = ['role' => 0];
        if ($status !== '' && $status !== null) {
            $where['status'] = (int)$status;
        }

        $like = [];
        if (!empty($search)) {
            $like['name']  = $search;
            $like['email'] = $search;
            $like['phone'] = $search;
        }

        $total = $this->General_model->count_filtered_data('user', $where, $like);
        $total_pages = max(1, ceil($total / $limit));
        if ($page > $total_pages && $total > 0) {
            $page = $total_pages;
        }
        $offset = ($page - 1) * $limit;

        $customers = $this->General_model->get_paginated_data('user', $where, $like, $limit, $offset, 'id DESC');

        $html = $this->load->view('admin/customers/_rows', [
            'customers' => $customers,
            'offset'    => $offset
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
     * Toggle Customer status (Active <-> Inactive)
     */
    public function status($id = NULL)
    {
        if (!empty($id)) {
            $customer = $this->General_model->getOne('user', ['id' => $id, 'role' => 0]);
            if ($customer) {
                $new_status = ($customer->status == 1) ? 0 : 1;
                $this->General_model->update('user', ['id' => $id], ['status' => $new_status]);
                $this->session->set_flashdata('success', 'Customer account has been ' . ($new_status ? 'Activated' : 'Deactivated') . '.');
            } else {
                $this->session->set_flashdata('error', 'Customer not found or invalid role.');
            }
        }
        redirect('admin/customers');
    }

    /**
     * Delete Customer account
     */
    public function delete($id = NULL)
    {
        if (!empty($id)) {
            $customer = $this->General_model->getOne('user', ['id' => $id, 'role' => 0]);
            if ($customer) {
                $this->General_model->delete('user', ['id' => $id, 'role' => 0]);
                $this->session->set_flashdata('success', 'Customer record deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Unable to delete customer.');
            }
        }
        redirect('admin/customers');
    }
}
