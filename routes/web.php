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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/patients', 'App\Http\Controllers\PatientsController@display')->name("patients");

Route::get('/hierachy', 'App\Http\Controllers\HierachyController@display')->name("hierachy");
Route::get('/donations', 'App\Http\Controllers\DonorController@display')->name("donations");

Route::post('/donations', 'App\Http\Controllers\DonorController@add')->name("donor");

Route::get('/hospital',function () {
    $message = 0;
    return view("hospital", [
        "message" => $message
    ]);

});
Route::post('/addhospital','App\Http\Controllers\HospitalController@addhospital');

Route::get('{id}', 'App\Http\Controllers\DonorController@show');

//Route::get('/donations','App\Http\Controllers\DonorController@payments');

