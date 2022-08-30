<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Answer_listController;
use App\Http\Controllers\Question_listController;
use App\Http\Controllers\Grouped_answersController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\My_pageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\PeriodMiddleware;
use App\Http\Middleware\JudgeLikeMiddleware;
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
Route::get('/answer_list/{order?}/{period?}/{page?}', [Answer_listController::class, 'index'])->middleware(PeriodMiddleware::class);
Route::get('/question_list/{situation?}/{page?}', [Question_listController::class, 'index']);
Route::post('/question_list', [Question_listController::class, 'add']);
Route::get('/grouped_answer/{question_id}', [Grouped_answersController::class, 'index']);
Route::post('/grouped_answer/{question_id}', [Grouped_answersController::class, 'add']);
Route::get('/user/{id?}/{category?}/{period?}/{order?}/{page?}', [UserController::class, 'index']);
Route::get('/my_page/{id?}', [My_pageController::class, 'index']);
Route::get('/search', [SearchController::class, 'index']);
Route::post('/like', [LikeController::class, 'index']);
Route::post('/vote', [VoteController::class, 'index']);

Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
