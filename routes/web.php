<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RoleController;

Route::get('/', [App\Http\Controllers\UserController::class, 'showLoginPage'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'login']);
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout']);
Route::get('/register', [App\Http\Controllers\UserController::class, 'showRegisterPage'])->name('register');
Route::post('/register', [App\Http\Controllers\UserController::class, 'register']);
Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'showDashboard'])->middleware('auth');
Route::get('/forgot-password', [UserController::class, 'showForgotPasswordPage']);
Route::post('/reset-password-direct', [UserController::class, 'resetPasswordDirect']);

Route::get('/chat', [ChatController::class, 'index'])->middleware('auth');
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->middleware('auth');
<<<<<<< Updated upstream
Route::post('/chat/{id}/update', [ChatController::class, 'updateMessage'])->middleware('auth');
Route::delete('/chat/{id}/delete', [ChatController::class, 'deleteChat'])->middleware('auth');
Route::post('/chat/add-user', [ChatController::class, 'addUser'])->middleware('auth');
Route::delete('/chat/remove-user/{id}', [ChatController::class, 'removeUser'])->middleware('auth');
=======
Route::delete('/chat/{id}/delete', [ChatController::class, 'deleteChat'])->middleware('auth');

Route::middleware('auth')->group(function () {
    // List Roles (GET)
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    
    // Create Role Form (GET)
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    
    // Store Role (POST)
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    
        // Show the form for assigning users to a role
    Route::get('/roles/assign', [RoleController::class, 'assignForm'])->name('roles.assignForm');
        
        // Handle the form submission for assigning users to a role
    Route::post('/roles/assign', [RoleController::class, 'assignUser'])->name('roles.assignUser');
});


Route::middleware('auth')->group(function () {
    // Show the form for assigning users to a role
    Route::get('/roles/assign/{roleId}', [RoleController::class, 'assignUserForm'])->name('roles.assignUserForm');
    
    // Handle the form submission for assigning users to a role
    Route::post('/roles/assign/{roleId}', [RoleController::class, 'assignUser'])->name('roles.assignUser');
    
    // Remove a user from a role
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

Route::middleware('auth')->group(function () {
    // List all roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');

    // Show the form for creating a new role
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');

    // Store a new role
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

    // Show the form to assign users to a role
    Route::get('/roles/assign/{roleId}', [RoleController::class, 'assignForm'])->name('roles.assignUserForm');
    
    // Handle the form submission for assigning users to a role
    Route::post('/roles/assign/{roleId}', [RoleController::class, 'assignUser'])->name('roles.assignUser');
    
    // Remove a user from a role
    Route::delete('/roles/{roleId}/remove-user/{userId}', [RoleController::class, 'removeUser'])->name('roles.removeUser');
    
    // Delete a role
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});
>>>>>>> Stashed changes
