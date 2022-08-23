<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MissionsController;
use App\Http\Controllers\TasksController;

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

Route::get('/', [MissionsController::class, 'index'])->name('missions');

// Missions
Route::post('add/mission', [MissionsController::class, 'addMission'])->name('add-new-mission');
Route::post('edit/mission', [MissionsController::class, 'editMission'])->name('edit-mission');
Route::post('delete/mission', [MissionsController::class, 'deleteMission'])->name('delete-mission');
Route::get('mission/{id}', [MissionsController::class, 'showMission'])->where('id', '[0-9]+');

//Tasks
Route::post('add/task', [TasksController::class, 'addTask'])->name('add-new-task');
Route::post('edit/task', [TasksController::class, 'editTask'])->name('edit-task');
Route::post('delete/task', [TasksController::class, 'deleteTask'])->name('delete-task');
Route::post('done/task', [TasksController::class, 'setTaskAsDone'])->name('task-done');