<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;


Route::get('/', [App\Http\Controllers\UserController::class, 'showLoginPage'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout']);

Route::get('/register', [App\Http\Controllers\UserController::class, 'showRegisterPage'])->name('register');
Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);

Route::get('/forgot-password', [UserController::class, 'showForgotPasswordPage']);
Route::post('/reset-password-direct', [UserController::class, 'resetPasswordDirect']);

Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'showDashboard'])->middleware('auth');

Route::get('/chat', [ChatController::class, 'index'])->middleware('auth');
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->middleware('auth');
Route::post('/chat/{id}/update', [ChatController::class, 'updateMessage'])->middleware('auth');
Route::delete('/chat/{id}/delete', [ChatController::class, 'deleteChat'])->middleware('auth');
Route::post('/chat/add-user', [ChatController::class, 'addUser'])->middleware('auth');
Route::delete('/chat/remove-user/{id}', [ChatController::class, 'removeUser'])->middleware('auth');
