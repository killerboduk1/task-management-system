<?php

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

Route::get('/home', [App\Http\Controllers\TaskController::class, 'index'])->name('home');

// Task
Route::get('/task/add', [App\Http\Controllers\TaskController::class, 'addTask'])->name('addTask');

Route::get('/task/view/{id}', [App\Http\Controllers\TaskController::class, 'viewTask'])->name('viewTask');

Route::get('/task/edit/{id}', [App\Http\Controllers\TaskController::class, 'editTask'])->name('editTask');
Route::post('/task/edit/{id}', [App\Http\Controllers\TaskController::class, 'editTaskPost'])->name('editTaskPost');

Route::post('/task/add', [App\Http\Controllers\TaskController::class, 'addTaskPost'])->name('addTaskPost');

Route::get('/task/delete', [App\Http\Controllers\TaskController::class, 'viewDeleteTaskPost'])->name('viewDeleteTaskPost');
Route::post('/task/delete', [App\Http\Controllers\TaskController::class, 'deleteTaskPost'])->name('deleteTaskPost');
Route::post('/task/delete/trashed', [App\Http\Controllers\TaskController::class, 'deleteDeletedTask'])->name('deleteDeletedTask');
Route::post('/task/restore/trashed', [App\Http\Controllers\TaskController::class, 'restoreDeletedTask'])->name('restoreDeletedTask');

// Sub Task
Route::get('/task/add/subtask/{id}', [App\Http\Controllers\SubTaskController::class, 'addSubTask'])->name('addSubTask');
Route::post('/task/add/subtask/{id}', [App\Http\Controllers\SubTaskController::class, 'addSubTaskPost'])->name('addSubTaskPost');

Route::get('/task/view/subtask/{subtaskId}', [App\Http\Controllers\SubTaskController::class, 'viewSubTask'])->name('viewSubTask');

Route::get('/task/edit/subtask/{subtaskId}', [App\Http\Controllers\SubTaskController::class, 'editSubTask'])->name('editSubTask');
Route::post('/task/edit/subtask/{subtaskId}', [App\Http\Controllers\SubTaskController::class, 'editSubTaskPost'])->name('editSubTaskPost');

Route::post('/task/delete/subtask', [App\Http\Controllers\SubTaskController::class, 'deleteSubTaskPost'])->name('deleteSubTaskPost');

//Search Task
Route::post('/task/search', [App\Http\Controllers\TaskController::class, 'searchTask'])->name('searchTask');
