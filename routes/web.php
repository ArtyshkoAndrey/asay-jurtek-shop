<?php
use Illuminate\Support\Facades\Route;
// if ((new App\Models\Settings)->statusSite()) {

  // Auth::routes();
//   getAdminRoute();

// } else {

  // getAdminRoute();
Route::get('admin/login', ['as' => 'admin.auth.login', 'uses' => 'Admin/Auth/LoginController@showLoginForm']);

  // Route::any('{all}', function () {
  //   return view('pages.site');
  // })->where('all', '.*');
// }


function getAdminRoute() {
  Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('login', ['as' => 'admin.auth.login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'admin.auth.login', 'uses' => 'Auth\LoginController@login']);
    // Password Reset Routes...
    Route::post('password/email', ['as' => 'admin.auth.password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/email', ['as' => 'admin.auth.password.email', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/reset', ['as' => 'admin.auth.password.reset', 'uses' => 'Auth\ResetPasswordController@reset']);
    Route::get('password/reset/{token?}', ['as' => 'admin.auth.password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
  });

  Route::group(['prefix' => 'admin', 'guard' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth:admin']], function () {

    Route::get('logout', 'Auth\LoginController@logout')->name('admin.auth.logout');

    Route::resource('/order', 'OrderController', ['as' => 'admin.store']); 

  });
}
