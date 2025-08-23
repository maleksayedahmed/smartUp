<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;

Route::prefix('auth')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/login',    [AuthController::class, 'login']);

    Route::post('/logout',   [AuthController::class, 'logout']);
});


Route::middleware('auth:api')->group(function () {

    Route::get('/my_profile', [AuthController::class, 'my_profile']);

});

Route::get('/get_banners', [HomeController::class, 'get_banners']);
Route::get('/get_cards', [HomeController::class, 'get_cards']);
Route::get('/get_testimonials', [HomeController::class, 'get_testimonials']);
Route::get('/get_systems', [HomeController::class, 'get_systems']);
Route::get('/get_packages', [HomeController::class, 'get_packages']);
Route::get('/get_partners', [HomeController::class, 'get_partners']);
Route::post('/get_system_data', [HomeController::class, 'get_system_data']);
Route::get('/get_images', [HomeController::class, 'get_primary_images']);
Route::post('/send_info', [HomeController::class, 'send_info']);
Route::get('/get_supports', [HomeController::class, 'get_supports']);
Route::get('/get_branches', [HomeController::class, 'get_branches']);
Route::get('/get_main_systems', [HomeController::class, 'get_main_systems']);
Route::get('/get_contact_infos', [HomeController::class, 'get_contact_infos']);
