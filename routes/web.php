<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/tickets', [AdminController::class, 'tickets'])->name('tickets');
    Route::get('/ticket/{id}', [AdminController::class, 'ticketDetail'])->name('ticket.detail');
    Route::post('/ticket/{id}/respond', [AdminController::class, 'addResponse'])->name('ticket.add-response');
    Route::post('/ticket/{id}/status', [AdminController::class, 'updateTicketStatus'])->name('ticket.update-status');
    
    // Route untuk edit dan delete tiket
    Route::get('/ticket/{id}/edit', [AdminController::class, 'editTicket'])->name('ticket.edit');
    Route::put('/ticket/{id}', [AdminController::class, 'updateTicket'])->name('ticket.update');
    Route::delete('/ticket/{id}', [AdminController::class, 'deleteTicket'])->name('ticket.delete');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    
    // Category Management
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/category', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/category/{id}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::delete('/category/{id}', [AdminController::class, 'deleteCategory'])->name('categories.delete');
    
    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::put('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar');
});

// User Routes
Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/tickets', [UserController::class, 'myTickets'])->name('my-tickets');
    Route::get('/ticket/create', [UserController::class, 'createTicket'])->name('create-ticket');
    Route::post('/ticket', [UserController::class, 'storeTicket'])->name('store-ticket');
    Route::get('/ticket/{id}', [UserController::class, 'ticketDetail'])->name('ticket.detail');
    Route::post('/ticket/{id}/respond', [UserController::class, 'addResponse'])->name('ticket.add-response');
    
    // Edit dan Delete tiket untuk user
    Route::get('/ticket/{id}/edit', [UserController::class, 'editTicket'])->name('ticket.edit');
    Route::put('/ticket/{id}', [UserController::class, 'updateTicket'])->name('ticket.update');
    Route::delete('/ticket/{id}', [UserController::class, 'deleteTicket'])->name('ticket.delete');
    Route::post('/ticket/{id}/close', [UserController::class, 'closeTicket'])->name('ticket.close');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
    Route::put('/profile/avatar', [ProfileController::class, 'uploadAvatar'])->name('profile.avatar');
});