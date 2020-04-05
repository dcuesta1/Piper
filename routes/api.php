<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/authenticate', 'Api\V1\Auth\LoginController');
Route::post('/signout', 'Api\V1\Auth\LogoutController');

Route::get('/test', function () {
   return 'test works';
});

Route::get('/test/{password}', function ($password) {
    return bcrypt($password);
});
