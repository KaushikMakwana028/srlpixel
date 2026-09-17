<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Guard: check if customer is logged in
        if (!$this->session->userdata('user_logged_in') || $this->session->userdata('user_role') != 0) {
            $this->session->set_flashdata('error', 'Please sign in to access your customer profile.');
            redirect('login');
            return;
        }
    }

    /**
     * Customer Profile & Account Management
     */
    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $user = $this->General_model->getOne('user', ['id' => $user_id]);

        // Re-verify that the user is still valid and active in DB
        if (!$user || $user->status != 1) {
            $this->session->unset_userdata(['user_id', 'user_name', 'user_email', 'user_role', 'user_profile_image', 'user_logged_in']);
            $this->session->set_flashdata('error', 'Your session has expired or account is inactive.');
            redirect('login');
            return;
        }

        // Handle Profile Update POST (Profile Details + Optional Password Update)
        if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->input->post('action') === 'update_profile') {
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|max_length[150]');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|max_length[30]');

            $current_password = $this->input->post('current_password');
            $new_password     = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');

            $is_changing_password = !empty($current_password) || !empty($new_password) || !empty($confirm_password);

            if ($is_changing_password) {
                $this->form_validation->set_rules('current_password', 'Current Password', 'required');
                $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
                $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');
            }

            if ($this->form_validation->run() === TRUE) {
                $name  = $this->input->post('name', TRUE);
                $email = $this->input->post('email', TRUE);
                $phone = $this->input->post('phone', TRUE);

                // Check email uniqueness if modified
                if (strtolower($email) !== strtolower($user->email)) {
                    $existing = $this->General_model->getOne('user', ['email' => $email, 'id !=' => $user_id]);
                    if ($existing) {
                        $this->session->set_flashdata('error', 'The email address ' . html_escape($email) . ' is already registered with another account.');
                        redirect('profile?tab=profile');
                        return;
                    }
                }

                // If user is attempting to change password, verify current password first
                if ($is_changing_password) {
                    if (!password_verify($current_password, $user->password)) {
                        $this->session->set_flashdata('error', 'The current password you entered is incorrect.');
                        redirect('profile?tab=profile');
                        return;
                    }
                }

                // Handle Profile Image Upload (Max 2MB)
                $profile_image = $user->profile_image;
                if (!empty($_FILES['profile_image']['name'])) {
                    $upload_path = './uploads/profiles/';
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, true);
                    }

                    $config['upload_path']   = $upload_path;
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp';
                    $config['max_size']      = 2048; // Max 2MB strictly
                    $config['encrypt_name']  = TRUE;

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('profile_image')) {
                        // Delete old profile picture if exists
                        if (!empty($user->profile_image) && file_exists($upload_path . $user->profile_image)) {
                            @unlink($upload_path . $user->profile_image);
                        }
                        $upload_data   = $this->upload->data();
                        $profile_image = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('profile?tab=profile');
                        return;
                    }
                }

                $update_data = [
                    'name'          => $name,
                    'email'         => $email,
                    'phone'         => $phone,
                    'profile_image' => $profile_image,
                    'updated_at'    => date('Y-m-d H:i:s')
                ];

                if ($is_changing_password) {
                    $update_data['password'] = password_hash($new_password, PASSWORD_BCRYPT);
                }

                $this->General_model->update('user', ['id' => $user_id], $update_data);

                // Update session info
                $this->session->set_userdata([
                    'user_name'          => $name,
                    'user_email'         => $email,
                    'user_profile_image' => $profile_image
                ]);

                $success_msg = $is_changing_password ? 'Profile and password updated successfully!' : 'Profile updated successfully!';
                $this->session->set_flashdata('success', $success_msg);
                redirect('profile?tab=profile');
                return;
            } else {
                $this->session->set_flashdata('error', validation_errors('', ''));
                redirect('profile?tab=profile');
                return;
            }
        }

        // Fetch user addresses (Default first)
        $this->db->order_by('is_default DESC, id DESC');
        $data['addresses'] = $this->General_model->getAll('user_addresses', ['user_id' => $user_id]);

        // Fetch user orders with pagination (Newest first, 5 per page)
        $orders_limit = 5;
        $orders_page = max(1, (int)$this->input->get('page'));
        $orders_total = $this->General_model->count_filtered_data('orders', ['user_id' => $user_id]);
        $orders_total_pages = max(1, ceil($orders_total / $orders_limit));
        if ($orders_page > $orders_total_pages && $orders_total > 0) {
            $orders_page = $orders_total_pages;
        }
        $orders_offset = ($orders_page - 1) * $orders_limit;

        $data['orders'] = $this->General_model->get_paginated_data('orders', ['user_id' => $user_id], [], $orders_limit, $orders_offset, 'id DESC');
        $data['orders_total'] = $orders_total;
        $data['orders_page'] = $orders_page;
        $data['orders_limit'] = $orders_limit;
        $data['orders_offset'] = $orders_offset;
        $data['orders_total_pages'] = $orders_total_pages;

        $data['active_tab'] = $this->input->get('tab') ? $this->input->get('tab') : ($this->input->get('page') ? 'orders' : 'profile');
        $data['user'] = $user;
        $data['title'] = 'My Profile & Account - SRL Pixel';

        $this->load->view('header', $data);
        $this->load->view('profile_view', $data);
        $this->load->view('footer', $data);
    }

    /**
     * Add New Shipping/Delivery Address
     */
    public function add_address()
    {
        $user_id = (int)$this->session->userdata('user_id');

        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|max_length[15]');
        $this->form_validation->set_rules('address_line1', 'Address Line 1', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('address_line2', 'Address Line 2', 'trim|max_length[255]');
        $this->form_validation->set_rules('landmark', 'Landmark', 'trim|max_length[150]');
        $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('country', 'Country', 'trim|max_length[100]');

        if ($this->form_validation->run() === FALSE) {
            $err = validation_errors('', '');
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => $err]));
                return;
            }
            $this->session->set_flashdata('error', $err);
            redirect('profile?tab=addresses');
            return;
        }

        $is_default = $this->input->post('is_default') ? 1 : 0;

        // If this is the user's first address, force it to be default
        $existing_count = $this->General_model->count_filtered_data('user_addresses', ['user_id' => $user_id]);
        if ($existing_count == 0) {
            $is_default = 1;
        }

        // If new address is set as default, remove default from all others
        if ($is_default == 1) {
            $this->General_model->update('user_addresses', ['user_id' => $user_id], ['is_default' => 0]);
        }

        $address_data = [
            'user_id'       => $user_id,
            'full_name'     => $this->input->post('full_name', TRUE),
            'mobile'        => $this->input->post('mobile', TRUE),
            'address_line1' => $this->input->post('address_line1', TRUE),
            'address_line2' => $this->input->post('address_line2', TRUE),
            'landmark'      => $this->input->post('landmark', TRUE),
            'city'          => $this->input->post('city', TRUE),
            'state'         => $this->input->post('state', TRUE),
            'pincode'       => $this->input->post('pincode', TRUE),
            'country'       => $this->input->post('country', TRUE) ? $this->input->post('country', TRUE) : 'India',
            'is_default'    => $is_default,
            'created_at'    => date('Y-m-d H:i:s')
        ];

        $insert_id = $this->General_model->insert('user_addresses', $address_data);

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success'    => true,
                'message'    => 'New address added successfully!',
                'address_id' => $insert_id
            ]));
            return;
        }

        $this->session->set_flashdata('success', 'New address added successfully!');
        $redirect_to = $this->input->post('redirect_to') ? $this->input->post('redirect_to') : 'profile?tab=addresses';
        redirect($redirect_to);
    }

    /**
     * Edit Shipping/Delivery Address
     */
    public function edit_address($id = NULL)
    {
        $user_id = (int)$this->session->userdata('user_id');
        $address = $this->General_model->getOne('user_addresses', ['id' => (int)$id, 'user_id' => $user_id]);

        if (!$address) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Address not found.']));
                return;
            }
            $this->session->set_flashdata('error', 'Address not found.');
            redirect('profile?tab=addresses');
            return;
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[150]');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|max_length[15]');
            $this->form_validation->set_rules('address_line1', 'Address Line 1', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|max_length[20]');

            if ($this->form_validation->run() === TRUE) {
                $is_default = $this->input->post('is_default') ? 1 : 0;
                if ($is_default == 1) {
                    $this->General_model->update('user_addresses', ['user_id' => $user_id], ['is_default' => 0]);
                }

                $update_data = [
                    'full_name'     => $this->input->post('full_name', TRUE),
                    'mobile'        => $this->input->post('mobile', TRUE),
                    'address_line1' => $this->input->post('address_line1', TRUE),
                    'address_line2' => $this->input->post('address_line2', TRUE),
                    'landmark'      => $this->input->post('landmark', TRUE),
                    'city'          => $this->input->post('city', TRUE),
                    'state'         => $this->input->post('state', TRUE),
                    'pincode'       => $this->input->post('pincode', TRUE),
                    'country'       => $this->input->post('country', TRUE) ? $this->input->post('country', TRUE) : 'India',
                    'is_default'    => $is_default,
                    'updated_at'    => date('Y-m-d H:i:s')
                ];

                $this->General_model->update('user_addresses', ['id' => $address->id], $update_data);

                if ($this->input->is_ajax_request()) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true, 'message' => 'Address updated successfully!']));
                    return;
                }

                $this->session->set_flashdata('success', 'Address updated successfully!');
                redirect('profile?tab=addresses');
                return;
            } else {
                $err = validation_errors('', '');
                if ($this->input->is_ajax_request()) {
                    $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => $err]));
                    return;
                }
                $this->session->set_flashdata('error', $err);
                redirect('profile?tab=addresses');
                return;
            }
        }

        // GET request via AJAX to fetch address for edit modal
        $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true, 'address' => $address]));
    }

    /**
     * Delete Address
     */
    public function delete_address($id = NULL)
    {
        $user_id = (int)$this->session->userdata('user_id');
        $address = $this->General_model->getOne('user_addresses', ['id' => (int)$id, 'user_id' => $user_id]);

        if ($address) {
            $was_default = $address->is_default;
            $this->General_model->delete('user_addresses', ['id' => $address->id]);

            // If the deleted address was default, promote the newest remaining address to default
            if ($was_default) {
                $this->db->order_by('id DESC');
                $next = $this->General_model->getOne('user_addresses', ['user_id' => $user_id]);
                if ($next) {
                    $this->General_model->update('user_addresses', ['id' => $next->id], ['is_default' => 1]);
                }
            }

            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true, 'message' => 'Address deleted successfully.']));
                return;
            }

            $this->session->set_flashdata('success', 'Address removed.');
        } else {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Address not found.']));
                return;
            }
            $this->session->set_flashdata('error', 'Address not found.');
        }

        redirect('profile?tab=addresses');
    }

    /**
     * Set an address as default
     */
    public function set_default_address($id = NULL)
    {
        $user_id = (int)$this->session->userdata('user_id');
        $address = $this->General_model->getOne('user_addresses', ['id' => (int)$id, 'user_id' => $user_id]);

        if ($address) {
            // Reset all other addresses of this user
            $this->General_model->update('user_addresses', ['user_id' => $user_id], ['is_default' => 0]);
            // Set this address as default
            $this->General_model->update('user_addresses', ['id' => $address->id], ['is_default' => 1]);

            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['success' => true, 'message' => 'Default delivery address updated!']));
                return;
            }

            $this->session->set_flashdata('success', 'Default address set successfully.');
        } else {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Address not found.']));
                return;
            }
            $this->session->set_flashdata('error', 'Address not found.');
        }

        redirect('profile?tab=addresses');
    }

    /**
     * Customer Order Details Page
     */
    public function order($id = NULL)
    {
        $user_id = (int)$this->session->userdata('user_id');
        $order = $this->General_model->getOne('orders', ['id' => (int)$id, 'user_id' => $user_id]);

        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found or unauthorized.');
            redirect('profile?tab=orders');
            return;
        }

        $items = $this->General_model->getAll('order_items', ['order_id' => $order->id]);

        $data['order'] = $order;
        $data['items'] = $items;
        $data['title'] = 'Order Details #' . $order->order_number . ' - SRL Pixel';

        $this->load->view('header', $data);
        $this->load->view('order_detail_view', $data);
        $this->load->view('footer', $data);
    }

    /**
     * Change Customer Password
     */
    public function change_password()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $user_id = $this->session->userdata('user_id');
            $user = $this->General_model->getOne('user', ['id' => $user_id]);

            $this->form_validation->set_rules('current_password', 'Current Password', 'required');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');

            if ($this->form_validation->run() === TRUE) {
                $current_password = $this->input->post('current_password');
                $new_password     = $this->input->post('new_password');

                if (!password_verify($current_password, $user->password)) {
                    $this->session->set_flashdata('error', 'The current password you entered is incorrect.');
                    redirect('profile?tab=profile');
                    return;
                }

                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
                $this->General_model->update('user', ['id' => $user_id], [
                    'password'   => $hashed_password,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $this->session->set_flashdata('success', 'Password updated successfully!');
                redirect('profile?tab=profile');
                return;
            } else {
                $this->session->set_flashdata('error', validation_errors('', ''));
                redirect('profile?tab=profile');
                return;
            }
        }

        redirect('profile?tab=profile');
    }
}

