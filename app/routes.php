<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('prefix' => 'admin'), function(){
	Route::group(array('prefix' => 'user'), function(){
		Route::get('/', array('as' => 'admin.login', 'uses' => 'AdminController@admin_login'));
		Route::get('dashboard', array('as' => 'dashboard', 'uses' => 'UserController@getDashBoard'));
	}) ;
});


//Web services

Route::any('/cron-statistic', array('as'=>'pages.cron_stat', 'uses' => 'PageController@cron_stat'));

Route::any('/mobi-login', array('as'=>'web.mobi_login', 'uses' => 'WebController@mobi_login'));
Route::any('/mobi-update-profile', array('as'=>'web.mobi_update_profile', 'uses' => 'WebController@mobi_update_profile'));
Route::any('/mobi-change-password', array('as'=>'web.mobi_change_password', 'uses' => 'WebController@mobi_change_password'));
Route::any('/mobi-all-imported-data', array('as'=>'web.mobi_all_imported_data', 'uses' => 'WebController@mobi_all_imported_data'));
Route::any('/mobi-update-notes', array('as'=>'web.mobi_update_notes', 'uses' => 'WebController@mobi_update_notes'));
Route::any('/mobi-dashboard', array('as'=>'web.mobi_dashboard', 'uses' => 'WebController@mobi_dashboard'));
Route::any('/mobi-search-imported-data', array('as'=>'web.mobi_search_imported_data', 'uses' => 'WebController@mobi_search_imported_data'));
Route::any('/mobi-upload-image', array('as'=>'web.mobi_upload_image', 'uses' => 'WebController@mobi_upload_image'));

Route::any('/mytest', array('as'=>'admin.mytest', 'uses' => 'PageController@mytest'));
Route::any('/', array('as'=>'admin.login', 'uses' => 'AdminController@admin_login'));
Route::any('/login', array('as'=>'admin.login', 'uses' => 'AdminController@admin_login'));
Route::any('admin', array('as'=>'admin.login', 'uses' => 'AdminController@admin_login'));
Route::any('admin/login', array('as'=>'admin.login', 'uses' => 'AdminController@admin_login'));
Route::get('admin/dashboard/{trackable_id?}', array('as' => 'dashboard', 'uses' => 'UserController@getDashBoard'));
Route::any('admin/update_profile', array('as' => 'admin_update_profile', 'uses' => 'AdminController@admin_update_profile')); 

//Users
Route::any('admin/users/change_password/{role_id?}/{user_id?}', array('as' => 'users.admin_change_password', 'uses' => 'UserController@admin_change_password'))->where('role_id', '[0-9]+')->where('user_id', '[0-9]+');
Route::any('admin/users/{role_id?}', array('as' => 'users.admin_index',  'uses' => 'UserController@admin_index'))->where('role_id', '[0-9]+');
Route::any('admin/users/del/{role_id?}', array('as' => 'users.admin_del',  'uses' => 'UserController@admin_del'))->where('role_id', '[0-9]+');
Route::any('admin/users/add', array('as' => 'users.admin_add',  'uses' => 'UserController@admin_add')); 
Route::any('admin/users/import_data', array('as' => 'users.admin_import_data',  'uses' => 'UserController@admin_import_data')); 
Route::any('admin/users/select_user', array('as'=>'admin.admin_select_user', 'uses'=>'UserController@admin_select_user'));
Route::any('admin/users/edit/{role_id?}/{user_id?}', array('as' => 'users.admin_edit', 'uses' => 'UserController@admin_edit'))->where('role_id', '[0-9]+')->where('user_id', '[0-9]+');
Route::get('admin/users/status/{user_id?}', array('as' => 'users.admin_status', 'uses' => 'UserController@admin_status'))->where('user_id', '[0-9]+');
Route::get('admin/users/admin_remove/{user_id?}', array('as' => 'users.admin_remove', 'uses' => 'UserController@admin_remove'))->where('user_id', '[0-9]+');
Route::get('admin/users/admin_account_recover/{user_id?}', array('as' => 'users.admin_account_Recover', 'uses' => 'UserController@admin_account_Recover'))->where('user_id', '[0-9]+');
Route::get('admin/users/delete/{user_id?}', array('as' => 'users.admin_permanently_delete', 'uses' => 'UserController@admin_permanently_delete'))->where('user_id', '[0-9]+');


Route::any('admin/trackables/add', array('as' => 'trackables.admin_add',  'uses' => 'TrackableController@admin_add'));  
Route::any('admin/trackables', array('as' => 'trackables.admin_index',  'uses' => 'TrackableController@admin_index')); 
Route::any('admin/trackables/view/{id?}', array('as' => 'trackables.admin_view',  'uses' => 'TrackableController@admin_view'))->where('id', '[0-9]+');
Route::any('admin/trackables/admin_remove/{id?}', array('as' => 'trackables.admin_remove',  'uses' => 'TrackableController@admin_remove'))->where('id', '[0-9]+'); 
Route::any('admin/trackables/status/{id?}', array('as' => 'trackables.admin_status',  'uses' => 'TrackableController@admin_status'))->where('id', '[0-9]+');
Route::any('admin/trackables/edit/{id?}', array('as' => 'trackables.admin_edit',  'uses' => 'TrackableController@admin_edit'))->where('id', '[0-9]+');
Route::any('admin/trackables/assign_users/{id?}', array('as' => 'trackables.admin_assign_users',  'uses' => 'TrackableController@admin_assign_users'))->where('id', '[0-9]+');
Route::any('admin/trackable_values/{dashboard_id?}', array('as' => 'users.trackable_values',  'uses' => 'UserController@trackable_values'));
Route::any('admin/trackables/dashboard_index/{user_id?}/{trackable_id}', array('as' => 'trackables.admin_dashboard_index2',  'uses' => 'TrackableController@admin_dashboard_index'))->where('user_id', '[0-9]+')->where('trackable_id', '[0-9]+');
Route::any('admin/trackables/dashboard_index/{user_id?}/', array('as' => 'trackables.admin_dashboard_index',  'uses' => 'TrackableController@admin_dashboard_index'))->where('user_id', '[0-9]+');
Route::any('admin/trackables/dashboard_view/{user_id?}/{trackable_id?}', array('as' => 'trackables.admin_dashboard_view',  'uses' => 'TrackableController@admin_dashboard_view'))->where('user_id', '[0-9]+')->where('trackable_id', '[0-9]+');
Route::any('admin/trackables/admin_dashboard_remove/{id?}', array('as' => 'trackables.admin_dashboard_remove',  'uses' => 'TrackableController@admin_dashboard_remove'))->where('id', '[0-9]+');
Route::any('admin/trackables/admin_dashboard_remove_view/{id?}', array('as' => 'trackables.admin_dashboard_remove_view',  'uses' => 'TrackableController@admin_dashboard_remove_view'))->where('id', '[0-9]+');

Route::any('admin/trackbles_users_status/{id?}/{dashboard_id?}', array('as' => 'users.trackbles_users_status',  'uses' => 'UserController@trackbles_users_status'))->where('id', '[0-9]+');

Route::get('admin/users/view/{role_id?}/{user_id?}', array('as' => 'users.admin_view', 'uses' => 'UserController@admin_view'))->where('user_id', '[0-9]+');
Route::get('admin/logout', array('as' => 'logout', 'uses' => 'AdminController@getLogout'));