<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
	if (!Auth::check()) {
		return redirect('/login');
	}
	if (Auth::user()->isAdmin()) {
		return redirect('/admin/panel');
	}
	return redirect('/tickets');
});

Route::get('/ping', fn () => 'pong.');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

	Route::resource('tickets', TicketController::class);

	Route::put('/tickets/{ticket}/assign', [TicketController::class, 'assign'])
		->name('tickets.assign');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/panel', [AdminController::class, 'panel'])->name('panel');
        Route::resource('users', UserController::class);
    });
});
