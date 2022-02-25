<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['verify/(:any)'] = 'Auth/verify/$1';
$route['reset/(:any)'] = 'Auth/reset/$1';
$route['share/(:any)'] = 'User/share/$1';
$route['pay/detail/(:any)'] = 'Payment/detail/$1';
$route['pay/(:any)'] = 'Payment/form/$1';
$route['pay/status/(:any)'] = 'Payment/status/$1';
$route['pay/invoice/(:any)'] = 'Payment/invoice/$1';
$route['ajax/type/(:any)'] = 'Withdraw/method/$1';
$route['ajax/check/rekening/(:any)/(:any)'] = 'Withdraw/detailrekening/$1/$2';
$route['withdraw/invoice/(:any)'] = 'Withdraw/invoice/$1';
$route['withdraw/status/(:any)'] = 'Withdraw/status/$1';
$route['withdraw/detail/(:any)'] = 'Withdraw/detail/$1';
$route['ajax/udunan/detail/user/(:any)'] = 'Udunan/detail_user/$1';
$route['ajax/udunan/detail/history/(:any)'] = 'Udunan/detail_history/$1';
$route['ajax/udunan/edit/user/(:any)'] = 'Udunan/edit_user/$1';
$route['ajax/udunan/edit/user/(:any)'] = 'Udunan/edit_user/$1';
$route['ajax/udunan/delete/user/(:any)'] = 'Udunan/delete_user/$1';
$route['ajax/udunan/edit/history/(:any)'] = 'Udunan/edit_history/$1';
$route['ajax/withdraw/detail/history/(:any)'] = 'Withdraw/detail_history/$1';
$route['ajax/user/profile/edit/(:any)'] = 'User/edit_profile/$1';
$route['logout'] = 'Auth/logout';
