<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Libraries, helpers, and General_model are autoloaded
    }

    /**
     * Customer Login Page & Authentication
     */
    public function index()
    {
        // If already logged in as Customer, redirect to Home
        if ($this->session->userdata('user_logged_in')) {
            redirect('home');
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() === TRUE) {
                $email = $this->input->post('email', TRUE);
                $password = $this->input->post('password');

                // Retrieve user using General_model
                $user = $this->General_model->getOne('user', ['email' => $email]);

                if ($user) {
                    if ($user->role == 1) {
                        $this->session->set_flashdata('error', 'This email belongs to an Administrator account. Please log in via the Admin Portal.');
                        redirect('login');
                    }

                    if ($user->status == 0) {
                        $this->session->set_flashdata('error', 'Your customer account is currently inactive. Please contact support.');
                        redirect('login');
                    }

                    if (password_verify($password, $user->password)) {
                        $session_data = [
                            'user_id'            => $user->id,
                            'user_name'          => $user->name,
                            'user_email'         => $user->email,
                            'user_role'          => (int) $user->role,
                            'user_profile_image' => $user->profile_image,
                            'user_logged_in'     => TRUE
                        ];
                        $this->session->set_userdata($session_data);
                        $this->session->set_flashdata('success', 'Welcome back, ' . $user->name . '!');

                        // If user intended to go to cart or product after login
                        $redirect_target = $this->session->userdata('redirect_after_login') ?: 'home';
                        $this->session->unset_userdata('redirect_after_login');
                        redirect($redirect_target);
                    } else {
                        $this->session->set_flashdata('error', 'Invalid email or password.');
                        redirect('login');
                    }
                } else {
                    $this->session->set_flashdata('error', 'No customer account found with this email.');
                    redirect('login');
                }
            }
        }

        $data['title'] = 'Customer Login - SRL Pixel LED\'s Glowing Hub';
        $data['auth_layout'] = true;

        $this->load->view('header', $data);
        $this->load->view('login_view', $data);
        $this->load->view('footer', $data);
    }

    /**
     * Customer Registration Page & Creation
     */
    public function register()
    {
        if ($this->session->userdata('user_logged_in')) {
            redirect('home');
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|max_length[150]');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

            if ($this->form_validation->run() === TRUE) {
                $name     = $this->input->post('name', TRUE);
                $email    = $this->input->post('email', TRUE);
                $phone    = $this->input->post('phone', TRUE);
                $password = $this->input->post('password');

                // Verify email uniqueness using General_model
                $existing = $this->General_model->getOne('user', ['email' => $email]);
                if ($existing) {
                    $this->session->set_flashdata('error', 'This email address is already registered. Please sign in instead.');
                } else {
                    $insert_data = [
                        'name'       => $name,
                        'email'      => $email,
                        'password'   => password_hash($password, PASSWORD_BCRYPT),
                        'phone'      => $phone,
                        'address'    => NULL,
                        'role'       => 0, // Default role 0 for customer
                        'status'     => 1, // Active
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $user_id = $this->General_model->insert('user', $insert_data);
                    if ($user_id) {
                        $this->session->set_flashdata('success', 'Account created successfully! Please sign in with your credentials.');
                        redirect('login');
                    } else {
                        $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                    }
                }
            }
        }

        $data['title'] = 'Customer Registration - SRL Pixel LED\'s Glowing Hub';
        $data['auth_layout'] = true;

        $this->load->view('header', $data);
        $this->load->view('register_view', $data);
        $this->load->view('footer', $data);
    }

    /**
     * Customer Logout
     */
    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'user_name', 'user_email', 'user_role', 'user_profile_image', 'user_logged_in']);
        redirect('login');
    }
}
