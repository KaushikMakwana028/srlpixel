<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Complete Product Catalog Listing
     */
    public function index()
    {
        $data['title'] = 'All Pixel LED Products - SRL Pixel Catalog';

        $search = trim($this->input->get('search') ?? '');
        $category_id = $this->input->get('category');

        $where = ['status' => 1];
        if (!empty($category_id) && is_numeric($category_id)) {
            $where['category_id'] = (int)$category_id;
        }

        $like = [];
        if (!empty($search)) {
            $like['name'] = $search;
            $like['sku']  = $search;
            $like['description'] = $search;
        }

        $products = $this->General_model->get_paginated_data('products', $where, $like, 200, 0, 'id DESC');
        $categories = $this->General_model->getAll('categories', ['status' => 1]);

        $cat_map = [];
        $category_counts = [];
        $total_products_count = $this->General_model->count_filtered_data('products', ['status' => 1]);
        if (!empty($categories)) {
            foreach ($categories as $cat) { 
                $cat_map[$cat->id] = $cat->name;
                $category_counts[$cat->id] = $this->General_model->count_filtered_data('products', [
                    'category_id' => $cat->id,
                    'status'      => 1
                ]);
            }
        }

        $data['products'] = $products;
        $data['categories'] = $categories;
        $data['category_map'] = $cat_map;
        $data['category_counts'] = $category_counts;
        $data['total_products_count'] = $total_products_count;
        $data['current_category'] = $category_id;
        $data['search_term'] = $search;

        $this->load->view('header', $data);
        $this->load->view('product_list_view', $data);
        $this->load->view('footer', $data);
    }

    /**
     * Product Details Page with Interactive Multi-Angle Gallery
     */
    public function detail($id = NULL)
    {
        if (empty($id)) {
            redirect('products');
            return;
        }

        // Find Product by ID
        $product = $this->General_model->getOne('products', ['id' => $id, 'status' => 1]);

        if (!$product) {
            show_404();
            return;
        }

        // Category info
        $category = $this->General_model->getOne('categories', ['id' => $product->category_id]);

        // Product Gallery images
        $gallery = $this->General_model->getAll('product_gallery', ['product_id' => $product->id]);

        // Related Products in the same category
        $related_products = $this->General_model->get_paginated_data('products', [
            'category_id' => $product->category_id,
            'id !='       => $product->id,
            'status'      => 1
        ], [], 4, 0, 'id DESC');

        // Discount calculation
        $discount_pct = 0;
        if (!empty($product->discount_price) && $product->discount_price < $product->price) {
            $discount_pct = round((($product->price - $product->discount_price) / $product->price) * 100);
        }

        $data['title'] = html_escape($product->name) . ' - SRL Pixel LED';
        $data['product'] = $product;
        $data['category'] = $category;
        $data['gallery'] = $gallery;
        $data['related_products'] = $related_products;
        $data['discount_pct'] = $discount_pct;

        $this->load->view('header', $data);
        $this->load->view('product_detail_view', $data);
        $this->load->view('footer', $data);
    }
}
