<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes(['register' => false]);
Route::get('/linkedit',function (){
   dd(request()->get('code'));
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user-invitation/{token}/{email}', [App\Http\Controllers\InvitationController::class, 'acceptUserInvitationView'])->name('user-invitation')->middleware('guest');
Route::post('/user-invitation/{token}/{email}', [App\Http\Controllers\InvitationController::class, 'acceptUserInvitation'])->name('user-invitation')->middleware('guest');


