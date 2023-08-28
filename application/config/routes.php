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
$route['default_controller'] = 'logincontroller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* begin:: change password */
$route['profile-settings'] = 'MainController/profileSettings';
$route['profile-settings/([a-zA-Z/_0-9-]+)'] = 'MainController/$1';
/* end:: change password */

/* begin:: logout */
$route['logout'] = 'LoginController/logout';
/* end:: logout */

/* begin:: my profile */
$route['my_profile'] = 'MainController/myProfile';
$route['my_profile/([a-zA-Z/_0-9-]+)'] = 'MainController/$1';
/* end:: my profile */

/* begin:: dashboard */
$route['dashboard'] = 'MainController/index';
$route['dashboard/([a-zA-Z/_0-9-]+)'] = 'MainController/$1';
/* end:: dashboard */

/* begin:: news-report */
$route['news-report'] = 'News/ReportsController/index';
$route['news-report/([a-zA-Z/_0-9-]+)'] = 'News/ReportsController/$1';
/* end:: news-report */

/* begin:: news-recap */
$route['news-recap'] = 'News/RecapsController/index';
$route['news-recap/([a-zA-Z/_0-9-]+)'] = 'News/RecapsController/$1';
/* end:: news-recap */

/* begin:: search-area */
$route['search-area'] = 'News/SearchAreaController/index';
$route['search-area/([a-zA-Z/_0-9-]+)'] = 'News/SearchAreaController/$1';
/* end:: search-area */

/* begin:: users */
$route['users-management'] = 'Configs/UsersController/index';
$route['users-management/([a-zA-Z/_0-9-]+)'] = 'Configs/UsersController/$1';
/* end:: users */

/* begin:: Volunteers */
$route['volunteers-management'] = 'Configs/VolunteersController/index';
$route['volunteers-management/([a-zA-Z/_0-9-]+)'] = 'Configs/VolunteersController/$1';
/* end:: Volunteers */


/* begin:: Groups */
$route['groups-management'] = 'Configs/GroupsController/index';
$route['groups-management/([a-zA-Z/_0-9-]+)'] = 'Configs/GroupsController/$1';
/* end:: Groups */