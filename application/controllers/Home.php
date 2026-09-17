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

        // 3. Dynamic Full Banner Hero Showcase from Database (Admin added banners)
        $today = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('home_banners');
        $this->db->where('status', 1);
        $this->db->where('banner_type', 'home');
        $this->db->group_start();
            $this->db->where('start_date IS NULL', null, false);
            $this->db->or_where('start_date <=', $today);
        $this->db->group_end();
        $this->db->group_start();
            $this->db->where('end_date IS NULL', null, false);
            $this->db->or_where('end_date >=', $today);
        $this->db->group_end();
        $this->db->order_by('display_order ASC, id DESC');
        $db_banners = $this->db->get()->result();

        $slides = [];
        if (!empty($db_banners)) {
            foreach ($db_banners as $b) {
                $img_path = 'assets/images/banner_1.png';
                if (!empty($b->image)) {
                    if (file_exists('./uploads/banners/' . $b->image)) {
                        $img_path = 'uploads/banners/' . $b->image;
                    } elseif (file_exists('./assets/images/' . $b->image)) {
                        $img_path = 'assets/images/' . $b->image;
                    } else {
                        $img_path = 'uploads/banners/' . $b->image;
                    }
                }

                $btn_link = base_url('products');
                if (!empty($b->button_link)) {
                    $btn_link = (strpos($b->button_link, 'http') === 0) ? $b->button_link : base_url(ltrim($b->button_link, '/'));
                }

                $slides[] = [
                    'id'          => $b->id,
                    'badge'       => !empty($b->badge_text) ? $b->badge_text : 'FEATURED SHOWCASE',
                    'title'       => $b->title,
                    'subtitle'    => $b->subtitle,
                    'btn_text'    => !empty($b->button_text) ? $b->button_text : 'Shop Now',
                    'btn_link'    => $btn_link,
                    'icon'        => 'bi-lightning-charge-fill',
                    'banner_img'  => $img_path
                ];
            }
        }

        // Fallback to default slides if no banners configured
        if (empty($slides)) {
            $slides = [
                [
                    'badge'       => 'EXCLUSIVE COLLECTION 2026',
                    'title'       => 'Designer Ambient & Vintage Pendant Lighting',
                    'subtitle'    => 'Warm Edison filament glow, industrial geometric accents, and architectural pendant illumination for premium spaces.',
                    'btn_text'    => 'Explore Designer Lights',
                    'btn_link'    => base_url('products'),
                    'icon'        => 'bi-lightbulb-fill',
                    'banner_img'  => 'assets/images/banner_1.png'
                ],
                [
                    'badge'       => 'DREAM-COLOR INNOVATION',
                    'title'       => 'Digital RGB Pixel Strips & Flexible Neon Flex',
                    'subtitle'    => 'Individually addressable chasing LEDs, programmable dynamic color waves, and waterproof architectural neon ropes.',
                    'btn_text'    => 'Shop Pixel Strips',
                    'btn_link'    => base_url('category/1'),
                    'icon'        => 'bi-rainbow',
                    'banner_img'  => 'assets/images/banner_2.jpg'
                ],
                [
                    'badge'       => 'SMART STAGE & FAÇADE CONTROL',
                    'title'       => 'Programmable Pixel Controllers & DMX Consoles',
                    'subtitle'    => 'Seamless SD-card programming, Art-Net synchronization, and master control hardware for concerts and architectural facades.',
                    'btn_text'    => 'Discover Controllers',
                    'btn_link'    => base_url('category/3'),
                    'icon'        => 'bi-sliders2-vertical',
                    'banner_img'  => 'assets/images/banner_3.jpg'
                ]
            ];
        }

        $data['slides'] = $slides;

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
