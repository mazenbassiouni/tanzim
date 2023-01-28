<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MissionsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\PersonsController;

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
Route::get('mission/{id}', [MissionsController::class, 'showMission'])->where('id', '[0-9]+')->name('show-mission');
Route::get('councils', [MissionsController::class, 'showCouncils'])->name('councils');
Route::get('injuries', [MissionsController::class, 'showInjuries'])->name('injuries');
Route::get('squads', [MissionsController::class, 'showSquads'])->name('squads');
Route::get('cards', [MissionsController::class, 'showMedicalCards'])->name('cards');
Route::get('end-services', [MissionsController::class, 'showEndServices'])->name('end-services');
Route::get('investigations', [MissionsController::class, 'showInvestigations'])->name('investigations');
Route::get('appendices', [MissionsController::class, 'showAppendices'])->name('appendices');

//Tasks
Route::post('add/task', [TasksController::class, 'addTask'])->name('add-new-task');
Route::post('edit/task', [TasksController::class, 'editTask'])->name('edit-task');
Route::post('delete/task', [TasksController::class, 'deleteTask'])->name('delete-task');
Route::post('done/task', [TasksController::class, 'setTaskAsDone'])->name('task-done');

//Person
Route::get('force', [PersonsController::class, 'index'])->name('force');
Route::post('add/person', [PersonsController::class, 'addPerson'])->name('add-new-person');
Route::get('search/person', [PersonsController::class, 'search'])->name('person-search');
Route::get('person/{id}' , [PersonsController::class, 'showPerson'])->where('id', '[0-9]+')->name('show-person');
Route::post('edit/person', [PersonsController::class, 'editPerson'])->name('edit-person');
