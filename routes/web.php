<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecepieController;

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
    return view('welcome');
});
Route::resource('api/recipes', 'App\Http\Controllers\RecepieController');

Route::post('api/recipes/{id}/rating', 'App\Http\Controllers\RecepieController@rate_store');

Route::post('api/recipes/search', 'App\Http\Controllers\RecepieController@search');
