<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "main";
$route['404_override'] = 'main/not_found';

$route['crawl_menu?:any'] = "main/crawl_menu";
$route['crawl_product?:any'] = "main/crawl_product";
$route['not-found'] = "main/not_found";
$route['addtocart'] = "ajax/add_to_cart";
$route['ajax/checkout'] = "ajax/add_to_order";
$route['ajax/fast-buy'] = "ajax/fast_buy";
$route['remove-cart-item/:any'] = "ajax/remove_cart_item";
$route['checkout'] = "main/checkout";
$route['bai-viet'] = "main/list_news";
$route['dich-vu'] = "main/services";
$route['bai-viet/page'] = "main/list_news";
$route['bai-viet/page/:num'] = "main/list_news";
$route['tag/:any'] = "main/tag";

// PAGE ADMIN
$route['admin/list-product'] = "admin/list_product";
$route['admin/post-product'] = "admin/post_product";
$route['admin/post-product/:num'] = "admin/post_product";
$route['admin/list-news'] = "admin/list_news";
$route['admin/list-orders'] = "admin/list_orders";
$route['admin/order/:num'] = "admin/order";
$route['ajax-admin/change-state-order'] = "ajax_admin/changeStateOrder";
$route['admin/post-news'] = "admin/post_news";
$route['admin/post-news/:num'] = "admin/post_news";
$route['ajax-admin/upload-image'] = "ajax_admin/upload_image";
$route['ajax-admin/get-child-menu'] = "ajax_admin/get_child_menu";

$route[':any/:any'] = "main/product_by_menu";
$route[':any'] = "main/news_detail";
/* End of file routes.php */
/* Location: ./application/config/routes.php */
