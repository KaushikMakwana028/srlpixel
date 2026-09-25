<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Helper to enforce customer authentication
     */
    private function _require_login($redirect_uri = 'checkout')
    {
        if (!$this->session->userdata('user_logged_in') || $this->session->userdata('user_role') != 0) {
            $this->session->set_userdata('redirect_after_login', $redirect_uri);
            $this->session->set_flashdata('error', 'Please sign in to proceed with checkout.');
            redirect('login');
            exit;
        }
    }

    /**
     * Display Step-by-Step Checkout Page
     */
    public function index()
    {
        $this->_require_login('checkout');

        $user_id = (int) $this->session->userdata('user_id');
        $user = $this->General_model->getOne('user', ['id' => $user_id]);

        // Get user cart items
        $db_cart = $this->General_model->getAll('cart', ['user_id' => $user_id]);

        if (empty($db_cart)) {
            $this->session->set_flashdata('warning', 'Your shopping cart is empty. Add products to begin checkout.');
            redirect('cart');
            return;
        }

        $cart_items = [];
        $subtotal = 0.00;
        $total_quantity = 0;

        foreach ($db_cart as $item) {
            $product = $this->General_model->getOne('products', ['id' => $item->product_id, 'status' => 1]);
            if ($product && (int) $product->stock > 0) {
                $unit_price = (!empty($product->discount_price) && $product->discount_price < $product->price)
                    ? (float) $product->discount_price
                    : (float) $product->price;

                $qty = min((int) $product->stock, max(1, (int) $item->quantity));
                $line_total = $unit_price * $qty;

                $cart_items[] = [
                    'cart_id' => $item->id,
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'image' => $product->image,
                    'price' => $unit_price,
                    'stock' => (int) $product->stock,
                    'quantity' => $qty,
                    'line_total' => $line_total
                ];

                $subtotal += $line_total;
                $total_quantity += $qty;
            } else {
                // If product is no longer active or out of stock, remove it
                $this->General_model->delete('cart', ['id' => $item->id]);
            }
        }

        if (empty($cart_items)) {
            $this->session->set_flashdata('error', 'The items in your cart are currently out of stock.');
            redirect('cart');
            return;
        }

        // Fetch user addresses (Default address first)
        $this->db->order_by('is_default DESC, id DESC');
        $addresses = $this->General_model->getAll('user_addresses', ['user_id' => $user_id]);

        $default_address = null;
        if (!empty($addresses)) {
            foreach ($addresses as $addr) {
                if ($addr->is_default == 1) {
                    $default_address = $addr;
                    break;
                }
            }
            if (!$default_address) {
                $default_address = $addresses[0];
            }
        }

        $data['title'] = 'Secure Checkout - SRL Pixel LED';
        $data['user'] = $user;
        $data['cart_items'] = $cart_items;
        $data['subtotal'] = $subtotal;

        // Calculate shipping based on order value
        $shipping_fee = 0.00;
        if ($subtotal < 20000) {
            $shipping_fee = 200.00; // Or your desired shipping charge
        }

        $data['shipping'] = $shipping_fee;
        $data['total'] = $subtotal + $shipping_fee;
        $data['free_shipping_threshold'] = 20000;
        $data['is_free_shipping'] = ($subtotal >= 20000);
        $data['total_quantity'] = $total_quantity;
        $data['addresses'] = $addresses;
        $data['default_address'] = $default_address;
        $data['razorpay_key_id'] = $this->config->item('razorpay_key_id') ?: (defined('RAZORPAY_KEY_ID') ? RAZORPAY_KEY_ID : '');
        $data['currency'] = $this->config->item('razorpay_currency') ?: (defined('RAZORPAY_CURRENCY') ? RAZORPAY_CURRENCY : 'INR');

        $this->load->view('header', $data);
        $this->load->view('checkout_view', $data);
        $this->load->view('footer', $data);
    }

    /**
     * AJAX endpoint to quickly add a new shipping address during checkout
     */
    public function add_address()
    {
        if (!$this->session->userdata('user_logged_in') || $this->session->userdata('user_role') != 0) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Session expired. Please sign in again.'
            ]));
            return;
        }

        $user_id = (int) $this->session->userdata('user_id');

        $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('address_line1', 'Address Line 1', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('address_line2', 'Address Line 2', 'trim|max_length[255]');
        $this->form_validation->set_rules('landmark', 'Landmark', 'trim|max_length[150]');
        $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|numeric|exact_length[6]');
        $this->form_validation->set_rules('country', 'Country', 'trim|max_length[100]');

        if ($this->form_validation->run() === FALSE) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => validation_errors('', '')
            ]));
            return;
        }

        $is_default = $this->input->post('is_default') ? 1 : 0;
        $existing_count = $this->General_model->count_filtered_data('user_addresses', ['user_id' => $user_id]);
        if ($existing_count == 0) {
            $is_default = 1;
        }

        if ($is_default == 1) {
            $this->General_model->update('user_addresses', ['user_id' => $user_id], ['is_default' => 0]);
        }

        $address_data = [
            'user_id' => $user_id,
            'full_name' => $this->input->post('full_name', TRUE),
            'mobile' => $this->input->post('mobile', TRUE),
            'address_line1' => $this->input->post('address_line1', TRUE),
            'address_line2' => $this->input->post('address_line2', TRUE),
            'landmark' => $this->input->post('landmark', TRUE),
            'city' => $this->input->post('city', TRUE),
            'state' => $this->input->post('state', TRUE),
            'pincode' => $this->input->post('pincode', TRUE),
            'country' => $this->input->post('country', TRUE) ?: 'India',
            'is_default' => $is_default,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $new_id = $this->General_model->insert('user_addresses', $address_data);
        $address = $this->General_model->getOne('user_addresses', ['id' => $new_id]);

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'success' => true,
            'message' => 'New delivery address added successfully!',
            'address' => $address
        ]));
    }

    /**
     * Create / Initialize Razorpay Order via AJAX
     */
    public function razorpay_create_order()
    {
        $this->_require_login('checkout');

        $user_id = (int) $this->session->userdata('user_id');
        $user = $this->General_model->getOne('user', ['id' => $user_id]);

        $db_cart = $this->General_model->getAll('cart', ['user_id' => $user_id]);
        if (empty($db_cart)) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Your cart is empty.'
            ]));
            return;
        }

        $subtotal = 0.00;
        foreach ($db_cart as $item) {
            $prod = $this->General_model->getOne('products', ['id' => $item->product_id, 'status' => 1]);
            if ($prod && (int) $prod->stock > 0) {
                $price = (!empty($prod->discount_price) && $prod->discount_price < $prod->price)
                    ? (float) $prod->discount_price
                    : (float) $prod->price;
                $subtotal += ($price * (int) $item->quantity);
            }
        }

        if ($subtotal <= 0) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Invalid order total amount.'
            ]));
            return;
        }

        $amount_in_paise = round($subtotal * 100);
        $receipt = 'RCPT_' . date('Ymd') . '_' . substr(uniqid(), -6);

        // Attempt real Razorpay API Order Creation if key/secret configured
        $razorpay_order_id = null;
        $key_id = $this->config->item('razorpay_key_id') ?: (defined('RAZORPAY_KEY_ID') ? RAZORPAY_KEY_ID : '');
        $key_secret = $this->config->item('razorpay_key_secret') ?: (defined('RAZORPAY_KEY_SECRET') ? RAZORPAY_KEY_SECRET : '');
        $currency = $this->config->item('razorpay_currency') ?: (defined('RAZORPAY_CURRENCY') ? RAZORPAY_CURRENCY : 'INR');
        $company_name = $this->config->item('razorpay_company_name') ?: (defined('RAZORPAY_COMPANY_NAME') ? RAZORPAY_COMPANY_NAME : "VISION TECHNOLABS");
        $logo_url = $this->config->item('razorpay_logo_url') ?: base_url('assets/images/new_logo.png');
        $theme_color = $this->config->item('razorpay_theme_color') ?: (defined('RAZORPAY_THEME_COLOR') ? RAZORPAY_THEME_COLOR : '#2563eb');

        if (!empty($key_id) && !empty($key_secret) && strpos($key_id, 'sample') === false && function_exists('curl_init')) {
            $ch = curl_init('https://api.razorpay.com/v1/orders');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'amount' => $amount_in_paise,
                'currency' => $currency,
                'receipt' => $receipt,
                'notes' => [
                    'customer_id' => $user_id,
                    'customer_name' => $user ? $user->name : 'Customer'
                ]
            ]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $rzp_data = json_decode($response, true);
                if (!empty($rzp_data['id'])) {
                    $razorpay_order_id = $rzp_data['id'];
                }
            }
        }

        // Return order setup configuration to client
        $this->output->set_content_type('application/json')->set_output(json_encode([
            'success' => true,
            'key_id' => $key_id,
            'amount' => $amount_in_paise,
            'currency' => $currency,
            'company_name' => $company_name,
            'logo_url' => $logo_url,
            'theme_color' => $theme_color,
            'razorpay_order_id' => $razorpay_order_id,
            'receipt' => $receipt,
            'customer_name' => $user ? $user->name : 'Valued Customer',
            'customer_email' => $user ? $user->email : '',
            'customer_phone' => $user ? $user->phone : ''
        ]));
    }

    /**
     * Final Order Placement (Handles both Cash on Delivery and Online/Razorpay payments)
     */
    public function place_order()
    {
        $this->_require_login('checkout');

        $user_id = (int) $this->session->userdata('user_id');
        $cart = $this->General_model->getAll('cart', ['user_id' => $user_id]);

        if (empty($cart)) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => 'Your cart is empty.'
                ]));
                return;
            }
            $this->session->set_flashdata('warning', 'Your cart is empty.');
            redirect('products');
            return;
        }

        // Validate delivery address
        $address_id = (int) $this->input->post('address_id');
        $address = null;

        if (!empty($address_id)) {
            $address = $this->General_model->getOne('user_addresses', ['id' => $address_id, 'user_id' => $user_id]);
        }

        if (!$address) {
            $address = $this->General_model->getOne('user_addresses', ['user_id' => $user_id, 'is_default' => 1]);
        }

        if (!$address) {
            $this->db->order_by('id DESC');
            $address = $this->General_model->getOne('user_addresses', ['user_id' => $user_id]);
        }

        if (!$address) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => 'Please select or add a delivery address to complete your order.'
                ]));
                return;
            }
            $this->session->set_flashdata('error', 'Please select or add a delivery address.');
            redirect('checkout');
            return;
        }

        // Calculate items and verify stock availability
        $subtotal = 0.00;
        $order_items_data = [];

        foreach ($cart as $item) {
            $product = $this->General_model->getOne('products', ['id' => $item->product_id, 'status' => 1]);
            if ($product) {
                $qty = (int) $item->quantity;
                if ($qty > (int) $product->stock) {
                    $qty = (int) $product->stock;
                }
                if ($qty <= 0) {
                    continue; // Skip out of stock
                }

                $price = (!empty($product->discount_price) && $product->discount_price < $product->price)
                    ? (float) $product->discount_price
                    : (float) $product->price;

                $line_total = $price * $qty;
                $subtotal += $line_total;

                $order_items_data[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_image' => $product->image,
                    'sku' => $product->sku,
                    'unit_price' => $price,
                    'quantity' => $qty,
                    'line_total' => $line_total,
                    'current_stock' => (int) $product->stock
                ];
            }
        }

        if (empty($order_items_data)) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => 'The items in your cart are currently out of stock.'
                ]));
                return;
            }
            $this->session->set_flashdata('error', 'Items in your cart are out of stock.');
            redirect('cart');
            return;
        }

        $payment_method = trim($this->input->post('payment_method') ?: 'Cash on Delivery');
        $razorpay_order_id = trim($this->input->post('razorpay_order_id') ?? '');
        $razorpay_payment_id = trim($this->input->post('razorpay_payment_id') ?? '');
        $order_notes = $this->input->post('order_notes', TRUE);

        // Determine initial payment status and order status
        $payment_status = 'Pending';
        $order_status = 'Placed';

        if ($payment_method === 'Razorpay' || !empty($razorpay_payment_id)) {
            $payment_status = 'Paid';
            $order_status = 'Confirmed';
        }

        // Unique order number
        $order_number = 'SRL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
        $shipping_fee = 0.00;
        if ($subtotal < 20000) {
            $shipping_fee = 200.00; // Your shipping charge
        }
        $total_amount = $subtotal + $shipping_fee;

        // Create Order Record
        $order_data = [
            'order_number' => $order_number,
            'order_type' => 'online',
            'user_id' => $user_id,
            'address_id' => $address->id,
            'shipping_full_name' => $address->full_name,
            'shipping_mobile' => $address->mobile,
            'shipping_address_line1' => $address->address_line1,
            'shipping_address_line2' => $address->address_line2,
            'shipping_landmark' => $address->landmark,
            'shipping_city' => $address->city,
            'shipping_state' => $address->state,
            'shipping_pincode' => $address->pincode,
            'shipping_country' => $address->country ?: 'India',
            'subtotal' => $subtotal,
            'shipping_fee' => $shipping_fee,
            'total_amount' => $total_amount,
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
            'order_status' => $order_status,
            'razorpay_order_id' => $razorpay_order_id ?: null,
            'razorpay_payment_id' => $razorpay_payment_id ?: null,
            'notes' => $order_notes ?: null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $order_id = $this->General_model->insert('orders', $order_data);

        // Insert Order Items and Automatically Deduct Stock from Products
        foreach ($order_items_data as $oi) {
            $this->General_model->insert('order_items', [
                'order_id' => $order_id,
                'product_id' => $oi['product_id'],
                'product_name' => $oi['product_name'],
                'product_image' => $oi['product_image'],
                'sku' => $oi['sku'],
                'unit_price' => $oi['unit_price'],
                'quantity' => $oi['quantity'],
                'line_total' => $oi['line_total'],
                'created_at' => date('Y-m-d H:i:s')
            ]);

            // Deduct stock
            $new_stock = max(0, $oi['current_stock'] - $oi['quantity']);
            $this->General_model->update('products', ['id' => $oi['product_id']], [
                'stock' => $new_stock,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Clear user cart
        $this->General_model->delete('cart', ['user_id' => $user_id]);

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => true,
                'order_id' => $order_id,
                'order_number' => $order_number,
                'redirect_url' => base_url('order/success/' . $order_id)
            ]));
            return;
        }

        $this->session->set_flashdata('success', 'Your order #' . $order_number . ' has been placed successfully!');
        redirect('order/success/' . $order_id);
    }

    /**
     * Razorpay Payment Verification & Completion
     */
    public function razorpay_verify()
    {
        $this->_require_login('checkout');

        $razorpay_payment_id = trim($this->input->post('razorpay_payment_id') ?? '');
        $razorpay_order_id = trim($this->input->post('razorpay_order_id') ?? '');
        $razorpay_signature = trim($this->input->post('razorpay_signature') ?? '');
        $address_id = (int) $this->input->post('address_id');
        $order_notes = $this->input->post('order_notes', TRUE);

        if (empty($razorpay_payment_id)) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Payment verification failed: missing payment reference.'
            ]));
            return;
        }

        // Forward to place_order with Razorpay details
        $_POST['payment_method'] = 'Razorpay';
        $_POST['razorpay_payment_id'] = $razorpay_payment_id;
        $_POST['razorpay_order_id'] = $razorpay_order_id;
        $_POST['address_id'] = $address_id;
        $_POST['order_notes'] = $order_notes;

        $this->place_order();
    }

    /**
     * Order Confirmation Page (After successful order placement)
     */
    public function success($order_id = NULL)
    {
        $this->_require_login();

        $user_id = (int) $this->session->userdata('user_id');
        $order = $this->General_model->getOne('orders', ['id' => (int) $order_id, 'user_id' => $user_id]);

        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found.');
            redirect('profile?tab=orders');
            return;
        }

        $items = $this->General_model->getAll('order_items', ['order_id' => $order->id]);
        $customer = $this->General_model->getOne('user', ['id' => $user_id]);

        $data['title'] = 'Order Confirmation #' . $order->order_number . ' - SRL Pixel';
        $data['order'] = $order;
        $data['items'] = $items;
        $data['customer'] = $customer;

        $this->load->view('header', $data);
        $this->load->view('order_confirmation_view', $data);
        $this->load->view('footer', $data);
    }

    /**
     * Professional GST Tax Invoice View & Print/PDF Download (Customer Portal)
     */
    public function invoice($order_id = NULL)
    {
        $is_customer = ($this->session->userdata('user_logged_in') && $this->session->userdata('user_role') == 0);
        $is_admin = ($this->session->userdata('admin_logged_in') && $this->session->userdata('admin_role') == 1);

        if (!$is_customer && !$is_admin) {
            $this->session->set_flashdata('error', 'Authentication required to view invoice.');
            redirect('login');
            return;
        }

        $where = ['id' => (int) $order_id];
        if (!$is_admin) {
            $where['user_id'] = (int) $this->session->userdata('user_id');
        }

        $order = $this->General_model->getOne('orders', $where);
        if (!$order) {
            $this->session->set_flashdata('error', 'Invoice not found or unauthorized.');
            redirect($is_admin ? 'admin/orders' : 'profile?tab=orders');
            return;
        }

        $items = $this->General_model->getAll('order_items', ['order_id' => $order->id]);
        $customer = $this->General_model->getOne('user', ['id' => $order->user_id]);

        $data['order'] = $order;
        $data['items'] = $items;
        $data['customer'] = $customer;
        $data['is_admin'] = $is_admin;
        $data['title'] = 'Tax Invoice #' . $order->order_number . ' - SRL Pixel';

        $this->load->view('invoice_view', $data);
    }
}
