<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * LOGIN - Step 1: Enter Mobile Number
     */
    public function index()
    {
        if ($this->session->userdata('user_logged_in')) {
            redirect('home');
            return;
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('phone', 'Mobile Number', 'trim|required|numeric|min_length[10]|max_length[15]');

            if ($this->form_validation->run() === TRUE) {
                $phone = $this->input->post('phone', TRUE);

                $user = $this->General_model->getOne('user', ['phone' => $phone]);

                if (!$user) {
                    $this->session->set_flashdata('error', 'No account found with this mobile number. Please register first.');
                    redirect('login');
                    return;
                }

                if ($user->role == 1) {
                    $this->session->set_flashdata('error', 'This number belongs to an Administrator account. Please log in via the Admin Portal.');
                    redirect('login');
                    return;
                }

                if ($user->status == 0) {
                    $this->session->set_flashdata('error', 'Your customer account is currently inactive. Please contact support.');
                    redirect('login');
                    return;
                }

                // Generate 6 digit OTP (Default: 123456 for testing | Uncomment random_int for production)
                $otp = 123456;
                // $otp = random_int(100000, 999999);

                // Store OTP in session
                $this->session->set_userdata('otp_session', [
                    'type'             => 'login',
                    'user_id'          => $user->id,
                    'phone'            => $user->phone,
                    'otp'              => $otp,
                    'otp_expiry'       => time() + 600,
                    'otp_attempts'     => 0,
                    'otp_generated_at' => time()
                ]);

                // Send OTP (Commented for testing - uncomment line below for real-time OTP via SMS)
                $sms_result = true;
                // $sms_result = $this->send_otp_via_sms($user->phone, (string) $otp);

                if ($sms_result) {
                $this->session->set_flashdata(
                'success',
                'OTP sent to your registered mobile number.'
                );

                redirect('verify-otp');
                return;
                } else {
                $this->session->unset_userdata('otp_session');

                $this->session->set_flashdata(
                'error',
                'Failed to send OTP. Please try again.'
                );

                redirect('login');
                return;
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
     * REGISTER - Step 1: Enter Details
     */
    public function register()
    {
        if ($this->session->userdata('user_logged_in')) {
            redirect('home');
            return;
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('name', 'Full Name', 'trim|required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|max_length[150]');
            $this->form_validation->set_rules('phone', 'Mobile Number', 'trim|required|numeric|min_length[10]|max_length[15]');

            if ($this->form_validation->run() === TRUE) {
                $name  = $this->input->post('name', TRUE);
                $email = $this->input->post('email', TRUE);
                $phone = $this->input->post('phone', TRUE);

                $existing_phone = $this->General_model->getOne('user', ['phone' => $phone]);
                $existing_email = $this->General_model->getOne('user', ['email' => $email]);

                if ($existing_phone) {
                    $this->session->set_flashdata('error', 'This mobile number is already registered. Please sign in instead.');
                    redirect('register');
                    return;
                }

                if ($existing_email) {
                    $this->session->set_flashdata('error', 'This email address is already registered. Please sign in instead.');
                    redirect('register');
                    return;
                }

                // Generate & send OTP
                // Generate 6 digit OTP (Default: 123456 for testing | Uncomment random_int for production)
                $otp = 123456;
                // $otp = random_int(100000, 999999);

                // Store OTP in session
                $this->session->set_userdata('otp_session', [
                    'type'             => 'register',
                    'name'             => $name,
                    'email'            => $email,
                    'phone'            => $phone,
                    'otp'              => $otp,
                    'otp_expiry'       => time() + 600,
                    'otp_attempts'     => 0,
                    'otp_generated_at' => time()
                ]);

                // Send OTP (Commented for testing - uncomment line below for real-time OTP via SMS)
                $sms_result = true;
                // $sms_result = $this->send_otp_via_sms($phone, (string) $otp);

if ($sms_result) {
    $this->session->set_flashdata(
        'success',
        'OTP sent to your mobile number.'
    );

    redirect('verify-otp');
    return;
} else {
    $this->session->unset_userdata('otp_session');

    $this->session->set_flashdata(
        'error',
        'Failed to send OTP. Please try again.'
    );

    redirect('register');
    return;
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
     * SHARED OTP VERIFICATION (Login + Register)
     */
    public function verify_otp()
    {
        if ($this->session->userdata('user_logged_in')) {
            redirect('home');
            return;
        }

        $otp_session = $this->session->userdata('otp_session');

        if (!$otp_session) {
            $this->session->set_flashdata('error', 'Session expired. Please try again.');
            redirect('login');
            return;
        }

        $type = $otp_session['type']; // 'login' or 'register'

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $entered_otp = trim($this->input->post('otp'));

            // Expiry check
            if (time() > $otp_session['otp_expiry']) {
                $this->session->unset_userdata('otp_session');
                $this->session->set_flashdata('error', 'OTP expired. Please try again.');
                redirect($type === 'register' ? 'register' : 'login');
                return;
            }

            // Attempts check
            if ($otp_session['otp_attempts'] >= 5) {
                $this->session->unset_userdata('otp_session');
                $this->session->set_flashdata('error', 'Too many failed attempts. Please try again.');
                redirect($type === 'register' ? 'register' : 'login');
                return;
            }

            // Validate OTP
            if ($entered_otp !== '' && $entered_otp == $otp_session['otp']) {

                if ($type === 'login') {
                    // ===== LOGIN FLOW =====
                    $user = $this->General_model->getOne('user', ['id' => $otp_session['user_id']]);
                    $this->session->unset_userdata('otp_session');

                    if (!$user) {
                        $this->session->set_flashdata('error', 'Account not found. Please try again.');
                        redirect('login');
                        return;
                    }

                    $this->_do_login($user);
                    return;

                } else {
                    // ===== REGISTER FLOW =====
                    $insert_data = [
                        'name'       => $otp_session['name'],
                        'email'      => $otp_session['email'],
                        'phone'      => $otp_session['phone'],
                        'password'   => password_hash(bin2hex(random_bytes(8)), PASSWORD_BCRYPT), // placeholder, unused
                        'address'    => NULL,
                        'role'       => 0,
                        'status'     => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $user_id = $this->General_model->insert('user', $insert_data);
                    $this->session->unset_userdata('otp_session');

                    if (!$user_id) {
                        $this->session->set_flashdata('error', 'Account creation failed. Please try again.');
                        redirect('register');
                        return;
                    }

                    $user = $this->General_model->getOne('user', ['id' => $user_id]);
                    $this->session->set_flashdata('success', 'Account created successfully! Welcome, ' . $user->name . '!');
                    $this->_do_login($user);
                    return;
                }

            } else {
                $otp_session['otp_attempts'] += 1;
                $this->session->set_userdata('otp_session', $otp_session);
                $this->session->set_flashdata('error', 'Invalid OTP. Please try again.');
            }
        }

        $data['title']        = 'Verify OTP - SRL Pixel LED\'s Glowing Hub';
        $data['auth_layout']  = true;
        $data['otp_type']     = $type;
        $data['masked_phone'] = substr($otp_session['phone'], 0, 2) . str_repeat('*', max(0, strlen($otp_session['phone']) - 4)) . substr($otp_session['phone'], -2);
        $data['resend_wait']  = max(0, 60 - (time() - $otp_session['otp_generated_at']));

        $this->load->view('header', $data);
        $this->load->view('verify_otp_view', $data);
        $this->load->view('footer', $data);
    }

    /**
     * RESEND OTP (AJAX) - Shared for Login + Register
     */
    public function resend_otp()
    {
        $otp_session = $this->session->userdata('otp_session');

        if (!$otp_session) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success'  => false,
                'message'  => 'Session expired. Please try again.',
                'redirect' => base_url('login')
            ]));
            return;
        }

        $elapsed = time() - $otp_session['otp_generated_at'];
        if ($elapsed < 60) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Please wait ' . (60 - $elapsed) . ' seconds before resending.'
            ]));
            return;
        }

        // Generate 6 digit OTP (Default: 123456 for testing | Uncomment random_int for production)
        $otp = 123456;
        // $otp = random_int(100000, 999999);

        $otp_session['otp'] = $otp;
        $otp_session['otp_expiry'] = time() + 600;
        $otp_session['otp_generated_at'] = time();
        $otp_session['otp_attempts'] = 0;
        $this->session->set_userdata('otp_session', $otp_session);

        // Send OTP (Commented for testing - uncomment line below for real-time OTP via SMS)
        $sms_result = true;
        // $sms_result = $this->send_otp_via_sms($otp_session['phone'], (string) $otp);

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'success' => $sms_result,
            'message' => $sms_result ? 'OTP resent successfully to your mobile.' : 'Failed to send OTP. Please try again.'
        ]));
    }

    /**
     * Helper: Set session & redirect after successful verification
     */
    private function _do_login($user)
    {
        $session_data = [
            'user_id'            => $user->id, 
            'user_name'          => $user->name,
            'user_email'         => $user->email,
            'user_role'          => (int) $user->role,
            'user_profile_image' => $user->profile_image,
            'user_logged_in'     => TRUE
        ];
        $this->session->set_userdata($session_data);

        if (!$this->session->flashdata('success')) {
            $this->session->set_flashdata('success', 'Welcome back, ' . $user->name . '!');
        }

        $redirect_target = $this->session->userdata('redirect_after_login') ?: 'home';
        $this->session->unset_userdata('redirect_after_login');
        redirect($redirect_target);
    }

    /**
     * Customer Logout
     */
    public function logout()
    {
        $this->session->unset_userdata(['user_id', 'user_name', 'user_email', 'user_role', 'user_profile_image', 'user_logged_in']);
        redirect('login');
    }

    private function send_otp_via_sms(string $mobileNo, string $otp): bool
    {
        $message = "Hi $mobileNo\n\nYour Verification OTP is $otp Do not share this OTP with anyone for security reasons.\n\nRegards\nOMKARENT";

        $params = [
            'user'     => 'Fitcketsp',
            'key'      => '81a6b2f99cXX',
            'mobile'   => '91' . $mobileNo,
            'message'  => $message,
            'senderid' => 'OENTER',
            'accusage' => '1',
            'entityid' => '1401487200000053882',
            'tempid'   => '1407168611506367587',
        ];

        $url = 'http://mobicomm.dove-sms.com/submitsms.jsp?' . http_build_query($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            log_message('error', 'OTP SMS cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        curl_close($ch);
        log_message('info', "OTP sent to $mobileNo. Response: $response");

        return true;
    }
}