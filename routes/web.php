<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\TaskController;

Route::get('/', [IndexController::class, 'show_login_or_tasks'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'all_task'])->name('show_home');
    Route::post('/filtered_task', [TaskController::class, 'show_filter_task'
    ])->name('show_filter_task');

    Route::post('/filtered_task_resp',[TaskController::class,'show_filter_task_responsible'
    ])->name('show_task_resp');

    Route::post('/change_task',[TaskController::class,'change_task'])->name('change_task');
    Route::post('/add_task/submit', [TaskController::class, 'add_task_submit'])->name('add_task_submit');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show_login_form'])->name('login');
    Route::post('/login_submit', [AuthController::class, 'login'])->name('login_submit');
    Route::get('/register', [AuthController::class, 'show_register_form'])->name('register');
    Route::post('/register_submit', [AuthController::class, 'register'])->name('register_submit');
});

