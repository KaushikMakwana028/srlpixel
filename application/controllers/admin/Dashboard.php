<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // 1. If a regular customer is logged in, explicitly deny access to admin panel
        if ($this->session->userdata('user_logged_in') && $this->session->userdata('user_role') == 0) {
            $this->session->set_flashdata('error', 'Access Denied: Your account does not have administrator privileges.');
            redirect('dashboard');
            return;
        }

        // 2. If admin session is NOT stored, automatic redirect to admin/login
        if (!$this->session->userdata('admin_logged_in') || $this->session->userdata('admin_role') != 1) {
            $this->session->set_flashdata('error', 'Authentication required. Please sign in to access the Admin Panel.');
            redirect('admin/login');
            return;
        }
    }

    public function index()
    {
        $admin_id = $this->session->userdata('admin_id');
        $admin = $this->General_model->getOne('user', ['id' => $admin_id]);

        // Re-verify that the user is still valid, active, and admin role in DB
        if (!$admin || $admin->role != 1 || $admin->status != 1) {
            $this->session->unset_userdata(['admin_id', 'admin_name', 'admin_email', 'admin_role', 'admin_profile_image', 'admin_logged_in']);
            $this->session->set_flashdata('error', 'Invalid or inactive administrator session. Please log in again.');
            redirect('admin/login');
            return;
        }

        $data['admin'] = $admin;
        $data['admin_name'] = !empty($admin->name) ? $admin->name : ($this->session->userdata('admin_name') ? $this->session->userdata('admin_name') : 'Admin');

        // 1. Financial & Revenue Metrics
        $rev_row = $this->db->select('COALESCE(SUM(total_amount), 0) as total_rev')
                            ->where('order_type', 'online')
                            ->where('order_status !=', 'Cancelled')
                            ->get('orders')
                            ->row();
        $data['gross_online_revenue'] = (float)($rev_row->total_rev ?? 0);

        $paid_row = $this->db->select('COALESCE(SUM(total_amount), 0) as paid_rev')
                             ->where('order_type', 'online')
                             ->where('payment_status', 'Paid')
                             ->get('orders')
                             ->row();
        $data['paid_online_revenue'] = (float)($paid_row->paid_rev ?? 0);

        $today_row = $this->db->select('COALESCE(SUM(total_amount), 0) as today_rev, COUNT(*) as today_count')
                              ->where('order_type', 'online')
                              ->where('DATE(created_at)', date('Y-m-d'))
                              ->get('orders')
                              ->row();
        $data['today_online_revenue'] = (float)($today_row->today_rev ?? 0);
        $data['today_online_orders']  = (int)($today_row->today_count ?? 0);

        $off_row = $this->db->select('COALESCE(SUM(total_amount), 0) as off_rev, COUNT(*) as off_count')
                            ->where('order_type', 'offline')
                            ->where('order_status !=', 'Cancelled')
                            ->get('orders')
                            ->row();
        $data['offline_revenue']      = (float)($off_row->off_rev ?? 0);
        $data['offline_orders_count'] = (int)($off_row->off_count ?? 0);

        // 2. Orders Metrics
        $data['total_orders_count']     = $this->General_model->count_filtered_data('orders', ['order_type' => 'online']);
        $data['delivered_orders_count'] = $this->General_model->count_filtered_data('orders', ['order_type' => 'online', 'order_status' => 'Delivered']);
        $data['pending_orders_count']   = $this->db->where('order_type', 'online')
                                                   ->where_in('order_status', ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery'])
                                                   ->count_all_results('orders');

        // 3. Customer Directory Metrics
        $data['member_count']           = $this->General_model->count_filtered_data('user', ['role' => 0]);
        $data['active_customers_count'] = $this->General_model->count_filtered_data('user', ['role' => 0, 'status' => 1]);
        $data['new_customers_month']    = $this->db->where('role', 0)
                                                   ->where('MONTH(created_at)', date('n'))
                                                   ->where('YEAR(created_at)', date('Y'))
                                                   ->count_all_results('user');

        // 4. Products & Inventory Metrics
        $data['product_count']          = $this->General_model->count_filtered_data('products');
        $data['active_products_count']  = $this->General_model->count_filtered_data('products', ['status' => 1]);
        $data['category_count']         = $this->General_model->count_filtered_data('categories');
        $data['out_of_stock_count']     = $this->General_model->count_filtered_data('products', ['stock <=' => 0]);
        $data['low_stock_count']        = $this->db->where('stock >', 0)->where('stock <=', 5)->count_all_results('products');

        // 4b. Coupons & Promotions Metrics
        $data['active_coupons_count']   = $this->General_model->count_filtered_data('coupons', ['status' => 1]);
        $coupon_stats = $this->db->select('COUNT(id) as total_redemptions, COALESCE(SUM(discount_amount), 0) as total_savings')
                                 ->get('coupon_usages')
                                 ->row();
        $data['total_coupon_savings']   = $coupon_stats ? (float)$coupon_stats->total_savings : 0.00;
        $data['total_coupon_uses']      = $coupon_stats ? (int)$coupon_stats->total_redemptions : 0;

        // 5. Recent 5 Online Orders
        $data['recent_orders'] = $this->db->select('id, order_number, shipping_full_name, shipping_mobile, shipping_city, total_amount, payment_method, payment_status, order_status, created_at')
                                          ->where('order_type', 'online')
                                          ->order_by('id', 'DESC')
                                          ->limit(5)
                                          ->get('orders')
                                          ->result();

        // 6. Recent 5 Registered Customers
        $data['recent_customers'] = $this->db->select('id, name, email, phone, status, profile_image, created_at')
                                            ->where('role', 0)
                                            ->order_by('id', 'DESC')
                                            ->limit(5)
                                            ->get('user')
                                            ->result();

        // 7. Top 5 Out of Stock Products
        $data['out_of_stock_products'] = $this->db->select('p.id, p.name, p.sku, p.price, p.discount_price, p.stock, p.image, p.status, c.name as category_name')
                                                 ->from('products p')
                                                 ->join('categories c', 'c.id = p.category_id', 'left')
                                                 ->where('p.stock <=', 0)
                                                 ->order_by('p.id', 'DESC')
                                                 ->limit(5)
                                                 ->get()
                                                 ->result();

        // Lowest stock products for inventory insights if none currently out of stock
        $data['lowest_stock_products'] = $this->db->select('p.id, p.name, p.sku, p.price, p.discount_price, p.stock, p.image, p.status, c.name as category_name')
                                                 ->from('products p')
                                                 ->join('categories c', 'c.id = p.category_id', 'left')
                                                 ->order_by('p.stock', 'ASC')
                                                 ->limit(5)
                                                 ->get()
                                                 ->result();

        // 8. Recent 5 Offline / Walk-in Orders
        $data['recent_offline_orders'] = $this->db->select('id, order_number, shipping_full_name, shipping_mobile, total_amount, payment_status, order_status, created_at')
                                                  ->where('order_type', 'offline')
                                                  ->order_by('id', 'DESC')
                                                  ->limit(5)
                                                  ->get('orders')
                                                  ->result();

        $data['title'] = 'Admin Dashboard - SRL Pixel LED\'s Glowing Hub';
        $data['breadcrumb'] = 'Dashboard';

        $this->load->view('admin/header', $data);
        $this->load->view('admin/dashboard_view', $data);
        $this->load->view('admin/footer', $data);
    }
}
