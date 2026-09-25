<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Admin Portal Routes
$route['admin'] = 'admin/Login';
$route['admin/login'] = 'admin/Login/index';
$route['admin/register'] = 'admin/Login/register';
$route['admin/logout'] = 'admin/Login/logout';
$route['admin/dashboard'] = 'admin/Dashboard/index';
$route['admin/profile'] = 'admin/Profile/index';
$route['admin/profile/change_password'] = 'admin/Profile/change_password';

// Admin Categories CRUD
$route['admin/categories'] = 'admin/Categories/index';
$route['admin/categories/ajax_list'] = 'admin/Categories/ajax_list';
$route['admin/categories/add'] = 'admin/Categories/add';
$route['admin/categories/edit/(:num)'] = 'admin/Categories/edit/$1';
$route['admin/categories/delete/(:num)'] = 'admin/Categories/delete/$1';
$route['admin/categories/status/(:num)'] = 'admin/Categories/status/$1';

// Admin Products CRUD
$route['admin/products'] = 'admin/Products/index';
$route['admin/products/ajax_list'] = 'admin/Products/ajax_list';
$route['admin/products/add'] = 'admin/Products/add';
$route['admin/products/edit/(:num)'] = 'admin/Products/edit/$1';
$route['admin/products/delete/(:num)'] = 'admin/Products/delete/$1';
$route['admin/products/status/(:num)'] = 'admin/Products/status/$1';
// Admin Home Banners Management
$route['admin/home_banners']                      = 'admin/Home_banners/index';
$route['admin/home_banners/ajax_list']            = 'admin/Home_banners/ajax_list';
$route['admin/home_banners/add']                  = 'admin/Home_banners/add';
$route['admin/home_banners/create']               = 'admin/Home_banners/add';
$route['admin/home_banners/edit/(:num)']          = 'admin/Home_banners/edit/$1';
$route['admin/home_banners/delete/(:num)']        = 'admin/Home_banners/delete/$1';
$route['admin/home_banners/toggle_status/(:num)'] = 'admin/Home_banners/toggle_status/$1';
$route['admin/home_banners/status/(:num)']        = 'admin/Home_banners/toggle_status/$1';
$route['admin/banners']                           = 'admin/Home_banners/index';

// Admin Customer Listing
$route['admin/customers'] = 'admin/Customers/index';
$route['admin/customers/ajax_list'] = 'admin/Customers/ajax_list';
$route['admin/customers/status/(:num)'] = 'admin/Customers/status/$1';
$route['admin/customers/delete/(:num)'] = 'admin/Customers/delete/$1';

// Admin Orders Management
$route['admin/orders'] = 'admin/Orders/index';
$route['admin/orders/ajax_list'] = 'admin/Orders/ajax_list';
$route['admin/orders/detail/(:num)'] = 'admin/Orders/detail/$1';
$route['admin/orders/update_status'] = 'admin/Orders/update_status';

// Admin Offline Orders Management (POS / Counter Sales)
$route['admin/offline_orders']                        = 'admin/Offline_orders/index';
$route['admin/offline_orders/ajax_list']              = 'admin/Offline_orders/ajax_list';
$route['admin/offline_orders/create']                 = 'admin/Offline_orders/create';
$route['admin/offline_orders/store']                  = 'admin/Offline_orders/store';
$route['admin/offline_orders/detail/(:num)']          = 'admin/Offline_orders/detail/$1';
$route['admin/offline_orders/search_customers']       = 'admin/Offline_orders/search_customers';
$route['admin/offline_orders/search_products']        = 'admin/Offline_orders/search_products';
$route['admin/offline_orders/update_status']          = 'admin/Offline_orders/update_status';
$route['admin/offline_orders/update_payment_status']  = 'admin/Offline_orders/update_payment_status';
$route['admin/offline_orders/invoice/(:num)']         = 'admin/Offline_orders/invoice/$1';
$route['admin/offline_orders/edit/(:num)']            = 'admin/Offline_orders/edit/$1';
$route['admin/offline_orders/update/(:num)']          = 'admin/Offline_orders/update/$1';
$route['admin/offline_orders/update']                 = 'admin/Offline_orders/update';
$route['admin/offline_orders/delete/(:num)']          = 'admin/Offline_orders/delete/$1';
$route['admin/offline_orders/delete']                 = 'admin/Offline_orders/delete';

// Customer / User Portal Routes
$route['home'] = 'Home/index';
$route['categories'] = 'Category/index';
$route['category/(:num)'] = 'Category/view/$1';
$route['category/(:any)'] = 'Category/view/$1';
$route['products'] = 'Product/index';
$route['product/(:num)'] = 'Product/detail/$1';
$route['product/(:any)'] = 'Product/detail/$1';
$route['login']       = 'login/index';
$route['register']    = 'login/register';
$route['verify-otp']  = 'login/verify_otp';
$route['resend-otp']  = 'login/resend_otp';
$route['logout']      = 'login/logout';

// Customer Shopping Cart Routes
$route['cart'] = 'Cart/index';
$route['cart/add'] = 'Cart/add';
$route['cart/update'] = 'Cart/update_quantity';
$route['cart/remove/(:num)'] = 'Cart/remove/$1';
$route['cart/clear'] = 'Cart/clear';
$route['cart/checkout'] = 'Cart/checkout';

// Step-by-Step Checkout & Orders Flow
$route['checkout'] = 'Checkout/index';
$route['checkout/add_address'] = 'Checkout/add_address';
$route['checkout/place_order'] = 'Checkout/place_order';
$route['checkout/razorpay_create_order'] = 'Checkout/razorpay_create_order';
$route['checkout/razorpay_verify'] = 'Checkout/razorpay_verify';
$route['order/success/(:num)'] = 'Checkout/success/$1';
$route['order/invoice/(:num)'] = 'Checkout/invoice/$1';

$route['login'] = 'Login/index';
$route['register'] = 'Login/register';
$route['logout'] = 'Login/logout';

// Customer Profile, Addresses & Orders
$route['profile'] = 'Profile/index';
$route['profile/add_address'] = 'Profile/add_address';
$route['profile/edit_address/(:num)'] = 'Profile/edit_address/$1';
$route['profile/delete_address/(:num)'] = 'Profile/delete_address/$1';
$route['profile/set_default_address/(:num)'] = 'Profile/set_default_address/$1';
$route['profile/order/(:num)'] = 'Profile/order/$1';
$route['profile/invoice/(:num)'] = 'Checkout/invoice/$1';
$route['profile/change_password'] = 'Profile/change_password';

// Backward-compatible dashboard aliases
$route['dashboard'] = 'Profile/index';
$route['dashboard/add_address'] = 'Profile/add_address';
$route['dashboard/edit_address/(:num)'] = 'Profile/edit_address/$1';
$route['dashboard/delete_address/(:num)'] = 'Profile/delete_address/$1';
$route['dashboard/set_default_address/(:num)'] = 'Profile/set_default_address/$1';
$route['dashboard/order/(:num)'] = 'Profile/order/$1';
$route['dashboard/invoice/(:num)'] = 'Checkout/invoice/$1';
$route['dashboard/change_password'] = 'Profile/change_password';

// Admin Invoice Route
$route['admin/orders/invoice/(:num)'] = 'admin/Orders/invoice/$1';


