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

    Route::get('/asses-req-otva-mss', [MainController::class, 'asses_req_otva_mss'])->name('asses.req.otva.mss');
    Route::get('/asses-req-otva-msbm', [MainController::class, 'asses_req_otva_msbm'])->name('asses.req.otva.msbm');
    Route::get('/asses-req-otva-yibm', [MainController::class, 'asses_req_otva_yibm'])->name('asses.req.otva.yibm');
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
        Route::post('/setting',         [UserController::class, 'setting_post'])->name('setting.post');
        Route::get('/select-test-type/{subjectId}',[UserController::class, 'select_test_type'])->name('select.test.type')->where('subjectId', '[0-9]+');
        Route::post('/select-test-type/{subjectId}',[UserController::class, 'select_test_type'])->name('select.test.type')->where('subjectId', '[0-9]+');
        Route::get('/tests-by-category/{subjectId}', [UserController::class, 'getTestsByCategory']);
        Route::get('/test-questions/{chapterId}', [UserController::class, 'test_questions'])->name('test.questions')->where('chapterId', '[0-9]+');
        Route::post('/final-test-questions/{finalTestId}', [UserController::class, 'final_test_questions'])->name('final.test.questions')->where('finalTestId', '[0-9]+');
        Route::get('/final-test-questions/{finalTestId}', [UserController::class, 'final_test_questions'])->name('final.test.questions')->where('finalTestId', '[0-9]+');
        Route::post('/user-save-remaining-time', [UserController::class, 'save_remaining_time'])->name('save.remaining.time');
        Route::post('/test-submit', [UserController::class, 'submitTest'])->name('submit.test');
        Route::get('/test-submit', [UserController::class, 'submitTest'])->name('submit.test');
        Route::post('/final-test-submit', [UserController::class, 'submitFinalTest'])->name('submit.final.test');
        Route::get('/final-test-submit', [UserController::class, 'submitFinalTest'])->name('submit.final.test');
        Route::get('/test-results',    [UserController::class, 'test_results'])->name('test.results');
        Route::get('/final-test-results',    [UserController::class, 'final_test_results'])->name('final.test.results');
        Route::get('/logout',          [UserController::class, 'logout'])->name('logout');
    });
