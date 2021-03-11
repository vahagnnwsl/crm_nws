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

    Route::get('/orders', 'OrderController@index')->name('orders.index')->middleware('permission:view_order_and_orders_list');
    Route::get('/orders/{id}/show', 'OrderController@show')->name('orders.show')->middleware('permission:view_order_and_orders_list');
    Route::get('/orders/{id}/edit', 'OrderController@edit')->name('orders.edit')->middleware('permission:order_create_update_delete');
    Route::get('/orders/create', 'OrderController@create')->name('orders.create')->middleware('permission:order_create_update_delete');
    Route::post('/orders', 'OrderController@store')->name('orders.store')->middleware('permission:order_create_update_delete');
    Route::put('/orders/{id}', 'OrderController@update')->name('orders.update')->middleware('permission:order_create_update_delete');
    Route::put('/orders/{id}/status', 'OrderController@updateStatus')->name('orders.updateStatus')->middleware('permission:order_update_status');
    Route::get('/orders/{id}/status', 'OrderController@getStatusComments')->name('orders.getStatusComments')->middleware('permission:order_update_status');
    Route::delete('/orders/{id}', 'OrderController@destroy')->name('orders.destroy')->middleware('permission:order_create_update_delete');


    Route::post('/order-peoples', 'OrderPersonController@store')->name('order-persons.store')->middleware('permission:order_person_create_update_delete');
    Route::get('/order-peoples/{id}', 'OrderPersonController@get')->middleware('permission:order_person_create_update_delete');
    Route::post('/order-peoples/{id}', 'OrderPersonController@update')->middleware('permission:order_person_create_update_delete');


    Route::get('/agents', 'AgentController@index')->name('agents.index')->middleware('permission:view_agent_and_agents_list');
    Route::get('/agents/create', 'AgentController@create')->name('agents.create')->middleware('permission:agent_create_update_delete');
    Route::get('/agents/{id}/edit', 'AgentController@edit')->name('agents.edit')->middleware('permission:agent_create_update_delete');
    Route::post('/agents', 'AgentController@store')->name('agents.store')->middleware('permission:agent_create_update_delete');
    Route::put('/agents/{id}', 'AgentController@update')->name('agents.update')->middleware('permission:agent_create_update_delete');
    Route::delete('/agents/{id}', 'AgentController@destroy')->name('agents.destroy')->middleware('permission:agent_create_update_delete');


    Route::get('/developers', 'DeveloperController@index')->name('developers.index')->middleware('permission:view_developer_and_developers_list');
    Route::get('/developers/{id}/show', 'DeveloperController@show')->name('developers.show')->middleware('permission:view_developer_and_developers_list');
    Route::get('/developers/create', 'DeveloperController@create')->name('developers.create')->middleware('permission:developer_create_update_delete');
    Route::post('/developers', 'DeveloperController@store')->name('developers.store')->middleware('permission:developer_create_update_delete');
    Route::get('/developers/{id}/edit', 'DeveloperController@edit')->name('developers.edit')->middleware('permission:developer_create_update_delete');
    Route::put('/developers/{id}', 'DeveloperController@update')->name('developers.update')->middleware('permission:developer_create_update_delete');
    Route::delete('/developers/{id}', 'DeveloperController@destroy')->name('developers.destroy')->middleware('permission:developer_create_update_delete');



    Route::get('/statistic/orders', 'StatisticController@indexOrders')->name('statistic.indexOrders');
    Route::get('/statistic/users', 'StatisticController@indexUsers')->name('statistic.indexUsers');

    Route::get('/statistic/users-orders', 'StatisticController@getUsersOrders');
    Route::get('/statistic/users-ordersGroupByMonth', 'StatisticController@getUsersOrdersGroupByMonth');
    Route::get('/statistic/users-ordersGroupByStatus', 'StatisticController@getUsersOrdersGroupByStatus');


});



