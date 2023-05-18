<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MissionsController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\PersonsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SpecialitiesController;
use App\Http\Controllers\CategoriesTasksController;

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

Route::get('missions/settings', [MissionsController::class, 'missionsSettings'])->where('id', '[0-9]+')->name('missions-settings');
Route::get('missions/{id}', [MissionsController::class, 'showCategoryMission'])->where('id', '[0-9]+')->name('show-category-mission');
Route::get('mission/{id}', [MissionsController::class, 'showMission'])->where('id', '[0-9]+')->name('show-mission');
Route::get('councils', [MissionsController::class, 'showCouncils'])->name('councils');
Route::get('injuries', [MissionsController::class, 'showInjuries'])->name('injuries');
Route::get('squads', [MissionsController::class, 'showSquads'])->name('squads');
Route::get('cards', [MissionsController::class, 'showMedicalCards'])->name('cards');
Route::get('end-services', [MissionsController::class, 'showEndServices'])->name('end-services');
Route::get('investigations', [MissionsController::class, 'showInvestigations'])->name('investigations');
Route::get('appendices', [MissionsController::class, 'showAppendices'])->name('appendices');
Route::get('attachments', [MissionsController::class, 'showAttachments'])->name('attachments');

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

//Categories
Route::get('category/{id}', [CategoriesController::class, 'showCategory'])->where('id', '[0-9]+')->name('show-category');
Route::post('add/category', [CategoriesController::class, 'addCategory'])->name('add-category');
Route::post('edit/category', [CategoriesController::class, 'editCategory'])->name('edit-category');
Route::post('delete/category', [CategoriesController::class, 'deleteCategory'])->name('delete-category');

//specialities
Route::post('add/speciality', [SpecialitiesController::class, 'addSpeciality'])->name('add-speciality');
Route::post('edit/speciality', [SpecialitiesController::class, 'editSpeciality'])->name('edit-speciality');
Route::post('delete/speciality', [SpecialitiesController::class, 'deleteSpeciality'])->name('delete-speciality');

//Categories tasks
Route::post('add/category-task', [CategoriesTasksController::class, 'addTask'])->name('add-category-task');
Route::post('edit/category-task', [CategoriesTasksController::class, 'editTask'])->name('edit-category-task');
Route::post('delete/category-task', [CategoriesTasksController::class, 'deleteTask'])->name('delete-category-task');