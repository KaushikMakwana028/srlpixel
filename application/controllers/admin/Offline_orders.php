<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Offline_orders extends CI_Controller {

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
     * Page 1: List All Offline Orders with Search, Filters, Pagination, and "+ Create Offline Order" button
     */
    public function index()
    {
        $data['title'] = 'Offline Orders (Store / Walk-in Sales) - SRL Pixel Admin';
        $data['breadcrumb'] = 'Offline Orders';

        // Filter counts
        $data['counts'] = [
            'all'       => $this->General_model->count_filtered_data('orders', ['order_type' => 'offline']),
            'Paid'      => $this->General_model->count_filtered_data('orders', ['order_type' => 'offline', 'payment_status' => 'Paid']),
            'Pending'   => $this->General_model->count_filtered_data('orders', ['order_type' => 'offline', 'payment_status' => 'Pending']),
            'Confirmed' => $this->General_model->count_filtered_data('orders', ['order_type' => 'offline', 'order_status' => 'Confirmed']),
            'Delivered' => $this->General_model->count_filtered_data('orders', ['order_type' => 'offline', 'order_status' => 'Delivered']),
            'Cancelled' => $this->General_model->count_filtered_data('orders', ['order_type' => 'offline', 'order_status' => 'Cancelled'])
        ];

        $limit = 10;
        $page = 1;
        $offset = 0;
        $status = $this->input->get('status');
        $payment_status = $this->input->get('payment_status');

        $where = ['order_type' => 'offline'];
        if (!empty($status) && in_array($status, ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'])) {
            $where['order_status'] = $status;
        }
        if (!empty($payment_status) && in_array($payment_status, ['Paid', 'Pending', 'Partial'])) {
            $where['payment_status'] = $payment_status;
        }

        $total = $this->General_model->count_filtered_data('orders', $where);
        $total_pages = max(1, ceil($total / $limit));

        $data['orders'] = $this->General_model->get_paginated_data('orders', $where, [], $limit, $offset, 'id DESC');
        $data['offset'] = $offset;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page'] = $page;
        $data['status_filter'] = !empty($status) ? $status : 'all';
        $data['payment_filter'] = !empty($payment_status) ? $payment_status : 'all';
        $data['total_pages'] = $total_pages;
        $data['pagination'] = $this->General_model->render_pagination_html($page, $total_pages, $total, $limit);

        $this->load->view('admin/header', $data);
        $this->load->view('admin/offline_orders/index', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * AJAX endpoint for server-side search, filtering, and pagination
     */
    public function ajax_list()
    {
        $page           = max(1, (int)$this->input->get_post('page'));
        $limit          = in_array((int)$this->input->get_post('limit'), [5, 10, 25, 50, 100]) ? (int)$this->input->get_post('limit') : 10;
        $search         = trim($this->input->get_post('search') ?? '');
        $status         = trim($this->input->get_post('status') ?? '');
        $payment_status = trim($this->input->get_post('payment_status') ?? '');

        $where = ['order_type' => 'offline'];
        if (!empty($status) && in_array($status, ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'])) {
            $where['order_status'] = $status;
        }
        if (!empty($payment_status) && in_array($payment_status, ['Paid', 'Pending', 'Partial'])) {
            $where['payment_status'] = $payment_status;
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

        if ($page > $total_pages && $total > 0) {
            $page = $total_pages;
        }
        $offset = ($page - 1) * $limit;

        $orders = $this->General_model->get_paginated_data('orders', $where, $like, $limit, $offset, 'id DESC');

        $rows_html = $this->load->view('admin/offline_orders/_rows', [
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
     * Page 2: Create New Offline Order Form
     */
    public function create()
    {
        $data['title'] = 'Create Offline Order - SRL Pixel Admin';
        $data['breadcrumb'] = 'Create Offline Order';

        // Payment method choices
        $data['payment_methods'] = [
            'Cash',
            'UPI / QR Code',
            'Debit / Credit Card',
            'Bank Transfer / NEFT',
            'Cheque',
            'Cash on Delivery'
        ];

        // Default order statuses
        $data['order_statuses'] = [
            'Confirmed',
            'Placed',
            'Packed',
            'Out for Delivery',
            'Delivered'
        ];

        $this->load->view('admin/header', $data);
        $this->load->view('admin/offline_orders/create', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * AJAX Endpoint: Search Customers for Autocomplete & Auto-fill
     */
    public function search_customers()
    {
        $term = trim($this->input->get_post('term') ?: $this->input->get_post('query') ?: '');

        if (mb_strlen($term) < 1) {
            $this->output->set_content_type('application/json')->set_output(json_encode([]));
            return;
        }

        $this->db->select('id, name, email, phone');
        $this->db->from('user');
        $this->db->where('role', 0);
        $this->db->where('status', 1);
        $this->db->group_start();
        $this->db->like('name', $term);
        $this->db->or_like('phone', $term);
        $this->db->or_like('email', $term);
        $this->db->group_end();
        $this->db->limit(12);
        $customers = $this->db->get()->result();

        $results = [];
        foreach ($customers as $c) {
            // Find default address or latest address
            $addr = $this->General_model->getOne('user_addresses', ['user_id' => $c->id, 'is_default' => 1]);
            if (!$addr) {
                $this->db->order_by('id DESC');
                $addr = $this->General_model->getOne('user_addresses', ['user_id' => $c->id]);
            }

            $results[] = [
                'id'            => (int)$c->id,
                'name'          => $c->name,
                'phone'         => $c->phone ?: '',
                'email'         => $c->email ?: '',
                'address_line1' => $addr ? $addr->address_line1 : '',
                'address_line2' => $addr ? ($addr->address_line2 ?: '') : '',
                'landmark'      => $addr ? ($addr->landmark ?: '') : '',
                'city'          => $addr ? $addr->city : '',
                'state'         => $addr ? $addr->state : '',
                'pincode'       => $addr ? $addr->pincode : '',
                'country'       => $addr ? ($addr->country ?: 'India') : 'India'
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($results));
    }

    /**
     * AJAX Endpoint: Search Products for Live Cart Addition
     */
    public function search_products()
    {
        $term = trim($this->input->get_post('term') ?: $this->input->get_post('query') ?: '');

        if (mb_strlen($term) < 1) {
            $this->output->set_content_type('application/json')->set_output(json_encode([]));
            return;
        }

        $this->db->select('id, name, sku, price, discount_price, stock, image');
        $this->db->from('products');
        $this->db->where('status', 1);
        $this->db->group_start();
        $this->db->like('name', $term);
        $this->db->or_like('sku', $term);
        $this->db->group_end();
        $this->db->limit(15);
        $products = $this->db->get()->result();

        $results = [];
        foreach ($products as $p) {
            $effective_price = (!empty($p->discount_price) && (float)$p->discount_price > 0 && (float)$p->discount_price < (float)$p->price)
                ? (float)$p->discount_price
                : (float)$p->price;

            $image_url = (!empty($p->image) && file_exists('./uploads/products/' . $p->image))
                ? base_url('uploads/products/' . $p->image)
                : base_url('assets/images/no-image.png');

            $results[] = [
                'id'              => (int)$p->id,
                'name'            => $p->name,
                'sku'             => $p->sku ?: 'SKU-' . $p->id,
                'regular_price'   => (float)$p->price,
                'discount_price'  => (float)$p->discount_price,
                'effective_price' => $effective_price,
                'stock'           => (int)$p->stock,
                'image_url'       => $image_url
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($results));
    }

    /**
     * Store Action: Process and save the offline order
     */
    public function store()
    {
        $this->form_validation->set_rules('full_name', 'Customer Full Name', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('address_line1', 'Address Line 1', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|max_length[20]');

        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors('', '');
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => $errors
                ]));
                return;
            }
            $this->session->set_flashdata('error', $errors);
            redirect('admin/offline_orders/create');
            return;
        }

        // Validate products
        $product_ids = $this->input->post('item_product_id');
        $quantities  = $this->input->post('item_quantity');
        $unit_prices = $this->input->post('item_unit_price');

        if (empty($product_ids) || !is_array($product_ids) || count($product_ids) === 0) {
            $msg = 'Please add at least one product to create an order.';
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => $msg
                ]));
                return;
            }
            $this->session->set_flashdata('error', $msg);
            redirect('admin/offline_orders/create');
            return;
        }

        $full_name     = trim($this->input->post('full_name', TRUE) ?? '');
        $mobile        = trim($this->input->post('mobile', TRUE) ?? '');
        $email         = trim($this->input->post('email', TRUE) ?? '');
        $address_line1 = trim($this->input->post('address_line1', TRUE) ?? '');
        $address_line2 = trim($this->input->post('address_line2', TRUE) ?? '');
        $landmark      = trim($this->input->post('landmark', TRUE) ?? '');
        $city          = trim($this->input->post('city', TRUE) ?? '');
        $state         = trim($this->input->post('state', TRUE) ?? '');
        $pincode       = trim($this->input->post('pincode', TRUE) ?? '');
        $country       = trim($this->input->post('country', TRUE) ?? '') ?: 'India';

        // Resolve Customer ("customer created by itself" if new)
        $customer_id = (int)$this->input->post('customer_id');
        $user = null;

        if ($customer_id > 0) {
            $user = $this->General_model->getOne('user', ['id' => $customer_id, 'role' => 0]);
        }

        if (!$user && !empty($mobile)) {
            $user = $this->General_model->getOne('user', ['phone' => $mobile, 'role' => 0]);
        }

        if (!$user && !empty($email)) {
            $user = $this->General_model->getOne('user', ['email' => $email, 'role' => 0]);
        }

        // Auto-create customer if does not exist
        if (!$user) {
            $safe_email = !empty($email) ? $email : 'walkin_' . preg_replace('/[^0-9]/', '', $mobile) . '@srlpixel.com';

            // Ensure unique email
            $existing_email = $this->General_model->getOne('user', ['email' => $safe_email]);
            if ($existing_email) {
                $safe_email = 'customer_' . time() . '_' . rand(100, 999) . '@srlpixel.com';
            }

            $new_user_data = [
                'name'       => $full_name,
                'email'      => $safe_email,
                'phone'      => $mobile,
                'password'   => password_hash('srlpixel@' . rand(1000, 9999), PASSWORD_DEFAULT),
                'role'       => 0,
                'status'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $user_id = $this->General_model->insert('user', $new_user_data);

            // Create initial address
            $address_id = $this->General_model->insert('user_addresses', [
                'user_id'       => $user_id,
                'full_name'     => $full_name,
                'mobile'        => $mobile,
                'address_line1' => $address_line1,
                'address_line2' => $address_line2 ?: null,
                'landmark'      => $landmark ?: null,
                'city'          => $city,
                'state'         => $state,
                'pincode'       => $pincode,
                'country'       => $country,
                'is_default'    => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s')
            ]);
        } else {
            $user_id = (int)$user->id;
            // Find or add address for existing customer
            $addr = $this->General_model->getOne('user_addresses', [
                'user_id'       => $user_id,
                'address_line1' => $address_line1,
                'city'          => $city
            ]);
            if ($addr) {
                $address_id = (int)$addr->id;
            } else {
                $address_id = $this->General_model->insert('user_addresses', [
                    'user_id'       => $user_id,
                    'full_name'     => $full_name,
                    'mobile'        => $mobile,
                    'address_line1' => $address_line1,
                    'address_line2' => $address_line2 ?: null,
                    'landmark'      => $landmark ?: null,
                    'city'          => $city,
                    'state'         => $state,
                    'pincode'       => $pincode,
                    'country'       => $country,
                    'is_default'    => 0,
                    'created_at'    => date('Y-m-d H:i:s'),
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            }
        }

        // Process line items & stock
        $subtotal = 0.00;
        $order_items = [];

        for ($i = 0; $i < count($product_ids); $i++) {
            $p_id = (int)$product_ids[$i];
            $qty  = max(1, (int)$quantities[$i]);
            $prod = $this->General_model->getOne('products', ['id' => $p_id]);

            if (!$prod) {
                continue;
            }

            $u_price = isset($unit_prices[$i]) && (float)$unit_prices[$i] >= 0
                ? (float)$unit_prices[$i]
                : ((!empty($prod->discount_price) && (float)$prod->discount_price > 0) ? (float)$prod->discount_price : (float)$prod->price);

            $line_total = $u_price * $qty;
            $subtotal += $line_total;

            $order_items[] = [
                'product_id'    => $prod->id,
                'product_name'  => $prod->name,
                'product_image' => $prod->image ?: null,
                'sku'           => $prod->sku ?: 'SKU-' . $prod->id,
                'unit_price'    => $u_price,
                'quantity'      => $qty,
                'line_total'    => $line_total
            ];
        }

        if (empty($order_items)) {
            $msg = 'No valid products were added.';
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => $msg
                ]));
                return;
            }
            $this->session->set_flashdata('error', $msg);
            redirect('admin/offline_orders/create');
            return;
        }

        $shipping_fee    = max(0, (float)$this->input->post('shipping_fee'));
        $discount_amount = max(0, (float)$this->input->post('discount_amount'));
        $total_amount    = max(0, ($subtotal + $shipping_fee) - $discount_amount);

        // Payment details (admin selects payment type, sets Paid or Pending without gateway)
        $payment_method = trim($this->input->post('payment_method') ?? 'Cash');
        $payment_status = trim($this->input->post('payment_status') ?? 'Pending');
        if (!in_array($payment_status, ['Paid', 'Pending', 'Partial'])) {
            $payment_status = 'Pending';
        }

        // Order status
        $order_status = trim($this->input->post('order_status') ?? 'Confirmed');
        if (!in_array($order_status, ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'])) {
            $order_status = 'Confirmed';
        }

        $order_notes = $this->input->post('notes', TRUE);

        // Generate unique offline order number
        $order_number = 'SRL-OFF-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));

        // Create Order Record
        $order_data = [
            'order_number'           => $order_number,
            'order_type'             => 'offline',
            'user_id'                => $user_id,
            'address_id'             => $address_id ?? null,
            'shipping_full_name'     => $full_name,
            'shipping_mobile'        => $mobile,
            'shipping_address_line1' => $address_line1,
            'shipping_address_line2' => $address_line2 ?: null,
            'shipping_landmark'      => $landmark ?: null,
            'shipping_city'          => $city,
            'shipping_state'         => $state,
            'shipping_pincode'       => $pincode,
            'shipping_country'       => $country,
            'subtotal'               => $subtotal,
            'shipping_fee'           => $shipping_fee,
            'total_amount'           => $total_amount,
            'payment_method'         => $payment_method,
            'payment_status'         => $payment_status,
            'order_status'           => $order_status,
            'notes'                  => $order_notes ?: null,
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_at'             => date('Y-m-d H:i:s')
        ];

        $order_id = $this->General_model->insert('orders', $order_data);

        // Insert line items & decrement stock
        foreach ($order_items as $oi) {
            $oi['order_id']   = $order_id;
            $oi['created_at'] = date('Y-m-d H:i:s');
            $this->General_model->insert('order_items', $oi);

            // Deduct stock in products table
            $this->db->set('stock', 'GREATEST(0, stock - ' . (int)$oi['quantity'] . ')', FALSE);
            $this->db->where('id', (int)$oi['product_id']);
            $this->db->update('products');
        }

        $success_msg = 'Offline Order #' . $order_number . ' created successfully!';

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success'      => true,
                'message'      => $success_msg,
                'order_id'     => $order_id,
                'order_number' => $order_number,
                'redirect_url' => base_url('admin/offline_orders'),
                'invoice_url'  => base_url('admin/offline_orders/invoice/' . $order_id)
            ]));
            return;
        }

        $this->session->set_flashdata('success', $success_msg);
        redirect('admin/offline_orders');
    }

    /**
     * Quick AJAX Toggle: Update Payment Status ('Pending' <-> 'Paid')
     * Allows admin to change payment status after customer pays by themselves.
     */
    public function update_payment_status()
    {
        $order_id       = (int)$this->input->post('order_id');
        $payment_status = trim($this->input->post('payment_status') ?? '');

        if (!in_array($payment_status, ['Paid', 'Pending', 'Partial'])) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Invalid payment status.'
            ]));
            return;
        }

        $order = $this->General_model->getOne('orders', ['id' => $order_id]);
        if (!$order) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => false,
                'message' => 'Order not found.'
            ]));
            return;
        }

        $this->General_model->update('orders', ['id' => $order_id], [
            'payment_status' => $payment_status,
            'updated_at'     => date('Y-m-d H:i:s')
        ]);

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'success'        => true,
            'message'        => 'Payment status updated to "' . $payment_status . '" successfully!',
            'payment_status' => $payment_status,
            'order_id'       => $order_id
        ]));
    }

    /**
     * Update Order Fulfillment Status (AJAX & Form POST)
     */
    public function update_status()
    {
        $order_id = (int)$this->input->post('order_id');
        $status   = trim($this->input->post('status') ?? '');
        $notes    = $this->input->post('notes', TRUE);

        $valid_statuses = ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'];

        if (!in_array($status, $valid_statuses)) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Invalid status selected.']));
            return;
        }

        $order = $this->General_model->getOne('orders', ['id' => $order_id]);
        if (!$order) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['success' => false, 'message' => 'Order not found.']));
            return;
        }

        $update_data = [
            'order_status' => $status,
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        if ($notes !== null && $notes !== '') {
            $update_data['notes'] = $notes;
        }

        $this->General_model->update('orders', ['id' => $order->id], $update_data);

        $this->output->set_content_type('application/json')->set_output(json_encode([
            'success' => true,
            'message' => 'Order status updated to "' . $status . '" successfully!',
            'status'  => $status
        ]));
    }

    /**
     * View Detailed Offline Order
     */
    public function detail($id = NULL)
    {
        $order = $this->General_model->getOne('orders', ['id' => (int)$id]);

        if (!$order) {
            $this->session->set_flashdata('error', 'Offline order not found.');
            redirect('admin/offline_orders');
            return;
        }

        $items = $this->General_model->getAll('order_items', ['order_id' => $order->id]);
        $customer = $this->General_model->getOne('user', ['id' => $order->user_id]);

        $data['order']      = $order;
        $data['items']      = $items;
        $data['customer']   = $customer;
        $data['title']      = 'Offline Order #' . $order->order_number . ' - SRL Pixel Admin';
        $data['breadcrumb'] = 'Offline Order Details';

        $this->load->view('admin/header', $data);
        $this->load->view('admin/offline_orders/detail', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Print / Download Tax Invoice (Admin)
     */
    public function invoice($id = NULL)
    {
        $order = $this->General_model->getOne('orders', ['id' => (int)$id]);
        if (!$order) {
            $this->session->set_flashdata('error', 'Order not found.');
            redirect('admin/offline_orders');
            return;
        }

        $items = $this->General_model->getAll('order_items', ['order_id' => $order->id]);
        $customer = $this->General_model->getOne('user', ['id' => $order->user_id]);

        $data['order']    = $order;
        $data['items']    = $items;
        $data['customer'] = $customer;
        $data['is_admin'] = true;
        $data['title']    = 'Tax Invoice #' . $order->order_number . ' - SRL Pixel Admin';

        $this->load->view('invoice_view', $data);
    }

    /**
     * Delete Offline Order and Restore Product Stock
     */
    public function delete($id = NULL)
    {
        $id = (int)($id ?: $this->input->post('order_id'));
        $order = $this->General_model->getOne('orders', ['id' => $id, 'order_type' => 'offline']);

        if (!$order) {
            $msg = 'Offline order not found or already removed.';
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => $msg
                ]));
                return;
            }
            $this->session->set_flashdata('error', $msg);
            redirect('admin/offline_orders');
            return;
        }

        // 1. Restore product inventory
        $items = $this->General_model->getAll('order_items', ['order_id' => $id]);
        if (!empty($items)) {
            foreach ($items as $item) {
                if (!empty($item->product_id) && (int)$item->quantity > 0) {
                    $this->db->set('stock', 'stock + ' . (int)$item->quantity, FALSE);
                    $this->db->where('id', (int)$item->product_id);
                    $this->db->update('products');
                }
            }
        }

        // 2. Delete line items and order record
        $this->General_model->delete('order_items', ['order_id' => $id]);
        $this->General_model->delete('orders', ['id' => $id]);

        $success_msg = 'Offline Order #' . $order->order_number . ' deleted successfully and inventory restored.';

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success' => true,
                'message' => $success_msg
            ]));
            return;
        }

        $this->session->set_flashdata('success', $success_msg);
        redirect('admin/offline_orders');
    }

    /**
     * Edit Offline Order Form
     */
    public function edit($id = NULL)
    {
        $id = (int)$id;
        $order = $this->General_model->getOne('orders', ['id' => $id, 'order_type' => 'offline']);

        if (!$order) {
            $this->session->set_flashdata('error', 'Offline order not found.');
            redirect('admin/offline_orders');
            return;
        }

        $items = $this->General_model->getAll('order_items', ['order_id' => $id]);
        $customer = $order->user_id ? $this->General_model->getOne('user', ['id' => $order->user_id]) : null;

        $data['title']      = 'Edit Offline Order #' . $order->order_number . ' - SRL Pixel Admin';
        $data['breadcrumb'] = 'Edit Offline Order';
        $data['order']      = $order;
        $data['items']      = $items;
        $data['customer']   = $customer;

        $data['payment_methods'] = [
            'Cash',
            'UPI / QR Code',
            'Debit / Credit Card',
            'Bank Transfer / NEFT',
            'Cheque',
            'Cash on Delivery'
        ];

        $data['order_statuses'] = [
            'Confirmed',
            'Placed',
            'Packed',
            'Out for Delivery',
            'Delivered',
            'Cancelled'
        ];

        $this->load->view('admin/header', $data);
        $this->load->view('admin/offline_orders/edit', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Update Action: Save modifications to offline order
     */
    public function update($id = NULL)
    {
        $id = (int)($id ?: $this->input->post('order_id'));
        $order = $this->General_model->getOne('orders', ['id' => $id, 'order_type' => 'offline']);

        if (!$order) {
            $msg = 'Offline order not found.';
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => $msg
                ]));
                return;
            }
            $this->session->set_flashdata('error', $msg);
            redirect('admin/offline_orders');
            return;
        }

        $this->form_validation->set_rules('full_name', 'Customer Full Name', 'trim|required|max_length[150]');
        $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('address_line1', 'Address Line 1', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('city', 'City', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|max_length[20]');

        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors('', '');
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => $errors
                ]));
                return;
            }
            $this->session->set_flashdata('error', $errors);
            redirect('admin/offline_orders/edit/' . $id);
            return;
        }

        // Validate products
        $product_ids = $this->input->post('item_product_id');
        $quantities  = $this->input->post('item_quantity');
        $unit_prices = $this->input->post('item_unit_price');

        if (empty($product_ids) || !is_array($product_ids) || count($product_ids) === 0) {
            $msg = 'Please keep at least one product in the order.';
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode([
                    'success' => false,
                    'message' => $msg
                ]));
                return;
            }
            $this->session->set_flashdata('error', $msg);
            redirect('admin/offline_orders/edit/' . $id);
            return;
        }

        $full_name     = trim($this->input->post('full_name', TRUE) ?? '');
        $mobile        = trim($this->input->post('mobile', TRUE) ?? '');
        $email         = trim($this->input->post('email', TRUE) ?? '');
        $address_line1 = trim($this->input->post('address_line1', TRUE) ?? '');
        $address_line2 = trim($this->input->post('address_line2', TRUE) ?? '');
        $landmark      = trim($this->input->post('landmark', TRUE) ?? '');
        $city          = trim($this->input->post('city', TRUE) ?? '');
        $state         = trim($this->input->post('state', TRUE) ?? '');
        $pincode       = trim($this->input->post('pincode', TRUE) ?? '');
        $country       = trim($this->input->post('country', TRUE) ?? '') ?: 'India';

        // 1. Restore previous stock for existing order items
        $old_items = $this->General_model->getAll('order_items', ['order_id' => $id]);
        if (!empty($old_items)) {
            foreach ($old_items as $old_item) {
                if (!empty($old_item->product_id) && (int)$old_item->quantity > 0) {
                    $this->db->set('stock', 'stock + ' . (int)$old_item->quantity, FALSE);
                    $this->db->where('id', (int)$old_item->product_id);
                    $this->db->update('products');
                }
            }
        }

        // Delete old items
        $this->General_model->delete('order_items', ['order_id' => $id]);

        // 2. Process new line items
        $subtotal = 0.00;
        $order_items = [];

        for ($i = 0; $i < count($product_ids); $i++) {
            $p_id = (int)$product_ids[$i];
            $qty  = max(1, (int)$quantities[$i]);
            $prod = $this->General_model->getOne('products', ['id' => $p_id]);

            if (!$prod) {
                continue;
            }

            $u_price = isset($unit_prices[$i]) && (float)$unit_prices[$i] >= 0
                ? (float)$unit_prices[$i]
                : ((!empty($prod->discount_price) && (float)$prod->discount_price > 0) ? (float)$prod->discount_price : (float)$prod->price);

            $line_total = $u_price * $qty;
            $subtotal += $line_total;

            $order_items[] = [
                'order_id'      => $id,
                'product_id'    => $prod->id,
                'product_name'  => $prod->name,
                'product_image' => $prod->image ?: null,
                'sku'           => $prod->sku ?: 'SKU-' . $prod->id,
                'unit_price'    => $u_price,
                'quantity'      => $qty,
                'line_total'    => $line_total,
                'created_at'    => date('Y-m-d H:i:s')
            ];

            // Deduct updated stock
            $this->db->set('stock', 'GREATEST(0, stock - ' . (int)$qty . ')', FALSE);
            $this->db->where('id', (int)$prod->id);
            $this->db->update('products');
        }

        // Insert new order items
        foreach ($order_items as $oi) {
            $this->General_model->insert('order_items', $oi);
        }

        $shipping_fee    = max(0, (float)$this->input->post('shipping_fee'));
        $discount_amount = max(0, (float)$this->input->post('discount_amount'));
        $total_amount    = max(0, ($subtotal + $shipping_fee) - $discount_amount);

        $payment_method = trim($this->input->post('payment_method') ?? 'Cash');
        $payment_status = trim($this->input->post('payment_status') ?? 'Paid');
        if (!in_array($payment_status, ['Paid', 'Pending', 'Partial'])) {
            $payment_status = 'Paid';
        }

        $order_status = trim($this->input->post('order_status') ?? 'Confirmed');
        if (!in_array($order_status, ['Awaiting Payment', 'Placed', 'Confirmed', 'Packed', 'Out for Delivery', 'Delivered', 'Cancelled'])) {
            $order_status = 'Confirmed';
        }

        $order_notes = $this->input->post('notes', TRUE);

        // Update Order Record
        $update_data = [
            'shipping_full_name'     => $full_name,
            'shipping_mobile'        => $mobile,
            'shipping_address_line1' => $address_line1,
            'shipping_address_line2' => $address_line2 ?: null,
            'shipping_landmark'      => $landmark ?: null,
            'shipping_city'          => $city,
            'shipping_state'         => $state,
            'shipping_pincode'       => $pincode,
            'shipping_country'       => $country,
            'subtotal'               => $subtotal,
            'shipping_fee'           => $shipping_fee,
            'total_amount'           => $total_amount,
            'payment_method'         => $payment_method,
            'payment_status'         => $payment_status,
            'order_status'           => $order_status,
            'notes'                  => $order_notes ?: null,
            'updated_at'             => date('Y-m-d H:i:s')
        ];

        $this->General_model->update('orders', ['id' => $id], $update_data);

        $success_msg = 'Offline Order #' . $order->order_number . ' updated successfully!';

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode([
                'success'      => true,
                'message'      => $success_msg,
                'order_id'     => $id,
                'order_number' => $order->order_number,
                'redirect_url' => base_url('admin/offline_orders'),
                'invoice_url'  => base_url('admin/offline_orders/invoice/' . $id)
            ]));
            return;
        }

        $this->session->set_flashdata('success', $success_msg);
        redirect('admin/offline_orders/detail/' . $id);
    }
}
