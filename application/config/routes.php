<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/

// Shop (public)
$route['default_controller'] = 'Shop';
$route['shop']               = 'Shop/index';
$route['shop/product/(:any)']= 'Shop/product/$1';
$route['shop/category/(:any)']='Shop/category/$1';
$route['shop/cart']          = 'Shop/cart';
$route['shop/checkout']      = 'Shop/checkout';
$route['shop/order_success'] = 'Shop/order_success';

// Admin
$route['admin']                     = 'Admin/dashboard';
$route['admin/login']               = 'Admin/login';
$route['admin/logout']              = 'Admin/logout';
$route['admin/dashboard']           = 'Admin/dashboard';
$route['admin/bangles']             = 'Admin/bangles';
$route['admin/bangles/add']         = 'Admin/add_bangle';
$route['admin/bangles/edit/(:num)'] = 'Admin/edit_bangle/$1';
$route['admin/bangles/delete/(:num)']='Admin/delete_bangle/$1';
$route['admin/orders']              = 'Admin/orders';
$route['admin/orders/(:num)']       = 'Admin/order_detail/$1';
$route['admin/orders/status/(:num)']= 'Admin/update_order_status/$1';
$route['admin/categories']          = 'Admin/categories';

$route['admin/bangles/toggle_featured/(:num)'] = 'Admin/toggle_featured/$1';
$route['admin/bangles/toggle_active/(:num)']   = 'Admin/toggle_active/$1';
$route['admin/categories/delete/(:num)']        = 'Admin/delete_category/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['auth/login']           = 'Auth/login';
$route['auth/register']        = 'Auth/register';
$route['auth/logout']          = 'Auth/logout';
$route['auth/google']          = 'Auth/google';
$route['auth/google_callback'] = 'Auth/google_callback';

$route['account/orders']        = 'Account/orders';
$route['account/order/(:num)']  = 'Account/order_detail/$1';
