<?php

use Illuminate\Support\Facades\Auth;
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

Route::group(['middleware' => 'auth'], function (){
    Route::get('/projects', [\App\Http\Controllers\ProjectsController::class, 'index']);
    Route::get('/projects/create', [\App\Http\Controllers\ProjectsController::class, 'create']);
    Route::get('/projects/{project}', [\App\Http\Controllers\ProjectsController::class, 'show']);
    Route::get('/projects/{project}/edit', [\App\Http\Controllers\ProjectsController::class, 'edit']);
    Route::patch('/projects/{project}', [\App\Http\Controllers\ProjectsController::class, 'update']);
    Route::post('/projects', [\App\Http\Controllers\ProjectsController::class, 'store']);
    Route::delete('/projects/{project}', [\App\Http\Controllers\ProjectsController::class, 'destroy']);

    //Route::resource('projects', 'ProjectsController');
    Route::post('/projects/{project}/invitations', [\App\Http\Controllers\ProjectInvitationsController::class, 'store']);
    Route::post('/projects/{project}/invitations/delete', [\App\Http\Controllers\ProjectInvitationsController::class, 'delete']);


    Route::post('/projects/{project}/tasks', [\App\Http\Controllers\ProjectTasksController::class, 'store']);
    Route::delete('/projects/{project}/tasks/{task}/delete', [\App\Http\Controllers\ProjectTasksController::class, 'delete']);
    Route::patch('/projects/{project}/tasks/{task}', [\App\Http\Controllers\ProjectTasksController::class, 'update']);
    Route::patch('/projects/{project}/tasks/{task}/status', [\App\Http\Controllers\ProjectTasksController::class, 'updateStatus']);
    Route::patch('/projects/{project}/tasks/{task}/assignuser', [\App\Http\Controllers\ProjectTasksController::class, 'assignUser']);

    Route::get('/profiles/{user:username}/edit', [App\Http\Controllers\ProfilesController::class, 'edit'])->middleware('can:edit,user');

    Route::patch('/profiles/{user:username}', [App\Http\Controllers\ProfilesController::class, 'update']);
    Route::get('/projects/{project}/activities', [App\Http\Controllers\ProjectActivityController::class, 'index']);

    Route::get('/users', [App\Http\Controllers\UserController::class, 'getUserList']);

});


Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

