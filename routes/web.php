<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;

Route::get('/', [MainController::class, 'index'])->name('index');
Route::middleware(['web'])->group(function () {
    Route::get('/login', [MainController::class, 'login'])->name('login');
    Route::post('/login', [MainController::class, 'loginPost'])->name('login.post');

    Route::get('/registration', [MainController::class, 'registration'])->name('registration.form');
    Route::post('/registration', [MainController::class, 'registration_student'])->name('registration.student');

    Route::get('/reset-send-sms', [MainController::class, 'reset_send_sms'])->name('reset.send.sms');
    Route::get('/reset-password', [MainController::class, 'reset_password'])->name('reset.password');

    Route::get('/payment', [MainController::class, 'payment'])->name('payment');

    Route::get('/news-view/{id}', [MainController::class, 'news_view'])->name('news.view')->where('id', '[0-9]+');
});

// Foydalanuvchi (faqat login bo‘lganlar uchun)
Route::middleware(['web', 'auth.student'])
    ->prefix('user')->name('user.')
    ->group(function () {
        Route::get('/main',            [UserController::class, 'main'])->name('main');
        Route::get('/profile',         [UserController::class, 'profile'])->name('profile');
        Route::get('/data',            [UserController::class, 'data'])->name('data');
        Route::get('/results',         [UserController::class, 'results'])->name('results');
        Route::get('/ranking',         [UserController::class, 'ranking'])->name('ranking');
        Route::get('/invoice',         [UserController::class, 'invoice'])->name('invoice');
        Route::get('/setting',         [UserController::class, 'setting'])->name('setting');
        Route::get('/select-test-type',[UserController::class, 'select_test_type'])->name('select.test.type');
        Route::post('/test-questions/{chapterId}', [UserController::class, 'test_questions'])->name('test.questions')->where('chapterId', '[0-9]+');
        Route::post('/test-submit', [UserController::class, 'test_submit'])->name('test.submit');
        Route::get('/test-results',    [UserController::class, 'test_results'])->name('test.results');
        Route::get('/logout',          [UserController::class, 'logout'])->name('logout');
    });
