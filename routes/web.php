<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
	return Auth::check()
		? redirect('/tickets')
		: redirect('/login');
});

Route::get('/ping', fn () => 'pong.');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

	Route::middleware('role:user')->group(function () {
		Route::resource('tickets', TicketController::class)->only(['create', 'store']);
	});

	Route::resource('tickets', TicketController::class)->only(['index', 'show']);

	Route::middleware('role:tech,admin')->group(function () {
		Route::resource('tickets', TicketController::class)->only(['update']);
	});

	Route::middleware('role:admin')->group(function () {
		Route::resource('tickets', TicketController::class)->only(['destroy']);
	});
});
