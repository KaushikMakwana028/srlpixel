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
        $data['member_count'] = $this->General_model->getCount('user', ['role' => 0]);
        $data['product_count'] = $this->General_model->getCount('products');
        $data['category_count'] = $this->General_model->getCount('categories');
        $data['title'] = 'Admin Dashboard - SRL Pixel LED\'s Glowing Hub';
        $data['breadcrumb'] = 'Dashboard';

        $this->load->view('admin/header', $data);
        $this->load->view('admin/dashboard_view', $data);
        $this->load->view('admin/footer', $data);
    }
}
