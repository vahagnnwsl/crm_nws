<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth']], function () {

    Route::get('/', 'IndexController@home')->name('admin.index');
    Route::get('/profile', 'IndexController@profile')->name('account.profile');
    Route::put('/profile', 'IndexController@updateProfile')->name('account.profile.update');

    Route::get('/roles/{id}', 'RoleController@get');

    Route::get('/roles', 'RoleController@index')->name('roles.index')->middleware('permission:view_roles_list');

    Route::post('/roles', 'RoleController@store')->name('roles.store')->middleware('permission:roles_edit_delete_update');
    Route::post('/roles/{id}', 'RoleController@syncPermissions')->middleware('permission:roles_edit_delete_update');

    Route::get('/permissions', 'PermissionController@index')->name('permissions.index')->middleware('permission:view_permissions_list');

    Route::get('/users/{id}/login', 'UserController@login')->name('users.login')->middleware('permission:login_via_anther_user');


    Route::post('/users', 'UserController@store')->name('users.store')->middleware('permission:invite_user');
    Route::get('/users/{id}/resend-invitation', 'UserController@resendInvitation')->name('users.resend-invitation')->middleware('permission:invite_user');


    Route::get('/users/{id}/show', 'UserController@show')->name('users.show')->middleware('permission:view_user_and_users_list');
    Route::get('/users', 'UserController@index')->name('users.index')->middleware('permission:view_user_and_users_list');


    Route::get('/users/{id}', 'UserController@edit')->name('users.edit')->middleware('permission:user_edit_delete_update');
    Route::put('/users/{id}', 'UserController@update')->name('users.update')->middleware('permission:user_edit_delete_update');
    Route::delete('/users/{id}', 'UserController@destroy')->name('users.destroy')->middleware('permission:user_edit_delete_update');

    Route::get('/orders', 'OrderController@index')->name('orders.index');
    Route::get('/orders/{id}/edit', 'OrderController@edit')->name('orders.edit');
    Route::get('/orders/create', 'OrderController@create')->name('orders.create');
    Route::post('/orders', 'OrderController@store')->name('orders.store');
    Route::put('/orders/{id}', 'OrderController@update')->name('orders.update');


    Route::post('/order-peoples', 'OrderPersonController@store')->name('order-persons.store');

});



