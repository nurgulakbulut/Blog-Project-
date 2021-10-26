<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Cmfcmf\OpenWeatherMap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
    return view('welcome');
});

Auth::routes();
Route::resource('categories', CategoryController::class);
Route::get('categories/{category}/follow', [CategoryController::class, 'follow'])->name('categories.follow');
Route::get('categories/{category}/unfollow', [CategoryController::class, 'unfollow'])->name('categories.unfollow');

Route::resource('posts', PostController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('owm', function (OpenWeatherMap $owm) {

    $weather = $owm->getWeather('Istanbul', 'metric', 'tr');
    dd($weather);

});
