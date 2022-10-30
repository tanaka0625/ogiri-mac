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
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ChoiceAvatorController;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\BattleVoteController;
use App\Http\Controllers\CountLoginedUserController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\NoticeController;
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
Route::get('/', [TopController::class, 'index']);


Route::group(['middleware' => ['lastLogin']], function () {

    Route::get('/rule', [RuleController::class, 'index']);
    Route::get('/answer_list', [Answer_listController::class, 'index']);
    Route::get('/question_list', [Question_listController::class, 'index']);
    Route::get('/grouped_answer/{question_id}', [Grouped_answersController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'index']);
    Route::get('/my_page', [My_pageController::class, 'index'])->middleware('checkLogin');
    Route::get('/notice', [NoticeController::class, 'index'])->middleware('checkLogin');
    Route::get('/search', [SearchController::class, 'index']);
    Route::get('/ranking', [RankingController::class, 'index']);
    Route::post('/like', [LikeController::class, 'index']);
    Route::post('/vote', [VoteController::class, 'index']);
    Route::post('/delete', [DeleteController::class, 'index']);
    Route::get('/setting', [SettingController::class, 'index'])->middleware('checkLogin');
    Route::post('/avator', [ChoiceAvatorController::class, 'index']);
    Route::get('/battle', [BattleController::class, 'index']);
    Route::post('/battle/vote', [BattleVoteController::class, 'index']);
    Route::post('/battle/addAnswer', [BattleController::class, 'addAnswer']);
    Route::post('/battle/addQuestion', [BattleController::class, 'addQuestion']);
    
});

Route::post('/question_list', [Question_listController::class, 'add']);
Route::post('/grouped_answer/{question_id}', [Grouped_answersController::class, 'add']);
Route::post('/setting/changeComment', [SettingController::class, 'changeComment'])->middleware('checkLogin');
Route::post('/battle', [BattleController::class, 'makeHtml']);
Route::post('/countLoginedUser', [CountLoginedUserController::class, 'index']);
Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
