<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\TaskController;

Route::get('/', [IndexController::class, 'showLoginOrTasks'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'allTask'])->name('show_home');
    Route::post('/filtered_task', [TaskController::class, 'showFilterTask'
    ])->name('showFilterTask');

    Route::post('/filtered_task_resp', [TaskController::class, 'showFilterTaskResponsible'
    ])->name('show_task_resp');

    Route::post('/change_task', [TaskController::class, 'changeTask'])->name('changeTask');
    Route::post('/add_task/submit', [TaskController::class, 'addTaskSubmit'])->name('addTaskSubmit');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login_submit', [AuthController::class, 'login'])->name('login_submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register_submit', [AuthController::class, 'register'])->name('register_submit');
});

