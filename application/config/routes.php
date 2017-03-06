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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['questions/create'] = 'questions/create';
$route['questions/index'] = 'questions/index';
$route['questions/(:any)'] = 'questions/view/$1';
$route['questions'] = 'questions';

$route['sections/create'] = 'sections/create';
$route['sections/index'] = 'sections/index';
$route['sections/(:any)'] = 'sections/view/$1';
$route['sections'] = 'sections';


$route['templates/create'] = 'templates/create';
$route['templates/index'] = 'templates/index';
$route['templates/(:any)'] = 'templates/view/$1';
$route['templates'] = 'templates';


$route['customers/create'] = 'customers/create';
$route['customers/display'] = 'customers/display';
$route['customers/applications/(:any)'] = 'customers/showtemplate/$1';
$route['customers/(:num)/applications/(:any)'] = 'customers/showapplication/$2/$1';

$route['customers/(:num)/savedapplications/(:any)'] = 'customers/showsavedapplication/$2/$1';


$route['customers/(:any)'] = 'customers/view/$1';
$route['customers'] = 'customers';


$route['applications/index'] = 'applications/index';
$route['applications/applicant/(:any)'] = 'applications/applicant/$1';
$route['applications/question/(:any)'] = 'applications/question/$1';


$route['auth'] = 'authentication/auth/login';
$route['auth/index'] = 'authentication/auth/index';
$route['auth/edit_user'] = 'authentication/auth/edit_user/$1';
$route['auth/(:any)'] = 'authentication/auth/$1';

$route['handlers/create'] = 'handlers/create';
$route['handlers/index'] = 'handlers/index';
$route['handlers/(:any)'] = 'handlers/view/$1';
$route['handlers'] = 'handlers';
$route['widget.js'] = 'embed/script';
$route['widget/(:num)/(:any)'] = 'customers/showapplication/$2/$1';

$route['api/index'] = 'api/index';
$route['api/mform'] = 'api/mform';
$route['api/busconfirm'] = 'api/busconfirm';

/* Email Builder routes */
$route['emailbuilder/image'] = 'emailbuilder/image';
$route['emailbuilder/email'] = 'emailbuilder/email';
$route['emailbuilder/upload'] = 'emailbuilder/upload';
$route['emailbuilder/(:any)'] = 'emailbuilder/index/$1';
$route['emailbuilder/(:any)/(:any)'] = 'emailbuilder/index/$1/$2';
$route['emailbuilder'] = 'emailbuilder';
/* end Email Builder routes */

$route['(:any)'] = 'questions/view/$1';
