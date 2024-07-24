<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});







///// Blog Controller Routes /////
Route::group(
    [
        'middleware' => ['cors', 'token'],
        'prefix' => 'blog',
        'namespace' => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::get('/', 'BlogController@index');
        Route::post('/create', 'BlogController@create');
        Route::post('/view', 'BlogController@view');
        Route::post('/update', 'BlogController@update');
        Route::post('/delete', 'BlogController@delete');
    }
);





///// Post Controller Routes /////
Route::group(
    [
        'middleware' => ['cors', 'token'],
        'prefix' => 'post',
        'namespace' => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::get('/', 'PostController@index');
        Route::post('/create', 'PostController@create');
        Route::post('/view', 'PostController@view');
        Route::post('/update', 'PostController@update');
        Route::post('/delete', 'PostController@delete');
    }
);





///// Post Comment Controller Routes /////
Route::group(
    [
        'middleware' => ['cors', 'token'],
        'prefix' => 'post-comment',
        'namespace' => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::post('/create', 'PostCommentController@create');
    }
);





///// Post Like Controller Routes /////
Route::group(
    [
        'middleware' => ['cors', 'token'],
        'prefix' => 'post-like',
        'namespace' => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::post('/create', 'PostLikeController@create');
    }
);





