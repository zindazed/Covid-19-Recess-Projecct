<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/patients', 'App\Http\Controllers\PatientsController@display')->name("patients");
Route::get('/hierachy', 'App\Http\Controllers\HierachyController@display')->name("hierachy");
Route::get('/donations', 'App\Http\Controllers\DonorController@display')->name("donations");
Route::get('/{id}', 'App\Http\Controllers\DonorController@show')->name("donor");
Route::post('/donations', 'App\Http\Controllers\DonorController@add')->name("donor");

