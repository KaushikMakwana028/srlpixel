<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display Shopping Cart Page (Database Backed)
     */
    public function index()
    {
        // Require customer login to access cart
        if (!$this->session->userdata('user_logged_in') || $this->session->userdata('user_role') != 0) {
            $this->session->set_userdata('redirect_after_login', 'cart');
            $this->session->set_flashdata('error', 'Please sign in to view and manage your shopping cart.');
            redirect('login');
            return;
        }

        $user_id = (int)$this->session->userdata('user_id');
        $db_cart = $this->General_model->getAll('cart', ['user_id' => $user_id]);

        $cart_items = [];
        $subtotal = 0;
        $total_quantity = 0;

        if (!empty($db_cart)) {
            foreach ($db_cart as $item) {
                $product = $this->General_model->getOne('products', ['id' => $item->product_id, 'status' => 1]);
                if ($product) {
                    $unit_price = (!empty($product->discount_price) && $product->discount_price < $product->price)
                        ? (float)$product->discount_price
                        : (float)$product->price;

                    $qty = min((int)$product->stock, max(1, (int)$item->quantity));
                    if ($qty != $item->quantity) {
                        $this->General_model->update('cart', ['id' => $item->id], ['quantity' => $qty]);
                    }

                    $line_total = $unit_price * $qty;

                    $cart_items[$product->id] = [
                        'cart_id'    => $item->id,
                        'id'         => $product->id,
                        'name'       => $product->name,
                        'sku'        => $product->sku,
                        'slug'       => $product->slug,
                        'image'      => $product->image,
                        'stock'      => (int)$product->stock,
                        'price'      => $unit_price,
                        'quantity'   => $qty,
                        'line_total' => $line_total
                    ];

                    $subtotal += $line_total;
                    $total_quantity += $qty;
                } else {
                    // Remove orphaned or inactive product from cart
                    $this->General_model->delete('cart', ['id' => $item->id]);
                }
            }
        }

        // Fetch user addresses for checkout address selector
        $this->db->order_by('is_default DESC, id DESC');
        $addresses = $this->General_model->getAll('user_addresses', ['user_id' => $user_id]);
        $default_address = $this->General_model->getOne('user_addresses', ['user_id' => $user_id, 'is_default' => 1]);
        if (!$default_address && !empty($addresses)) {
            $default_address = $addresses[0];
        }

        $data['addresses'] = $addresses;
        $data['default_address'] = $default_address;
        $data['title'] = 'Shopping Cart (' . $total_quantity . ' items) - SRL Pixel';
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

        $this->load->view('header', $data);
        $this->load->view('cart_view', $data);
        $this->load->view('footer', $data);
    }

    /**
     * Add product to cart in database (Requires Customer Login)
     */
    public function add()
    {
        // Enforce Customer Login
        if (!$this->session->userdata('user_logged_in') || $this->session->userdata('user_role') != 0) {
            $product_id = (int)$this->input->post('product_id');
            $this->session->set_userdata('redirect_after_login', $product_id ? 'product/' . $product_id : 'cart');

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success'       => false,
                    'require_login' => true,
                    'message'       => 'Please sign in to add products to your cart and checkout.',
                    'login_url'     => base_url('login')
                ]));
            return;
        }

        $user_id    = (int)$this->session->userdata('user_id');
        $product_id = (int)$this->input->post('product_id');
        $quantity   = max(1, (int)$this->input->post('quantity'));

        if (empty($product_id)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Invalid product specified.'
                ]));
            return;
        }

        $product = $this->General_model->getOne('products', ['id' => $product_id, 'status' => 1]);

        if (!$product) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Product not found or currently unavailable.'
                ]));
            return;
        }

        if ($product->stock <= 0) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => false,
                    'message' => 'Sorry, this product is currently out of stock.'
                ]));
            return;
        }

        $existing = $this->General_model->getOne('cart', [
            'user_id'    => $user_id,
            'product_id' => $product_id
        ]);

        if ($existing) {
            $new_qty = min((int)$product->stock, (int)$existing->quantity + $quantity);
            $this->General_model->update('cart', ['id' => $existing->id], [
                'quantity' => $new_qty
            ]);
        } else {
            $final_qty = min((int)$product->stock, $quantity);
            $this->General_model->insert('cart', [
                'user_id'    => $user_id,
                'product_id' => $product_id,
                'quantity'   => $final_qty
            ]);
        }

        // Calculate live cart count for this user
        $user_cart = $this->General_model->getAll('cart', ['user_id' => $user_id]);
        $cart_count = 0;
        foreach ($user_cart as $row) {
            $cart_count += (int)$row->quantity;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success'    => true,
                'message'    => '"' . $product->name . '" added to your cart!',
                'cart_count' => $cart_count
            ]));
    }

    /**
     * Update item quantity in cart table
     */
    public function update_quantity()
    {
        if (!$this->session->userdata('user_logged_in') || $this->session->userdata('user_role') != 0) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'require_login' => true, 'login_url' => base_url('login')]));
            return;
        }

        $user_id    = (int)$this->session->userdata('user_id');
        $product_id = (int)$this->input->post('product_id');
        $quantity   = (int)$this->input->post('quantity');

        $cart_item = $this->General_model->getOne('cart', [
            'user_id'    => $user_id,
            'product_id' => $product_id
        ]);

        if (!$cart_item) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Item not found in your cart.']));
            return;
        }

        if ($quantity <= 0) {
            $this->General_model->delete('cart', ['id' => $cart_item->id]);
            $item_total = 0;
        } else {
            $product = $this->General_model->getOne('products', ['id' => $product_id]);
            $max_stock = $product ? (int)$product->stock : 999;
            $final_qty = min($max_stock, $quantity);

            $this->General_model->update('cart', ['id' => $cart_item->id], [
                'quantity' => $final_qty
            ]);

            $unit_price = ($product && !empty($product->discount_price) && $product->discount_price < $product->price)
                ? (float)$product->discount_price
                : (float)($product ? $product->price : 0);

            $item_total = $unit_price * $final_qty;
        }

        // Recalculate totals
        $remaining_items = $this->General_model->getAll('cart', ['user_id' => $user_id]);
        $subtotal = 0;
        $cart_count = 0;

        foreach ($remaining_items as $row) {
            $prod = $this->General_model->getOne('products', ['id' => $row->product_id]);
            if ($prod) {
                $u_price = (!empty($prod->discount_price) && $prod->discount_price < $prod->price)
                    ? (float)$prod->discount_price
                    : (float)$prod->price;
                $subtotal += ($u_price * (int)$row->quantity);
                $cart_count += (int)$row->quantity;
            }
        }

       // Calculate shipping
