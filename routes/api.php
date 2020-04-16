<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Bin\Auth\AuthFacade as Auth;
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
    $check = Auth::checkCredentials([
        'username' => 'jsmith',
        'password' => 'pass'
    ]);

    return response()->json(Auth::createToken());
});

Route::get('/test/{password}', function ($password) {
    return bcrypt($password);
});
