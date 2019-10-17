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

require_once( BASEPATH .'database/DB'. EXT );
// $db =& DB();
// $query = $db->select('con_id, con_page_th, con_page_en');
// $query = $db->get('tb_contents');
// $result = $query->result();
// foreach( $result as $row ){
//   if(!empty($row->con_page_th)){
//     $route[str_replace("&","",str_replace(" ","",strtolower($row->con_page_th)))] = "main/pageDetail/".$row->con_id;
//   }else if(!empty($row->con_page_en)){
//     $route[str_replace("&","",str_replace(" ","",strtolower($row->con_page_en)))] = "main/pageDetail/".$row->con_id;
//   }
// }

// $query = $db->select('consub_id, consub_page_th, consub_page_en');
// $query = $db->get('tb_subcontents');
// $result = $query->result();
// foreach( $result as $row ){
//   if(!empty($row->consub_page_th)){
//     $route[str_replace(" ","",strtolower($row->consub_page_th))] = "main/pagesubDetail/".$row->consub_id;
//   }else if(!empty($row->consub_page_en)){
//     $route[str_replace(" ","",strtolower($row->consub_page_en))] = "main/pagesubDetail/".$row->consub_id;
//   }
// }

// $query = $db->select('*');
// $db->where(array('intro_show' => 1));
// $query = $db->get('tb_intro');
// $listIntor = $query->result();
// if(count($listIntor) != 0){
// 	$route['default_controller'] = 'main/pageintor';
// }else{
// 	$route['default_controller'] = 'main/index';
// }

$route['default_controller'] = 'administrator/index';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
