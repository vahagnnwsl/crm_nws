<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth']], function () {

    Route::get('/', 'IndexController@home')->name('admin.index');
    Route::get('/profile', 'IndexController@profile')->name('account.profile');
    Route::put('/profile', 'IndexController@updateProfile')->name('account.profile.update');

    Route::get('/permissions', 'PermissionController@index')->name('permissions.index')->middleware('permission:view_permissions_list');

    Route::get('/roles', 'RoleController@index')->name('roles.index')->middleware('permission:view_roles_list');
    Route::post('/roles', 'RoleController@store')->name('roles.store')->middleware('permission:role_create_update_delete');

    Route::get('/roles/{id}', 'RoleController@get');

    Route::post('/roles/{id}', 'RoleController@syncPermissions')->middleware('permission:give_permission_to_role');

    Route::get('/users/{id}/login', 'UserController@login')->name('users.login')->middleware('permission:login_via_anther_user');

    Route::get('/users', 'UserController@index')->name('users.index')->middleware('permission:view_users_list');

    Route::post('/users', 'UserController@store')->name('users.store')->middleware('permission:invite_user');

    Route::get('/users/{id}/resend-invitation', 'UserController@resendInvitation')->name('users.resend-invitation')->middleware('permission:invite_user');


    Route::get('/users/{id}/show', 'UserController@show')->name('users.show')->middleware('permission:view_user');

    Route::get('/users/{id}', 'UserController@edit')->name('users.edit')->middleware('permission:edit_user');
    Route::put('/users/{id}', 'UserController@update')->name('users.update')->middleware('permission:edit_user');

    Route::delete('/users/{id}', 'UserController@destroy')->name('users.destroy')->middleware('permission:delete_user');


});




