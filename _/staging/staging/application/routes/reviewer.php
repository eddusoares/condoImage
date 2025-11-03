<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'login')->name('login');
        Route::get('logout', 'logout')->name('logout');
    });
});

Route::middleware('reviewer')->group(function () {
    Route::controller('ReviewerController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::post('password', 'passwordUpdate')->name('password.update');
    });

    // Review Management
    Route::controller('ReviewController')->prefix('review')->name('review.')->group(function () {
        Route::get('pending', 'pending')->name('pending');
        Route::get('detail/{id}', 'detail')->name('detail');
        Route::get('handle/detail/{id}', 'detailAfterHandle')->name('handle.detail');
        Route::post('changeHandleStatus', 'changeHandleStatus')->name('changeHandleStatus');
        Route::post('update/{id}', 'update')->name('update');

        Route::get('on-reviewing', 'onReviewing')->name('on.reviewing');
        Route::get('published', 'published')->name('published');
        Route::get('rejected', 'rejected')->name('rejected');
    });

    // Reviewer Management
    Route::controller('ReviewController')->name('reviewer.')->group(function () {
        Route::get('/all', 'allReviewer')->name('all');
        Route::get('/view/{id}', 'view')->name('view');
    });

    // Category Management
    Route::controller('ReviewController')->prefix('category')->name('category.')->group(function () {
        Route::get('/', 'allCategories')->name('all');
    });

    // Tag Management
    Route::controller('ReviewController')->prefix('tag')->name('tag.')->group(function () {
        Route::get('/', 'allTags')->name('all');
    });
});
