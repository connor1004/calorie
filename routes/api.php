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

Route::post('/register', 'AuthController@register')->name('register');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', 'AuthController@getUser')->name('user');
    Route::post('/logout', 'AuthController@logout')->name('logout');

    Route::get('/all-users', 'AuthController@getAllUsers')->name('all-users');

    Route::get('/food-entries/all', 'FoodEntryController@viewAll')
        ->name('all-food-entries');

    Route::get('/user-stats', 'FoodEntryController@getUserStats')->name('user-stats');

    Route::get('/report', 'FoodEntryController@getReport')->name('report');

    Route::apiResources([
        'food-entries' => FoodEntryController::class,
    ]);
});
