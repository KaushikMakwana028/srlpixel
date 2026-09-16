<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Admin Authentication Guard
        if (!$this->session->userdata('admin_logged_in') || $this->session->userdata('admin_role') != 1) {
            $this->session->set_flashdata('error', 'Authentication required. Please sign in to access the Admin Panel.');
            redirect('admin/login');
            return;
        }
    }

    /**
     * List all orders with status tab filters
     */
    public function index()
    {
        $data['title'] = 'Orders Management - SRL Pixel Admin';
        $data['breadcrumb'] = 'Orders';

        // Count for status filter pills matching media_1789561608012.png
        $data['counts'] = [
            'all'                 => $this->General_model->count_filtered_data('orders'),
            'Awaiting Payment'    => $this->General_model->count_filtered_data('orders', ['order_status' => 'Awaiting Payment']),
            'Placed'              => $this->General_model->count_filtered_data('orders', ['order_status' => 'Placed']),
            'Confirmed'           => $this->General_model->count_filtered_data('orders', ['order_status' => 'Confirmed']),
            'Packed'              => $this->General_model->count_filtered_data('orders', ['order_status' => 'Packed']),
            'Out for Delivery'    => $this->General_model->count_filtered_data('orders', ['order_status' => 'Out for Delivery']),
            'Delivered'           => $this->General_model->count_filtered_data('orders', ['order_status' => 'Delivered']),
            'Cancelled'           => $this->General_model->count_filtered_data('orders', ['order_status' => 'Cancelled'])
        ];

        $limit = 10;
        $page = 1;
        $offset = 0;
        $status = $this->input->get('status');

        $where = [];
        if (!empty($status) && in_array($status, ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'])) {
            $where['order_status'] = $status;
        }

        $total = $this->General_model->count_filtered_data('orders', $where);
        $total_pages = max(1, ceil($total / $limit));

        $data['orders'] = $this->General_model->get_paginated_data('orders', $where, [], $limit, $offset, 'id DESC');
        $data['offset'] = $offset;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page'] = $page;
        $data['status_filter'] = !empty($status) ? $status : 'all';
        $data['total_pages'] = $total_pages;
        $data['pagination'] = $this->General_model->render_pagination_html($page, $total_pages, $total, $limit);

        $this->load->view('admin/header', $data);
        $this->load->view('admin/orders/index', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * AJAX endpoint for server-side search, filtering by status, and pagination
     */
    public function ajax_list()
    {
        $page   = max(1, (int)$this->input->get_post('page'));
        $limit  = in_array((int)$this->input->get_post('limit'), [5, 10, 25, 50, 100]) ? (int)$this->input->get_post('limit') : 10;
        $search = trim($this->input->get_post('search') ?? '');
        $status = trim($this->input->get_post('status') ?? '');

        $where = [];
        if (!empty($status) && in_array($status, ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'])) {
            $where['order_status'] = $status;
        }

        $like = [];
        if (!empty($search)) {
            $like = [
                'order_number'           => $search,
                'shipping_full_name'     => $search,
                'shipping_mobile'        => $search,
                'shipping_city'          => $search
            ];
        }

        $total = $this->General_model->count_filtered_data('orders', $where, $like);
        $total_pages = max(1, ceil($total / $limit));

        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $offset = ($page - 1) * $limit;

        $orders = $this->General_model->get_paginated_data('orders', $where, $like, $limit, $offset, 'id DESC');

        $rows_html = $this->load->view('admin/orders/_rows', [
            'orders' => $orders,
            'offset' => $offset
        ], TRUE);

        $pagination_html = $this->General_model->render_pagination_html($page, $total_pages, $total, $limit);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'     => 'success',
                'html'       => $rows_html,
                'pagination' => $pagination_html,
                'total'      => $total,
                'page'       => $page,
                'totalPages' => $total_pages
            ]));
    }

    /**
     * View Detailed Order Information
     */
    public function detail($id = NULL)
    {
        $order = $this->General_model->getOne('orders', ['id' => (int)$id]);

        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found.');
            redirect('admin/orders');
            return;
        }

        $items = $this->General_model->getAll('order_items', ['order_id' => $order->id]);
        $customer = $this->General_model->getOne('user', ['id' => $order->user_id]);

        $data['order'] = $order;
        $data['items'] = $items;
        $data['customer'] = $customer;
        $data['title'] = 'Order #' . $order->order_number . ' - SRL Pixel Admin';
        $data['breadcrumb'] = 'Order Details';

        $this->load->view('admin/header', $data);
        $this->load->view('admin/orders/detail', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Update Order Status (AJAX & Form POST)
     */
    public function update_status()
    {
        $order_id = (int)$this->input->post('order_id');
        $status   = trim($this->input->post('status'));
        $notes    = $this->input->post('notes', TRUE);

        $valid_statuses = ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'];

        if (!in_array($status, $valid_statuses)) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Invalid status selected.']));
                return;
            }
            $this->session->set_flashdata('error', 'Invalid status selected.');
            redirect('admin/orders/detail/' . $order_id);
            return;
        }

        $order = $this->General_model->getOne('orders', ['id' => $order_id]);
        if (!$order) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Order not found.']));
                return;
            }
            $this->session->set_flashdata('error', 'Order not found.');
            redirect('admin/orders');
            return;
        }

        $update_data = [
            'order_status' => $status,
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        if ($notes !== null && $notes !== '') {
            $update_data['notes'] = $notes;
        }

        // If marked as Delivered and payment was COD, also mark payment_status as Paid
        if ($status === 'Delivered' && $order->payment_status === 'Pending') {
            $update_data['payment_status'] = 'Paid';
        }

        $this->General_model->update('orders', ['id' => $order->id], $update_data);

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => true,
                'message' => 'Order status updated to "' . $status . '" successfully!',
                'status'  => $status
            ]));
            return;
        }

        $this->session->set_flashdata('success', 'Order status updated to "' . $status . '" successfully!');
        redirect('admin/orders/detail/' . $order->id);
    }
}
