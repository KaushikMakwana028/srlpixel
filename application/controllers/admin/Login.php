<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Admin Login Page & Authentication
     */
    public function index()
    {
        // 1. If admin session is already stored, directly redirect to Admin Dashboard
        if ($this->session->userdata('admin_logged_in') && $this->session->userdata('admin_role') == 1) {
            redirect('admin/dashboard');
            return;
        }

        // 2. If logged in as customer, show friendly warning on admin login page
        if ($this->session->userdata('user_logged_in') && $this->session->userdata('user_role') == 0) {
            if (!$this->session->flashdata('error') && !$this->session->flashdata('warning')) {
                $this->session->set_flashdata('warning', 'You are currently signed in as a Customer. Please authenticate with Administrator credentials to enter Admin Panel.');
            }
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email', TRUE);
                $password = $this->input->post('password');

                // Retrieve admin user via General_model
                $admin = $this->General_model->getOne('user', ['email' => $email]);

                if ($admin) {
                    if ($admin->role != 1) {
                        $this->session->set_flashdata('error', 'Access Denied: This account is not authorized as an Administrator.');
                        redirect('admin/login');
                        return;
                    }

                    if ($admin->status == 0) {
                        $this->session->set_flashdata('error', 'Your administrator account has been deactivated.');
                        redirect('admin/login');
                        return;
                    }

                    if (password_verify($password, $admin->password)) {
                        // Unset any customer session data to prevent cross-role conflict
                        $this->session->unset_userdata(['user_id', 'user_name', 'user_email', 'user_role', 'user_profile_image', 'user_logged_in']);

                        // Establish persistent admin session
                        $session_data = [
                            'admin_id'            => $admin->id,
                            'admin_name'          => $admin->name,
                            'admin_email'         => $admin->email,
                            'admin_role'          => (int) $admin->role,
                            'admin_profile_image' => $admin->profile_image,
                            'admin_logged_in'     => TRUE
                        ];
                        $this->session->set_userdata($session_data);
                        $this->session->set_flashdata('success', 'Welcome back, ' . $admin->name . '! Signed in successfully.');
                        redirect('admin/dashboard');
                        return;
                    } else {
                        $this->session->set_flashdata('error', 'Incorrect password. Please verify and try again.');
                        redirect('admin/login');
                        return;
                    }
                } else {
                    $this->session->set_flashdata('error', 'No administrator account found with this email address.');
                    redirect('admin/login');
                    return;
                }
            }
        }

        $data['title'] = 'Admin Login - SRL Pixel LED\'s Glowing Hub';
        $data['auth_layout'] = true;

        $this->load->view('admin/header', $data);
        $this->load->view('admin/login_view', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Admin Register Page & Creation
     */
    public function register()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|max_length[150]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|max_length[30]');
            $this->form_validation->set_rules('address', 'Address', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $name     = $this->input->post('name', TRUE);
                $email    = $this->input->post('email', TRUE);
                $password = $this->input->post('password');
                $phone    = $this->input->post('phone', TRUE);
                $address  = $this->input->post('address', TRUE);

                // Verify email uniqueness using General_model
                $existing = $this->General_model->getOne('user', ['email' => $email]);
                if ($existing) {
                    $this->session->set_flashdata('error', 'This email address is already registered. Please sign in or use another email.');
                } else {
                    $insert_data = [
                        'name'       => $name,
                        'email'      => $email,
                        'password'   => password_hash($password, PASSWORD_BCRYPT),
                        'phone'      => $phone,
                        'address'    => $address,
                        'role'       => 1, // Admin role as required
                        'status'     => 1, // Active
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $user_id = $this->General_model->insert('user', $insert_data);
                    if ($user_id) {
                        $this->session->set_flashdata('success', 'Admin account registered successfully! You can now log in.');
                        redirect('admin/login');
                        return;
                    } else {
                        $this->session->set_flashdata('error', 'Failed to register administrator account. Please try again.');
                    }
                }
            }
        }

        $data['title'] = 'Admin Registration - SRL Pixel LED\'s Glowing Hub';
        $data['breadcrumb'] = 'Register Administrator';
        $data['auth_layout'] = false;

        $this->load->view('admin/header', $data);
        $this->load->view('admin/register_view', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Admin Logout
     */
    public function logout()
    {
        $this->session->unset_userdata(['admin_id', 'admin_name', 'admin_email', 'admin_role', 'admin_profile_image', 'admin_logged_in']);
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'You have been signed out safely.');
        redirect('admin/login');
    }
}
