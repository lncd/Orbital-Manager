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
| URI contains no data. In the above example, the 'welcome' class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'static_content';
$route['404_override'] = '';

$route['about'] = 'static_content/about';
$route['contact'] = 'static_content/contact';
$route['signout'] = 'signin/signout';
$route['planner'] = 'tools/project_planner';
$route['policy'] = 'tools/policy_guidance';
$route['changelog'] = 'static_content/changelog';

$route['project/(:any)/upload_token'] = "projects/get_upload_token/$1";
$route['project/(:any)/public/files'] = "files/list_files_public/$1";
$route['project/(:any)/collections'] = "files/list_file_sets/$1";
$route['project/(:any)/datasets'] = "datasets/list_datasets/$1";
$route['project/(:any)/files'] = "files/list_files/$1";
$route['project/(:any)/edit'] = "projects/edit/$1";
$route['project/(:any)/delete'] = "projects/delete/$1";
$route['project/(:any)/public'] = "projects/view_public/$1";
$route['project/(:any)/collections/add'] = "files/create_new_file_set/$1";
$route['project/(:any)/files/add'] = "files/create_new_file/$1";
$route['project/(:any)/datasets/add'] = "datasets/create_new_dataset/$1";
$route['project/(:any)/timeline/comment'] = "projects/timeline_add_comment/$1";
$route['project/(:any)/timeline/event'] = "projects/timeline_add_event/$1";
$route['project/(:any)'] = "projects/view/$1";
$route['projects/public'] = "projects/list_public";

$route['file/(:any)/download'] = "files/download_file/$1";
$route['file/(:any)/edit'] = "files/edit_file/$1";
$route['file/(:any)/public'] = "files/view_file_public/$1";
$route['file/(:any)/delete'] = "files/delete/$1";
$route['file/(:any)'] = "files/view_file/$1";
$route['collection/(:any)/edit'] = "files/edit_file_set/$1";
$route['collection/(:any)/delete'] = "files/delete_file_set/$1";
$route['collection/(:any)/public'] = "files/view_file_set_public/$1";
$route['collection/(:any)'] = "files/view_file_set/$1";

$route['query/(:any)/delete'] = "datasets/delete_query/$1";
$route['query/(:any)/edit'] = "datasets/edit_query/$1";
$route['query/(:any)'] = "datasets/view_query/$1";
$route['dataset/(:any)/query'] = "datasets/create_query/$1";
$route['dataset/(:any)'] = "datasets/view_dataset/$1";

$route['licence/(:any)/json'] = "licences/view_licence_json/$1";
$route['licence/(:any)'] = "licences/view_licence/$1";

$route['admin/licences/add'] = "admin/licences_add";
$route['admin/licence/(:num)/edit'] = "admin/licence_edit/$1";
$route['admin/licence/(:num)/enable'] = "admin/licence_enable/$1";
$route['admin/licence/(:num)/disable'] = "admin/licence_disable/$1";
$route['admin/licence/(:num)/delete'] = "admin/licence_delete/$1";

// End of file routes.php
// Location: ./config/routes.php