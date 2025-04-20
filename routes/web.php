<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [HomeController::class, 'home'])->middleware('guest')->name('home');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chat', [HomeController::class, 'chatIndex'])->name('chat.index');
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('sendMessage');
    Route::get('/fetch-chat-history/{userId}', [ChatController::class, 'fetchChatHistory']);
    Route::post('/calls/initiate', [ChatController::class, 'initiateCall'])->name('calls.initiate');
    Route::post('/calls/end', [ChatController::class, 'endCall'])->name('calls.end');
    Route::post('/calls/tag', [ChatController::class, 'tagCall'])->name('calls.tagCall');
    Route::get('calender', [HomeController::class, 'calender'])->name('calender');
    Route::get('setting', [HomeController::class, 'setting'])->name('setting');
    Route::resource('contacts', ContactController::class);
    Route::post('/calls/{id}/update-status', [ContactController::class, 'updateStatus'])->name('calls.status');
    Route::put('/profile/password', [HomeController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/events', [EventController::class, 'fetchEvents']);
    Route::post('/events', [EventController::class, 'store']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);    
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);

});
Route::post('/checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::get('/create-account', [HomeController::class, 'createAccount'])->name('create.account');
require __DIR__.'/auth.php';
