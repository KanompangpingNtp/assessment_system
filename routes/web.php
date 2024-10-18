<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\ResponsesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ReportresponsesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/questions/index', [QuestionsController::class, 'questionsIndex'])->name('questionsIndex');
Route::post('/questions/create', [QuestionsController::class, 'createQuestion'])->name('questions.create');
Route::put('/questions/{id}/edit', [QuestionsController::class, 'updateQuestion'])->name('questions.update');

Route::post('/responses/store', [ResponsesController::class, 'store'])->name('responses.store');

Route::get('/', [UsersController::class, 'usersIndex'])->name('usersIndex');

Route::get('/report/responses', [ReportresponsesController::class, 'index'])->name('report.responses.index');
Route::get('/report/responses/result', [ReportresponsesController::class, 'report'])->name('report.responses');
Route::post('/export-responses', [ReportResponsesController::class, 'exportResponses'])->name('exportResponses');


Route::get('/agencies', [AgencyController::class, 'indexAgency'])->name('indexAgency');
Route::post('/agencies/create', [AgencyController::class, 'store'])->name('agencies.store');
