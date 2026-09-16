<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Primary Storefront Homepage
     */
    public function index()
    {
        $data['title'] = 'SRL Pixel LED\'s Glowing Hub - Premium Pixel Strips, Controllers & Neon Flex';
        $data['meta_description'] = 'Discover high-grade addressable pixel LEDs, neon flex, smart SD card controllers, and waterproof power supplies at SRL Pixel LED Hub.';

        // 1. Fetch Active Categories
        $categories = $this->General_model->getAll('categories', ['status' => 1]);
        $data['categories'] = $categories;

        // 2. Fetch Active Products
        $products = $this->General_model->getAll('products', ['status' => 1]);

        // Build Category Map and Group Products Category-wise
        $category_map = [];
        $category_products = [];
        if (!empty($categories)) {
            foreach ($categories as $cat) {
                $category_map[$cat->id] = $cat;
                $category_products[$cat->id] = [];
            }
        }

        if (!empty($products)) {
            foreach ($products as $prod) {
                if (isset($category_products[$prod->category_id])) {
                    $category_products[$prod->category_id][] = $prod;
                }
            }
        }

        $data['category_map'] = $category_map;
        $data['category_products'] = $category_products;
        $data['all_products'] = $products;

        // 3. Curated Hero Slider Slides with Real High-Definition Product Photos
        $data['slides'] = [
            [
                'badge'       => 'NEW ARRIVALS 2026',
                'title'       => 'WS2812B & SPI Digital Pixel LED Strips',
                'subtitle'    => 'Individually addressable dream-color LED lighting with ultra-bright IC control for architectural and festival decor.',
                'btn_text'    => 'Shop Pixel Strips',
                'btn_link'    => base_url('category/1'),
                'bg_gradient' => 'linear-gradient(135deg, #131722 0%, #29102b 50%, #0d1017 100%)',
                'icon'        => 'bi-rainbow',
                'image'       => 'assets/images/slide_pixel_strip.jpg'
            ],
            [
                'badge'       => 'STAGE & FAÇADE CONTROL',
                'title'       => 'K-1000C & Art-Net Smart Pixel Controllers',
                'subtitle'    => 'Seamless SD card programming and DMX512 synchronization for concerts, clubs, and building elevations.',
                'btn_text'    => 'Explore Controllers',
                'btn_link'    => base_url('category/3'),
                'bg_gradient' => 'linear-gradient(135deg, #0d1527 0%, #1e1b3d 50%, #0c0e17 100%)',
                'icon'        => 'bi-sliders2-vertical',
                'image'       => 'assets/images/slide_controller.jpg'
            ],
            [
                'badge'       => 'WATERPROOF ARCHITECTURAL',
                'title'       => 'Flexible 12V Silicone Neon Flex RGB Lights',
                'subtitle'    => 'Smooth dot-free silicone diffuse illumination designed for signs, interior accents, and commercial spaces.',
                'btn_text'    => 'Discover Neon Flex',
                'btn_link'    => base_url('category/2'),
                'bg_gradient' => 'linear-gradient(135deg, #241128 0%, #131929 50%, #0a0d16 100%)',
                'icon'        => 'bi-magic',
                'image'       => 'assets/images/slide_neon_flex.jpg'
            ]
        ];

        // 4. Shopping Event / Mega Offer Details
        $data['offer_event'] = [
            'title'       => 'PixelLEDlights shopping Event',
            'subtitle'    => 'Hurry and get discounts on all PixelLEDlights devices up to 20% On LED expo INDORE , MP',
            'button_text' => 'Go Shopping',
            'button_link' => base_url('products'),
            'image'       => 'assets/images/promo_led_expo.jpg',
            // Set 5 days from now for live timer demonstration
            'end_time'    => date('Y-m-d H:i:s', strtotime('+5 days 14 hours 22 minutes'))
        ];

        $this->load->view('header', $data);
        $this->load->view('home_view', $data);
        $this->load->view('footer', $data);
    }
}
