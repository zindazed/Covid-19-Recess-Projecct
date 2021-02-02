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
Route::get('/orgchart', function (){
    return view('orgchart');
});

Route::get('/hospital',function () {
    $message = 0;
    return view("hospital", [
        "message" => $message
    ]);

});
Route::post('/addhospital','App\Http\Controllers\HospitalController@addhospital');

Route::get('distribution','App\Http\Controllers\DistributionController@payments');
