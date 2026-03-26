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
// $route['default_controller'] = 'welcome';
$route['ringWeb/json_viewer'] = 'index.php/ringWeb/Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

// application/config/routes.php
$route['api/filemotionplus']['get']              = 'filemotionplus/index';
$route['api/filemotionplus/(:num)']['get']       = 'filemotionplus/get/$1';
$route['api/filemotionplus']['post']             = 'filemotionplus/save';
$route['api/filemotionplus']['options']             = 'filemotionplus/save';
$route['api/filemotionplus/(:num)']['put']       = 'filemotionplus/update/$1';
$route['api/filemotionplus/(:num)']['delete']    = 'filemotionplus/delete/$1';
$route['api/filemotionplus/delete(:num)']        = 'filemotionplus/delete/$1';

$route['api/filemotionplus/latest/(:num)']['get']     = 'filemotionplus/latest_by_visit/$1';
$route['api/filemotionplus/templates/(:num)']['get']  = 'filemotionplus/templates_by_visit/$1';
$route['api/filemotionplus/by_visit/(:num)'] = 'filemotionplus/by_visit/$1';
$route['api/filemotionplus/delete/(:num)']['post']   = 'filemotionplus/delete/$1';
$route['api/filemotionplus/templates']['get']   = 'filemotionplus/get_templates/';

$route['api/filemotionplus']['options']          = 'filemotionplus/index';
$route['api/filemotionplus/(:any)']['options']   = 'filemotionplus/index';
$route['api/filemotionplus/(:any)/(:any)']['options'] = 'filemotionplus/index';

$route['api/patient/(:any)/visits']['get'] = 'patient_documents/visits/$1';
$route['api/patient/(:any)/visits']['options'] = 'patient_documents/visits/$1';


// Clean endpoints for FE services
$route['item-master/search']['GET'] = 'itemmaster/search';
$route['item-master/search-by-code']['GET'] = 'itemmaster/search_by_code';
$route['item-master/(:num)']['GET'] = 'itemmaster/show/$1';


// API base
$route['api/itemstock']['GET']                  = 'Itemstock/list';

$route['api/itemstock']['POST']                 = 'Itemstock/create';


$route['api/itemstock']['OPTIONS']              = 'Itemstock/create';
$route['api/itemstock/(:num)']['GET']           = 'Itemstock/get/$1';
$route['api/itemstock/(:num)']['PUT']           = 'Itemstock/update/$1';
$route['api/itemstock/(:num)']['DELETE']        = 'Itemstock/delete/$1';
$route['api/itemstock/(:num)/move']['POST']     = 'apItemstock/move/$1';        // purchase/sale/adjust
$route['api/itemstock/history']['GET']          = 'Itemstock/history';        // by StockId or ItemId
$route['api/itemstock/search-items']['GET']     = 'Itemstock/search_items';
$route['api/itemstock/available']['GET']        = 'Itemstock/available';
$route['api/itemstock/available']['OPTIONS']    = 'Itemstock/available';

$route['api/itemstock/check-batch']['GET']        = 'Itemstock/check_batch';
$route['api/itemstock/check-batch']['OPTIONS']    = 'Itemstock/check_batch';


$route['api/itemstock/StockMovement']['GET']          = 'Itemstock/StockMovement'; 
$route['api/itemstock/StockMovement']['OPTIONS']      = 'Itemstock/StockMovement'; 

$route['api/itemstock/updateStockStatus']['POST'] = 'Itemstock/update_status';
$route['api/itemstock/updateStockStatus']['OPTIONS'] = 'Itemstock/update_status';

$route['api/itemstock/MovementAdd']['POST']    = 'Itemstock/MovementAdd';
$route['api/itemstock/MovementAdd']['OPTIONS'] = 'Itemstock/MovementAdd';

$route['api/itemstock/filters']['GET']        = 'Itemstock/Filters';
$route['api/itemstock/filters']['OPTIONS']    = 'Itemstock/Filters';

$route['alerts_summary']['GET']     = 'itemstock/alerts_summary';
$route['alerts_summary']['OPTIONS'] = 'itemstock/alerts_summary';

$route['invoice/bill/(:num)'] = 'invoice/print/$1';

$route['api/common/navigation'] = 'navigation/index';
$route['PackageMaster/save'] = 'PackageMasterApi/save';

$route['PackageMaster/delete/(:num)'] = 'PackageMasterApi/delete/$1';

$route['PackageMaster/OPTIONS/(:num)'] = 'PackageMasterApi/delete/$1';

$route['invoice/prescription/OPTIONS/(:num)'] = 'invoice/prescription/$1';
$route['invoice/prescription/Get/(:num)'] = 'invoice/prescription/$1';

$route['invoice/clinicalsummary/OPTIONS/(:num)'] = 'invoice/clinicalsummary/$1';
$route['invoice/clinicalsummary/Get/(:num)'] = 'invoice/clinicalsummary/$1';


$route['invoice/insuranceinvoice/OPTIONS/(:num)'] = 'invoice/insuranceinvoice/$1';
$route['invoice/insuranceinvoice/Get/(:num)'] = 'invoice/insuranceinvoice/$1';




