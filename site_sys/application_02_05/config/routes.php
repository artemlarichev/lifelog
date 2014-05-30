<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




$route['default_controller'] = "catalog";
$route['scaffolding_trigger'] = "";
$route['search/result/(.*)'] = "catalog/search_result/$1";
$route['group/(.*)'] = "catalog/group/$1";
$route['basket'] = "catalog/basket";
$route['parts/(.*)'] = "catalog/parts/$1";          
$route['articles/keywords/(.*)'] = "articles/keywords/$1";
$route['articles/del/(.*)'] = "articles/del/$1";
$route['articles/edit_article/(.*)'] = "articles/edit_article/$1";
$route['articles/edit_cat/(.*)'] = "articles/edit_cat/$1";    



$route['articles/(.*)'] = "articles/show_article/$1";

$route['register'] = "catalog/page/register";
$route['contacts'] = "catalog/page/contacts";
$route['shops'] = "catalog/page/shops";
$route['order'] = "catalog/page/order";
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
| 	example.com/class/method/id/
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
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['scaffolding_trigger'] = 'scaffolding';
|
| This route lets you set a "secret" word that will trigger the
| scaffolding feature for added security. Note: Scaffolding must be
| enabled in the controller in which you intend to use it.   The reserved
| routes must come before any wildcard or regular expression routes.
|


$route['default_controller'] = "study";
$route['scaffolding_trigger'] = "";
$route['seminary/redirect/(.*)'] = "/seminary/redirect/$1";
$route['seminary/(.*)'] = "seminary/index/$1";
$route['en/seminary'] = "seminary/index/null/en";
$route['en/seminary/redirect/(.*)'] = "/seminary/redirect/$1/en";
$route['en/seminary/(.*)'] = "/seminary/index/$1/en";

$route['news/redirect/(.*)'] = "/news/redirect/$1";
$route['en/news/redirect/(.*)'] = "/news/redirect/$1/en";
$route['news/show_add_block/(.*)'] = "news/show_add_block/$1";
$route['news/(.*)'] = "news/index/$1";
$route['en/news/(.*)'] = "news/index/$1/en";
$route['en/news'] = "news/index/null/en";

$route['gallery/redirect/(.*)'] = "/gallery/redirect/$1";
$route['en/gallery/redirect/(.*)'] = "/gallery/redirect/$1/en";
$route['gallery/show_add_block/(.*)'] = "gallery/show_add_block/$1";
$route['gallery/(.*)'] = "gallery/index/$1";
$route['en/gallery/(.*)'] = "gallery/index_en/$1";
$route['en/gallery'] = "gallery/index/null/null/null/en";

$route['en/resource/(.*)'] = "resource/index/en";
$route['en/resource'] = "resource/index/en";
$route['resource/(.*)'] = "resource/index/rus";
$route['resource'] = "resource/index/rus";
$route['search'] = "resource/find";


$route['en/study/(.*)/extramural'] = "study/index/en/$1/extramural";
$route['study/(.*)/full-time'] = "study/index/rus/$1/full-time";

$route['en/study/(.*)/extramural/courses'] = "study/courses/en/$1/extramural";
$route['en/study/(.*)/full-time/courses'] = "study/courses/en/$1/full-time";
$route['study/(.*)/extramural/courses'] = "study/courses/rus/$1/extramural";
$route['study/(.*)/full-time/courses'] = "study/courses/rus/$1/full-time";
$route['en/study/(.*)/courses'] = "study/courses/en/$1";
$route['study/(.*)/courses'] = "study/courses/rus/$1";

$route['en/study/(.*)/extramural/program'] = "study/program/en/$1/extramural";
$route['en/study/(.*)/full-time/program'] = "study/program/en/$1/full-time";
$route['study/(.*)/extramural/program'] = "study/program/rus/$1/extramural";
$route['study/(.*)/full-time/program'] = "study/program/rus/$1/full-time";
$route['en/study/(.*)/program'] = "study/program/en/$1";
$route['study/(.*)/program'] = "study/program/rus/$1";



$route['en/study/(.*)'] = "study/index/en/$1";
$route['en/study'] = "study/index/en";
$route['study/ect/(.*)'] = "study/ect/rus/$1";
$route['en/study/ect/(.*)'] = "study/ect/en/$1";
$route['study/(.*)'] = "study/index/rus/$1";



$route['en'] = "main_page/index/en";
$route['en/index/redirect'] = "main_page/index/en";
$route['index/redirect'] = "main_page/index";
//$route['en/index/redirect/'] = "main_page/index/en";

$route['en/editors/(.*)'] = "editors/$1/en";

$route['editors'] = "editors/seminary";
$route['en/editors'] = "editors/seminary/index/0/en";

 */


//$route['materials/([[:alnum:]]+)/([[:alnum:]]+)'] = "cat/view_prod/$1/$2";
//$route['page/([[:alnum:]]+)'] = "page/show_page/$1";

/*
$route['admin'] = "admin/user/login";
$route['search'] = "main_page/search";
$route['confirm'] = "main_page/send";
$route['send'] = "main_page/send";
$route['search_cars'] = "main_page/search_cars";
$route['search_cars/([[:alnum:]/]+)'] = "main_page/search_cars/$1";
$route['search?'] = "main_page/search";
$route['part/([[:alnum:]]+)'] = "main_page/part/$1";


$route['cart'] = "main_page/basket";
$route['basket'] = "main_page/basket";
$route['del_from_basket/(:num)'] = "main_page/del_from_basket/$1";

 $route['search/([[:alnum:]]+)/(:num)'] = "main_page/search/$1/$2";

$route['materials/([[:alnum:]/]+)audio'] = "cat/showTypeUrl/1";
$route['materials/([[:alnum:]/]+)video'] = "cat/showTypeUrl/2";

$route['materials/([[:alnum:]/]+)books'] = "cat/showTypeUrl/4";
$route['materials/([[:alnum:]/]+)photos'] = "cat/showTypeUrl/5";


$route['about'] = "page/show_page/about";
$route['contact'] = "main_page/show_page/contact";
$route['contacts'] = "main_page/show_page/contacts";
$route['order'] = "main_page/show_page/order";
$route['login'] = "main_page/login";
$route['exit_user'] = "main_page/exit_user";

*/

/* End of file routes.php */
/* Location: ./system/application/config/routes.php */