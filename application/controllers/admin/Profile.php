<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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
     * Admin Profile Settings & Info Update
     */
    public function index()
    {
        $admin_id = $this->session->userdata('admin_id');
        $admin = $this->General_model->getOne('user', ['id' => $admin_id]);

        if (!$admin) {
            $this->session->set_flashdata('error', 'Administrator account not found.');
            redirect('admin/login');
            return;
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|max_length[150]');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|max_length[30]');
            $this->form_validation->set_rules('address', 'Address', 'trim');

            if ($this->form_validation->run() === TRUE) {
                $name    = $this->input->post('name', TRUE);
                $email   = $this->input->post('email', TRUE);
                $phone   = $this->input->post('phone', TRUE);
                $address = $this->input->post('address', TRUE);

                // Check for duplicate email on other users
                $existing = $this->General_model->getOne('user', ['email' => $email, 'id !=' => $admin_id]);
                if ($existing) {
                    $this->session->set_flashdata('error', 'This email address is already assigned to another account.');
                    redirect('admin/profile');
                    return;
                }

                // Handle Profile Image Upload (Max 2MB)
                $profile_image = $admin->profile_image;
                if (!empty($_FILES['profile_image']['name'])) {
                    $config['upload_path']   = './uploads/profiles/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                    $config['max_size']      = 2048; // Max 2MB
                    $config['encrypt_name']  = TRUE;

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('profile_image')) {
                        // Delete old profile picture if exists
                        if (!empty($admin->profile_image) && file_exists('./uploads/profiles/' . $admin->profile_image)) {
                            @unlink('./uploads/profiles/' . $admin->profile_image);
                        }
                        $upload_data   = $this->upload->data();
                        $profile_image = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('admin/profile');
                        return;
                    }
                }

                $update_data = [
                    'name'          => $name,
                    'email'         => $email,
                    'phone'         => $phone,
                    'address'       => $address,
                    'profile_image' => $profile_image,
                    'updated_at'    => date('Y-m-d H:i:s')
                ];

                $this->General_model->update('user', ['id' => $admin_id], $update_data);

                // Update active session metadata
                $this->session->set_userdata([
                    'admin_name'          => $name,
                    'admin_email'         => $email,
                    'admin_profile_image' => $profile_image,
                    'admin_address'       => $address
                ]);

                $this->session->set_flashdata('success', 'Profile information updated successfully.');
                redirect('admin/profile');
                return;
            }
        }

        $data['title'] = 'Admin Profile Settings - SRL Pixel';
        $data['breadcrumb'] = 'Profile Settings';
        $data['admin'] = $admin;
        $data['active_tab'] = $this->input->get('tab') === 'password' ? 'password' : 'info';

        $this->load->view('admin/header', $data);
        $this->load->view('admin/profile_view', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Change Administrator Password
     */
    public function change_password()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('current_password', 'Current Password', 'required');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');

            if ($this->form_validation->run() === TRUE) {
                $admin_id = $this->session->userdata('admin_id');
                $admin = $this->General_model->getOne('user', ['id' => $admin_id]);

                $current_password = $this->input->post('current_password');
                $new_password     = $this->input->post('new_password');

                if ($admin && password_verify($current_password, $admin->password)) {
                    $update_data = [
                        'password'   => password_hash($new_password, PASSWORD_BCRYPT),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $this->General_model->update('user', ['id' => $admin_id], $update_data);
                    $this->session->set_flashdata('success', 'Your password has been changed successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Your current password is incorrect. Please try again.');
                }
            } else {
                $this->session->set_flashdata('error', validation_errors('', ''));
            }
        }

        redirect('admin/profile?tab=password');
    }
}
