<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List all categories
     */
    public function index()
    {
        $data['title'] = 'Product Categories - SRL Pixel LED\'s Glowing Hub';
        $data['breadcrumb'] = 'Categories';

        $categories = $this->General_model->getAll('categories', ['status' => 1]);

        // Count products per category
        $category_counts = [];
        if (!empty($categories)) {
            foreach ($categories as $c) {
                $category_counts[$c->id] = $this->General_model->count_filtered_data('products', [
                    'category_id' => $c->id,
                    'status'      => 1
                ]);
            }
        }

        $data['categories'] = $categories;
        $data['category_counts'] = $category_counts;

        $this->load->view('header', $data);
        $this->load->view('categories_list_view', $data);
        $this->load->view('footer', $data);
    }

    /**
     * Show products for a specific category
     */
    public function view($id = NULL)
    {
        if (empty($id)) {
            redirect('categories');
            return;
        }

        // Find Category by ID
        $category = $this->General_model->getOne('categories', ['id' => $id, 'status' => 1]);

        if (!$category) {
            show_404();
            return;
        }

        // Fetch products in this category
        $products = $this->General_model->getAll('products', [
            'category_id' => $category->id,
            'status'      => 1
        ]);

        $data['title'] = html_escape($category->name) . ' - SRL Pixel LED Catalog';
        $data['category'] = $category;
        $data['products'] = $products;
        $data['total_products'] = count($products);

        $this->load->view('header', $data);
        $this->load->view('category_view', $data);
        $this->load->view('footer', $data);
    }
}
