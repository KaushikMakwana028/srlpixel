<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupons extends CI_Controller {

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
     * List all coupons with filters, usage progress, and stats
     */
    public function index()
    {
        $data['title'] = 'Coupon & Promo Codes Management - SRL Pixel Admin';
        $data['breadcrumb'] = 'Coupons';

        $search = trim($this->input->get('search') ?? '');
        $status = $this->input->get('status');
        $discount_type = $this->input->get('discount_type');

        $where = [];
        if ($status !== '' && $status !== null && $status !== 'all') {
            if ($status === 'expired') {
                $where['end_date <'] = date('Y-m-d H:i:s');
            } else {
                $where['status'] = (int)$status;
            }
        }

        if (!empty($discount_type) && in_array($discount_type, ['flat', 'percentage'])) {
            $where['discount_type'] = $discount_type;
        }

        $like = [];
        if (!empty($search)) {
            $like = ['code' => $search, 'title' => $search];
        }

        // Stats counts
        $data['total_coupons']   = $this->General_model->count_filtered_data('coupons');
        $data['active_coupons']  = $this->General_model->count_filtered_data('coupons', ['status' => 1]);
        $data['inactive_coupons']= $this->General_model->count_filtered_data('coupons', ['status' => 0]);

        // Total usages count and total discount given across all coupons
        $usage_stats = $this->db->select('COUNT(id) as total_redemptions, COALESCE(SUM(discount_amount), 0) as total_savings')
                                ->get('coupon_usages')
                                ->row();
        $data['total_redemptions'] = $usage_stats ? (int)$usage_stats->total_redemptions : 0;
        $data['total_savings']     = $usage_stats ? (float)$usage_stats->total_savings : 0.00;

        // Pagination
        $limit = 10;
        $page = max(1, (int)$this->input->get('page'));
        $offset = ($page - 1) * $limit;

        $total_records = $this->General_model->count_filtered_data('coupons', $where, $like);
        $total_pages   = max(1, ceil($total_records / $limit));

        $data['coupons']       = $this->General_model->get_paginated_data('coupons', $where, $like, $limit, $offset, 'id DESC');
        $data['total_records'] = $total_records;
        $data['page']          = $page;
        $data['limit']         = $limit;
        $data['offset']        = $offset;
        $data['total_pages']   = $total_pages;
        $data['search']        = $search;
        $data['status']        = $status;
        $data['discount_type'] = $discount_type;

        $this->load->view('admin/header', $data);
        $this->load->view('admin/coupons/index', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Add new coupon form
     */
    public function add()
    {
        $data['title'] = 'Create New Coupon - SRL Pixel Admin';
        $data['breadcrumb'] = 'Create Coupon';
        $data['coupon'] = null;

        $this->load->view('admin/header', $data);
        $this->load->view('admin/coupons/form', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Store new coupon in database
     */
    public function store()
    {
        $this->form_validation->set_rules('code', 'Coupon Code', 'trim|required|min_length[3]|max_length[50]|is_unique[coupons.code]');
        $this->form_validation->set_rules('title', 'Coupon Title', 'trim|max_length[150]');
        $this->form_validation->set_rules('discount_type', 'Discount Type', 'trim|required|in_list[flat,percentage]');
        $this->form_validation->set_rules('discount_value', 'Discount Value', 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('min_order_amount', 'Minimum Order Amount', 'trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('max_discount_amount', 'Max Discount Cap', 'trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('usage_limit', 'Total Usage Limit', 'trim|integer|greater_than_equal_to[0]');
        $this->form_validation->set_rules('per_user_limit', 'Per Customer Limit', 'trim|integer|greater_than_equal_to[1]');
        $this->form_validation->set_rules('status', 'Status', 'trim|in_list[0,1]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors('<p class="mb-0">', '</p>'));
            $this->add();
            return;
        }

        $discount_type = $this->input->post('discount_type', TRUE);
        $discount_value = (float)$this->input->post('discount_value', TRUE);

        if ($discount_type === 'percentage' && $discount_value > 100) {
            $this->session->set_flashdata('error', 'Percentage discount value cannot exceed 100%.');
            $this->add();
            return;
        }

        $code = strtoupper(trim($this->input->post('code', TRUE)));
        $max_discount_amount = $this->input->post('max_discount_amount', TRUE);
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);

        $insert_data = [
            'code'                => $code,
            'title'               => $this->input->post('title', TRUE) ?: null,
            'description'         => $this->input->post('description', TRUE) ?: null,
            'discount_type'       => $discount_type,
            'discount_value'      => $discount_value,
            'min_order_amount'    => (float)($this->input->post('min_order_amount', TRUE) ?: 0),
            'max_discount_amount' => ($discount_type === 'percentage' && !empty($max_discount_amount)) ? (float)$max_discount_amount : null,
            'usage_limit'         => (int)($this->input->post('usage_limit', TRUE) ?: 0),
            'used_count'          => 0,
            'per_user_limit'      => max(1, (int)($this->input->post('per_user_limit', TRUE) ?: 1)),
            'start_date'          => !empty($start_date) ? date('Y-m-d H:i:s', strtotime($start_date)) : null,
            'end_date'            => !empty($end_date) ? date('Y-m-d H:i:s', strtotime($end_date)) : null,
            'status'              => (int)($this->input->post('status') !== null ? $this->input->post('status') : 1),
            'created_at'          => date('Y-m-d H:i:s'),
            'updated_at'          => date('Y-m-d H:i:s')
        ];

        $coupon_id = $this->General_model->insert('coupons', $insert_data);

        $this->session->set_flashdata('success', 'Coupon code "' . $code . '" created successfully!');
        redirect('admin/coupons');
    }

    /**
     * Edit coupon form
     */
    public function edit($id = NULL)
    {
        if (empty($id)) {
            redirect('admin/coupons');
            return;
        }

        $coupon = $this->General_model->getOne('coupons', ['id' => $id]);
        if (!$coupon) {
            $this->session->set_flashdata('error', 'Coupon not found.');
            redirect('admin/coupons');
            return;
        }

        $data['title'] = 'Edit Coupon #' . $coupon->code . ' - SRL Pixel Admin';
        $data['breadcrumb'] = 'Edit Coupon';
        $data['coupon'] = $coupon;

        $this->load->view('admin/header', $data);
        $this->load->view('admin/coupons/form', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Update existing coupon
     */
    public function update($id = NULL)
    {
        if (empty($id)) {
            redirect('admin/coupons');
            return;
        }

        $coupon = $this->General_model->getOne('coupons', ['id' => $id]);
        if (!$coupon) {
            $this->session->set_flashdata('error', 'Coupon not found.');
            redirect('admin/coupons');
            return;
        }

        $code = strtoupper(trim($this->input->post('code', TRUE)));

        // Unique validation excluding current coupon id
        if ($code !== strtoupper($coupon->code)) {
            $this->form_validation->set_rules('code', 'Coupon Code', 'trim|required|min_length[3]|max_length[50]|is_unique[coupons.code]');
        } else {
            $this->form_validation->set_rules('code', 'Coupon Code', 'trim|required|min_length[3]|max_length[50]');
        }

        $this->form_validation->set_rules('title', 'Coupon Title', 'trim|max_length[150]');
        $this->form_validation->set_rules('discount_type', 'Discount Type', 'trim|required|in_list[flat,percentage]');
        $this->form_validation->set_rules('discount_value', 'Discount Value', 'trim|required|numeric|greater_than[0]');
        $this->form_validation->set_rules('min_order_amount', 'Minimum Order Amount', 'trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('max_discount_amount', 'Max Discount Cap', 'trim|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('usage_limit', 'Total Usage Limit', 'trim|integer|greater_than_equal_to[0]');
        $this->form_validation->set_rules('per_user_limit', 'Per Customer Limit', 'trim|integer|greater_than_equal_to[1]');
        $this->form_validation->set_rules('status', 'Status', 'trim|in_list[0,1]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors('<p class="mb-0">', '</p>'));
            $this->edit($id);
            return;
        }

        $discount_type = $this->input->post('discount_type', TRUE);
        $discount_value = (float)$this->input->post('discount_value', TRUE);

        if ($discount_type === 'percentage' && $discount_value > 100) {
            $this->session->set_flashdata('error', 'Percentage discount value cannot exceed 100%.');
            $this->edit($id);
            return;
        }

        $max_discount_amount = $this->input->post('max_discount_amount', TRUE);
        $start_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);

        $update_data = [
            'code'                => $code,
            'title'               => $this->input->post('title', TRUE) ?: null,
            'description'         => $this->input->post('description', TRUE) ?: null,
            'discount_type'       => $discount_type,
            'discount_value'      => $discount_value,
            'min_order_amount'    => (float)($this->input->post('min_order_amount', TRUE) ?: 0),
            'max_discount_amount' => ($discount_type === 'percentage' && !empty($max_discount_amount)) ? (float)$max_discount_amount : null,
            'usage_limit'         => (int)($this->input->post('usage_limit', TRUE) ?: 0),
            'per_user_limit'      => max(1, (int)($this->input->post('per_user_limit', TRUE) ?: 1)),
            'start_date'          => !empty($start_date) ? date('Y-m-d H:i:s', strtotime($start_date)) : null,
            'end_date'            => !empty($end_date) ? date('Y-m-d H:i:s', strtotime($end_date)) : null,
            'status'              => (int)($this->input->post('status') !== null ? $this->input->post('status') : 1),
            'updated_at'          => date('Y-m-d H:i:s')
        ];

        $this->General_model->update('coupons', ['id' => $id], $update_data);

        $this->session->set_flashdata('success', 'Coupon code "' . $code . '" updated successfully!');
        redirect('admin/coupons');
    }

    /**
     * Toggle coupon status (Active <-> Inactive)
     */
    public function status($id = NULL)
    {
        if (!empty($id)) {
            $coupon = $this->General_model->getOne('coupons', ['id' => $id]);
            if ($coupon) {
                $new_status = ($coupon->status == 1) ? 0 : 1;
                $this->General_model->update('coupons', ['id' => $id], ['status' => $new_status]);
                $this->session->set_flashdata('success', 'Coupon "' . $coupon->code . '" status changed to ' . ($new_status ? 'Active' : 'Inactive') . '.');
            } else {
                $this->session->set_flashdata('error', 'Coupon not found.');
            }
        }
        $referer = $this->input->server('HTTP_REFERER');
        if (!empty($referer) && strpos($referer, base_url()) !== false) {
            redirect($referer);
        } else {
            redirect('admin/coupons');
        }
    }

    /**
     * Delete coupon
     */
    public function delete($id = NULL)
    {
        if (!empty($id)) {
            $coupon = $this->General_model->getOne('coupons', ['id' => $id]);
            if ($coupon) {
                $this->General_model->delete('coupons', ['id' => $id]);
                $this->session->set_flashdata('success', 'Coupon "' . $coupon->code . '" has been permanently deleted.');
            } else {
                $this->session->set_flashdata('error', 'Coupon not found.');
            }
        }
        redirect('admin/coupons');
    }

    /**
     * View Coupon Details & Customer Redemption Log
     * "view option to check which customer use for which oreder in perfcet way"
     */
    public function view($id = NULL)
    {
        if (empty($id)) {
            redirect('admin/coupons');
            return;
        }

        $coupon = $this->General_model->getOne('coupons', ['id' => $id]);
        if (!$coupon) {
            $this->session->set_flashdata('error', 'Coupon not found.');
            redirect('admin/coupons');
            return;
        }

        $data['title'] = 'Coupon #' . $coupon->code . ' Usage & Details - SRL Pixel Admin';
        $data['breadcrumb'] = 'Coupon Details';
        $data['coupon'] = $coupon;

        // Calculate aggregated metrics across ALL redemptions for this coupon
        $stats_row = $this->db->select('COUNT(cu.id) as total_uses, COALESCE(SUM(cu.discount_amount), 0) as total_discount_given, COALESCE(SUM(cu.order_total), 0) as total_orders_revenue')
                              ->from('coupon_usages cu')
                              ->where('cu.coupon_id', $id)
                              ->get()
                              ->row();

        $total_uses           = $stats_row ? (int)$stats_row->total_uses : 0;
        $total_discount_given = $stats_row ? (float)$stats_row->total_discount_given : 0.00;
        $total_orders_revenue = $stats_row ? (float)$stats_row->total_orders_revenue : 0.00;

        // 5 records per page pagination (with AJAX support)
        $limit        = 5;
        $page         = max(1, (int)$this->input->get('page'));
        $offset       = ($page - 1) * $limit;
        $total_pages  = max(1, (int)ceil($total_uses / $limit));

        // Fetch paginated usages for current page
        $this->db->select('cu.*, u.name as customer_name, u.email as customer_email, u.phone as customer_phone, u.profile_image, o.order_number, o.order_status, o.total_amount as order_final_total, o.created_at as order_created_at');
        $this->db->from('coupon_usages cu');
        $this->db->join('user u', 'u.id = cu.user_id', 'left');
        $this->db->join('orders o', 'o.id = cu.order_id', 'left');
        $this->db->where('cu.coupon_id', $id);
        $this->db->order_by('cu.id', 'DESC');
        $this->db->limit($limit, $offset);
        $usages = $this->db->get()->result();

        // AJAX response for seamless pagination without page reload
        if ($this->input->is_ajax_request() || $this->input->get('ajax')) {
            $rows_html = $this->load->view('admin/coupons/_redemptions_rows', [
                'usages' => $usages,
                'offset' => $offset,
                'coupon' => $coupon
            ], TRUE);

            $pagination_html = $this->load->view('admin/coupons/_redemptions_pagination', [
                'page'          => $page,
                'total_pages'   => $total_pages,
                'total_records' => $total_uses,
                'limit'         => $limit,
                'offset'        => $offset,
                'coupon'        => $coupon
            ], TRUE);

            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success'         => true,
                'html'            => $rows_html,
                'pagination_html' => $pagination_html,
                'page'            => $page,
                'total_pages'     => $total_pages,
                'total_records'   => $total_uses
            ]));
            return;
        }

        $data['usages']               = $usages;
        $data['total_discount_given'] = $total_discount_given;
        $data['total_orders_revenue'] = $total_orders_revenue;
        $data['total_uses']           = $total_uses;
        $data['limit']                = $limit;
        $data['page']                 = $page;
        $data['offset']               = $offset;
        $data['total_pages']          = $total_pages;
        $data['total_records']        = $total_uses;

        $this->load->view('admin/header', $data);
        $this->load->view('admin/coupons/view', $data);
        $this->load->view('admin/footer', $data);
    }
}
