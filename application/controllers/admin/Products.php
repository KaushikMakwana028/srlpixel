<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

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
     * List all products
     */
    public function index()
    {
        $data['title'] = 'Products Management - SRL Pixel Admin';
        $data['breadcrumb'] = 'Products';

        $categories = $this->General_model->getAll('categories');
        $cat_map = [];
        if (!empty($categories)) {
            foreach ($categories as $cat) {
                $cat_map[$cat->id] = $cat->name;
            }
        }
        $data['categories'] = $categories;
        $data['category_map'] = $cat_map;

        $limit = 10;
        $page = 1;
        $offset = 0;
        $total = $this->General_model->count_filtered_data('products');
        $total_pages = max(1, ceil($total / $limit));

        $products = $this->General_model->get_paginated_data('products', [], [], $limit, $offset, 'id DESC');

        // Fetch gallery counts for visible products only
        $gallery_counts = [];
        if (!empty($products)) {
            $prod_ids = array_map(function($p) { return $p->id; }, $products);
            $this->db->select('product_id, COUNT(*) as cnt');
            $this->db->where_in('product_id', $prod_ids);
            $this->db->group_by('product_id');
            $gallery_res = $this->db->get('product_gallery')->result();
            foreach ($gallery_res as $g) {
                $gallery_counts[$g->product_id] = $g->cnt;
            }
        }

        $data['products'] = $products;
        $data['gallery_counts'] = $gallery_counts;
        $data['offset'] = $offset;
        $data['total'] = $total;
        $data['limit'] = $limit;
        $data['page'] = $page;
        $data['total_pages'] = $total_pages;
        $data['pagination'] = $this->General_model->render_pagination_html($page, $total_pages, $total, $limit);

        $this->load->view('admin/header', $data);
        $this->load->view('admin/products/index', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * AJAX endpoint for server-side products search, filter, and pagination
     */
    public function ajax_list()
    {
        $page        = max(1, (int)$this->input->get_post('page'));
        $limit       = in_array((int)$this->input->get_post('limit'), [5, 10, 25, 50, 100]) ? (int)$this->input->get_post('limit') : 10;
        $search      = trim($this->input->get_post('search') ?? '');
        $category_id = $this->input->get_post('category_id');
        $status      = $this->input->get_post('status');
        $stock_status= $this->input->get_post('stock_status');

        $where = [];
        if ($category_id !== '' && $category_id !== null) {
            $where['category_id'] = (int)$category_id;
        }
        if ($status !== '' && $status !== null) {
            $where['status'] = (int)$status;
        }
        if ($stock_status === 'in_stock') {
            $where['stock >'] = 0;
        } elseif ($stock_status === 'out_of_stock') {
            $where['stock ='] = 0;
        }

        $like = [];
        if (!empty($search)) {
            $like['name'] = $search;
            $like['sku']  = $search;
            $like['description'] = $search;
        }

        $total = $this->General_model->count_filtered_data('products', $where, $like);
        $total_pages = max(1, ceil($total / $limit));
        if ($page > $total_pages && $total > 0) {
            $page = $total_pages;
        }
        $offset = ($page - 1) * $limit;

        $products = $this->General_model->get_paginated_data('products', $where, $like, $limit, $offset, 'id DESC');

        // Gallery counts for visible products only
        $gallery_counts = [];
        if (!empty($products)) {
            $prod_ids = array_map(function($p) { return $p->id; }, $products);
            $this->db->select('product_id, COUNT(*) as cnt');
            $this->db->where_in('product_id', $prod_ids);
            $this->db->group_by('product_id');
            $gallery_res = $this->db->get('product_gallery')->result();
            foreach ($gallery_res as $g) {
                $gallery_counts[$g->product_id] = $g->cnt;
            }
        }

        // Category Map
        $categories = $this->General_model->getAll('categories');
        $cat_map = [];
        if (!empty($categories)) {
            foreach ($categories as $cat) {
                $cat_map[$cat->id] = $cat->name;
            }
        }

        $html = $this->load->view('admin/products/_rows', [
            'products'       => $products,
            'category_map'   => $cat_map,
            'gallery_counts' => $gallery_counts,
            'offset'         => $offset
        ], TRUE);

        $pagination = $this->General_model->render_pagination_html($page, $total_pages, $total, $limit);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'success'     => true,
                'html'        => $html,
                'pagination'  => $pagination,
                'total'       => $total,
                'page'        => $page,
                'total_pages' => $total_pages
            ]));
    }

    /**
     * Add new product
     */
    public function add()
    {
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('name', 'Product Name', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('category_id', 'Category', 'trim|required|numeric');
            $this->form_validation->set_rules('price', 'Regular Price', 'trim|required|numeric');
            $this->form_validation->set_rules('discount_price', 'Discount Price', 'trim|numeric');
            $this->form_validation->set_rules('stock', 'Stock Quantity', 'trim|numeric');

            if ($this->form_validation->run() === TRUE) {
                $name = $this->input->post('name', TRUE);
                $slug = url_title($this->input->post('slug') ? $this->input->post('slug') : $name, 'dash', TRUE);
                $category_id = (int) $this->input->post('category_id');
                $sku = $this->input->post('sku', TRUE);
                $price = (float) $this->input->post('price');
                $discount_price = $this->input->post('discount_price') !== '' ? (float) $this->input->post('discount_price') : NULL;
                $stock = (int) $this->input->post('stock');
                $short_description = $this->input->post('short_description', TRUE);
                $description = $this->input->post('description');
                $status = $this->input->post('status') ? 1 : 0;

                // Handle Main Image Upload (Max 2MB)
                $image_name = NULL;
                if (!empty($_FILES['image']['name'])) {
                    $config['upload_path']   = './uploads/products/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
                    $config['max_size']      = 2048; // Max 2MB
                    $config['encrypt_name']  = TRUE;

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();
                        $image_name  = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('admin/products/add');
                        return;
                    }
                }

                $insert_data = [
                    'category_id'       => $category_id,
                    'name'              => $name,
                    'slug'              => $slug,
                    'sku'               => $sku,
                    'price'             => $price,
                    'discount_price'    => $discount_price,
                    'stock'             => $stock,
                    'short_description' => $short_description,
                    'description'       => $description,
                    'image'             => $image_name,
                    'status'            => $status,
                    'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s')
                ];

                $insert_id = $this->General_model->insert('products', $insert_data);
                if ($insert_id) {
                    // Upload multiple gallery images (Max 2MB each)
                    $this->_upload_gallery_images($insert_id);

                    $this->session->set_flashdata('success', 'Product "' . $name . '" created successfully.');
                    redirect('admin/products');
                    return;
                } else {
                    $this->session->set_flashdata('error', 'Failed to save product. Please try again.');
                }
            }
        }

        $data['title'] = 'Add New Product - SRL Pixel Admin';
        $data['breadcrumb'] = 'Add Product';
        $data['product'] = NULL;
        $data['gallery'] = [];
        $data['categories'] = $this->General_model->getAll('categories', ['status' => 1]);
        $data['is_edit'] = FALSE;

        $this->load->view('admin/header', $data);
        $this->load->view('admin/products/form', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Edit existing product
     */
    public function edit($id = NULL)
    {
        if (empty($id)) {
            redirect('admin/products');
            return;
        }

        $product = $this->General_model->getOne('products', ['id' => $id]);
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found.');
            redirect('admin/products');
            return;
        }

        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $this->form_validation->set_rules('name', 'Product Name', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('category_id', 'Category', 'trim|required|numeric');
            $this->form_validation->set_rules('price', 'Regular Price', 'trim|required|numeric');
            $this->form_validation->set_rules('discount_price', 'Discount Price', 'trim|numeric');
            $this->form_validation->set_rules('stock', 'Stock Quantity', 'trim|numeric');

            if ($this->form_validation->run() === TRUE) {
                $name = $this->input->post('name', TRUE);
                $slug = url_title($this->input->post('slug') ? $this->input->post('slug') : $name, 'dash', TRUE);
                $category_id = (int) $this->input->post('category_id');
                $sku = $this->input->post('sku', TRUE);
                $price = (float) $this->input->post('price');
                $discount_price = $this->input->post('discount_price') !== '' ? (float) $this->input->post('discount_price') : NULL;
                $stock = (int) $this->input->post('stock');
                $short_description = $this->input->post('short_description', TRUE);
                $description = $this->input->post('description');
                $status = $this->input->post('status') ? 1 : 0;

                $image_name = $product->image;
                if (!empty($_FILES['image']['name'])) {
                    $config['upload_path']   = './uploads/products/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|webp|svg';
                    $config['max_size']      = 2048; // Max 2MB
                    $config['encrypt_name']  = TRUE;

                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('image')) {
                        if (!empty($product->image) && file_exists('./uploads/products/' . $product->image)) {
                            @unlink('./uploads/products/' . $product->image);
                        }
                        $upload_data = $this->upload->data();
                        $image_name  = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('admin/products/edit/' . $id);
                        return;
                    }
                }

                $update_data = [
                    'category_id'       => $category_id,
                    'name'              => $name,
                    'slug'              => $slug,
                    'sku'               => $sku,
                    'price'             => $price,
                    'discount_price'    => $discount_price,
                    'stock'             => $stock,
                    'short_description' => $short_description,
                    'description'       => $description,
                    'image'             => $image_name,
                    'status'            => $status,
                    'updated_at'        => date('Y-m-d H:i:s')
                ];

                $this->General_model->update('products', ['id' => $id], $update_data);

                // Upload additional gallery images if selected (Max 2MB each)
                $this->_upload_gallery_images($id);

                $this->session->set_flashdata('success', 'Product updated successfully.');
                redirect('admin/products');
                return;
            }
        }

        $data['title'] = 'Edit Product - SRL Pixel Admin';
        $data['breadcrumb'] = 'Edit Product';
        $data['product'] = $product;
        $data['gallery'] = $this->General_model->getAll('product_gallery', ['product_id' => $id]);
        $data['categories'] = $this->General_model->getAll('categories', ['status' => 1]);
        $data['is_edit'] = TRUE;

        $this->load->view('admin/header', $data);
        $this->load->view('admin/products/form', $data);
        $this->load->view('admin/footer', $data);
    }

    /**
     * Delete product along with its images and gallery
     */
    public function delete($id = NULL)
    {
        if (!empty($id)) {
            $product = $this->General_model->getOne('products', ['id' => $id]);
            if ($product) {
                // Remove main product image
                if (!empty($product->image) && file_exists('./uploads/products/' . $product->image)) {
                    @unlink('./uploads/products/' . $product->image);
                }

                // Remove all gallery images from disk and database
                $gallery_items = $this->General_model->getAll('product_gallery', ['product_id' => $id]);
                if (!empty($gallery_items)) {
                    foreach ($gallery_items as $item) {
                        if (!empty($item->image) && file_exists('./uploads/products/gallery/' . $item->image)) {
                            @unlink('./uploads/products/gallery/' . $item->image);
                        }
                    }
                    $this->General_model->delete('product_gallery', ['product_id' => $id]);
                }

                $this->General_model->delete('products', ['id' => $id]);
                $this->session->set_flashdata('success', 'Product and gallery images deleted successfully.');
            }
        }
        redirect('admin/products');
    }

    /**
     * Delete an individual product gallery image
     */
    public function delete_gallery_image($id = NULL, $product_id = NULL)
    {
        if (!empty($id) && !empty($product_id)) {
            $gallery = $this->General_model->getOne('product_gallery', ['id' => $id, 'product_id' => $product_id]);
            if ($gallery) {
                if (!empty($gallery->image) && file_exists('./uploads/products/gallery/' . $gallery->image)) {
                    @unlink('./uploads/products/gallery/' . $gallery->image);
                }
                $this->General_model->delete('product_gallery', ['id' => $id]);
                $this->session->set_flashdata('success', 'Gallery image deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Gallery image not found.');
            }
            redirect('admin/products/edit/' . $product_id);
            return;
        }
        redirect('admin/products');
    }

    /**
     * Quick product status toggle
     */
    public function status($id = NULL)
    {
        if (!empty($id)) {
            $product = $this->General_model->getOne('products', ['id' => $id]);
            if ($product) {
                $new_status = ($product->status == 1) ? 0 : 1;
                $this->General_model->update('products', ['id' => $id], ['status' => $new_status]);
                $this->session->set_flashdata('success', 'Product status updated to ' . ($new_status ? 'Active' : 'Inactive') . '.');
            }
        }
        redirect('admin/products');
    }

    /**
     * Helper to process multiple gallery images for a product (Max 2MB per file)
     */
    private function _upload_gallery_images($product_id)
    {
        if (empty($_FILES['gallery_images']['name']) || !is_array($_FILES['gallery_images']['name'])) {
            return;
        }

        $this->load->library('upload');

        $gallery_config = [
            'upload_path'   => './uploads/products/gallery/',
            'allowed_types' => 'gif|jpg|jpeg|png|webp|svg',
            'max_size'      => 2048, // 2MB
            'encrypt_name'  => TRUE
        ];

        $file_count = count($_FILES['gallery_images']['name']);
        for ($i = 0; $i < $file_count; $i++) {
            $name = $_FILES['gallery_images']['name'][$i];
            if (empty($name)) {
                continue;
            }

            // Check file size: 2MB = 2097152 bytes
            if ($_FILES['gallery_images']['size'][$i] > 2097152) {
                continue;
            }

            $_FILES['gallery_item']['name']     = $_FILES['gallery_images']['name'][$i];
            $_FILES['gallery_item']['type']     = $_FILES['gallery_images']['type'][$i];
            $_FILES['gallery_item']['tmp_name'] = $_FILES['gallery_images']['tmp_name'][$i];
            $_FILES['gallery_item']['error']    = $_FILES['gallery_images']['error'][$i];
            $_FILES['gallery_item']['size']     = $_FILES['gallery_images']['size'][$i];

            $this->upload->initialize($gallery_config);
            if ($this->upload->do_upload('gallery_item')) {
                $upload_data = $this->upload->data();
                $this->General_model->insert('product_gallery', [
                    'product_id' => $product_id,
                    'image'      => $upload_data['file_name'],
                    'sort_order' => $i,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
