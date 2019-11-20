<?php

/*
|--------------------------------------------------------------------------
| Xylophone\Base Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are
| handled by the Xylophone\Base package.
|
*/

Route::group(
[
    'namespace'  => 'Xylophone\CRUD\app\Http\Controllers',
    'middleware' => 'web',
    'prefix'     => config('xylophone.base.route_prefix'),
],
function () {
    // if not otherwise configured, setup the auth routes
    if (config('xylophone.base.setup_auth_routes')) {
        // Authentication Routes...
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('xylophone.auth.login');
        Route::post('login', 'Auth\LoginController@login');
        Route::get('logout', 'Auth\LoginController@logout')->name('xylophone.auth.logout');
        Route::post('logout', 'Auth\LoginController@logout');

        // Registration Routes...
        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('xylophone.auth.register');
        Route::post('register', 'Auth\RegisterController@register');

        // Password Reset Routes...
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('xylophone.auth.password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('xylophone.auth.password.reset.token');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('xylophone.auth.password.email');
    }

    // if not otherwise configured, setup the dashboard routes
    if (config('xylophone.base.setup_dashboard_routes')) {
        Route::get('dashboard', 'AdminController@dashboard')->name('xylophone.dashboard');
        Route::get('/', 'AdminController@redirect')->name('xylophone');
    }

    // if not otherwise configured, setup the "my account" routes
    if (config('xylophone.base.setup_my_account_routes')) {
        Route::get('edit-account-info', 'MyAccountController@getAccountInfoForm')->name('xylophone.account.info');
        Route::post('edit-account-info', 'MyAccountController@postAccountInfoForm');
        Route::post('change-password', 'MyAccountController@postChangePasswordForm')->name('xylophone.account.password');
    }
});