$shipping_fee = 0.00;
if ($subtotal < 20000) {
    $shipping_fee = 200.00;
}
$total = $subtotal + $shipping_fee;
$is_free_shipping = ($subtotal >= 20000);

$this->output
    ->set_content_type('application/json')
    ->set_output(json_encode([
        'success' => true,
        'cart_count' => $cart_count,
        'item_total' => number_format($item_total, 2),
        'subtotal' => number_format($subtotal, 2),
        'shipping' => number_format($shipping_fee, 2),
        'total' => number_format($total, 2),
        'is_free_shipping' => $is_free_shipping,
        'free_shipping_threshold' => 20000,
        'is_empty' => empty($remaining_items)
    ]));
    }

    /**
     * Remove item from cart table
     */
    public function remove($product_id = NULL)
    {
        if ($this->session->userdata('user_logged_in') && !empty($product_id)) {
            $user_id = (int)$this->session->userdata('user_id');
            $product = $this->General_model->getOne('products', ['id' => $product_id]);
            $this->General_model->delete('cart', [
                'user_id'    => $user_id,
                'product_id' => (int)$product_id
            ]);
            $pname = $product ? $product->name : 'Item';
            $this->session->set_flashdata('success', '"' . $pname . '" removed from your cart.');
        }
        redirect('cart');
    }

    /**
     * Clear entire cart for this user
     */
    public function clear()
    {
        if ($this->session->userdata('user_logged_in')) {
            $user_id = (int)$this->session->userdata('user_id');
            $this->General_model->delete('cart', ['user_id' => $user_id]);
            $this->session->set_flashdata('success', 'Your cart has been cleared.');
        }
        redirect('cart');
    }

    /**
     * Legacy checkout endpoint - redirect to step-by-step checkout page
     */
    public function checkout()
    {
        redirect('checkout');
    }
}

