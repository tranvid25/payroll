<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CommentMovieController;
use App\Http\Controllers\Api\CommentNewsController;
use App\Http\Controllers\Api\FeedBackController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\newsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\EmployeeController;
use App\Models\Employee;
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


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('passwordRetrieval', [AuthController::class, 'passwordRetrieval']);

    Route::group([
        'middleware' => 'auth:api','check.revoked.token'
    ], function () {
        Route::get('laydanhsachuser', [UserController::class, 'index']);
        Route::get('laydanhsachuser/{id}', [UserController::class, 'show']);
        Route::post('laydanhsachuser', [UserController::class, 'store']);
        Route::post('laydanhsachuser/{id}', [UserController::class, 'update']);
        Route::delete('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'user']);


        //Banner
        Route::get('laydanhsachbanner', [BannerController::class, 'index']);
        Route::post('laydanhsachbanner', [BannerController::class, 'store']);
        Route::get('laydanhsachbanner/{id}', [BannerController::class, 'show']);
        Route::post('laydanhsachbanner/{id}/update', [BannerController::class, 'update']);
        Route::delete('laydanhsachbanner/{id}/delete', [BannerController::class, 'destroy']);
        //Review New
        Route::get('laydanhsachbinhluan', [CommentNewsController::class, 'index']);
        Route::post('laydanhsachbinhluan', [CommentNewsController::class, 'store']);
        Route::get('laydanhsachbinhluan/{id}', [CommentNewsController::class, 'show']);
        Route::get('laydanhsachbinhluan/{id}/edit', [CommentNewsController::class, 'edit']);
        Route::post('laydanhsachbinhluan/{id}/update', [CommentNewsController::class, 'update']);
        Route::delete('laydanhsachbinhluan/{id}/delete', [CommentNewsController::class, 'destroy']);
        //Review movie
        Route::get('laydanhsachbinhluanphim', [CommentMovieController::class, 'index']);
        Route::post('laydanhsachbinhluanphim', [CommentMovieController::class, 'store']);
        Route::get('laydanhsachbinhluanphim/{id}', [CommentMovieController::class, 'show']);
        Route::get('laydanhsachbinhluanphim/{id}/edit', [CommentMovieController::class, 'edit']);
        Route::post('laydanhsachbinhluanphim/{id}/update', [CommentMovieController::class, 'update']);
        Route::delete('laydanhsachbinhluanphim/{id}/delete', [CommentMovieController::class, 'destroy']);
        //FeedBack
        Route::get('laydanhsachfeedback', [FeedBackController::class, 'index']);
        Route::post('laydanhsachfeedback', [FeedBackController::class, 'store']);
        Route::get('laydanhsachfeedback/{id}', [FeedBackController::class, 'show']);
        Route::put('laydanhsachfeedback/{id}/update', [FeedBackController::class, 'update']);
        Route::delete('laydanhsachfeedback/{id}/delete', [FeedBackController::class, 'destroy']);
        //TIN TỨC
        Route::get('laydanhsachtintuc', [newsController::class, 'index']);
        Route::post('laydanhsachtintuc', [newsController::class, 'store']);
        Route::get('laydanhsachtintuc/{id}', [newsController::class, 'show']);
        Route::post('laydanhsachtintuc/{id}/update', [newsController::class, 'update']);
        Route::delete('laydanhsachtintuc/{id}/delete', [newsController::class, 'destroy']);
        //Phim
        Route::get('LayDanhSachPhim', [MovieController::class, 'index']);
        Route::post('LayDanhSachPhim', [MovieController::class, 'store']);
        Route::get('LayDanhSachPhim/{id}', [MovieController::class, 'show']);
        Route::get('LayDanhSachPhim/rap/{id}', [MovieController::class, 'showrap']);
        Route::post('LayDanhSachPhim/{id}/update', [MovieController::class, 'update']);
        Route::delete('LayDanhSachPhim/{id}/delete', [MovieController::class, 'destroy']);

    });
});
