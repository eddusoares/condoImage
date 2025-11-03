<?php

use Illuminate\Support\Facades\Route;


Route::namespace('User\Auth')->name('user.')->group(function () {

    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('registration.status');
        Route::post('check-mail', 'checkUser')->name('checkUser');
    });

    Route::controller('ForgotPasswordController')->group(function () {
        Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'sendResetCodeEmail')->name('password.email');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });
    Route::controller('ResetPasswordController')->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });
});

Route::middleware('auth')->name('user.')->group(function () {
    //authorization
    Route::namespace('User')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend/verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify/email', 'emailVerification')->name('verify.email');
        Route::post('verify/mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify/g2fa', 'g2faVerification')->name('go2fa.verify');
    });

    Route::middleware(['check.status'])->group(function () {

        Route::get('user/data', 'User\UserController@userData')->name('data');
        Route::post('user/data/submit', 'User\UserController@userDataSubmit')->name('data.submit');

        Route::middleware('registration.complete')->namespace('User')->group(function () {

            Route::controller('UserController')->group(function () {
                Route::get('dashboard', 'home')->name('home');
                Route::get('orders', 'myOrder')->name('order');
                Route::get('image-download/{id}', 'download')->name('images.download');
                Route::get('wishlist', 'myWishlist')->name('wishlist');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');

                Route::get('attachment-download/{fil_hash}', 'attachmentDownload')->name('attachment.download');
            });

            //KYC
            Route::controller('UserController')->group(function () {
                Route::get('kyc-form', 'kycForm')->name('kyc.form');
                Route::get('kyc-data', 'kycData')->name('kyc.data');
                Route::post('kyc-submit', 'kycSubmit')->name('kyc.submit');
            });

            //File Management
            Route::controller('FileController')->prefix('file')->name('file.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::post('/store', 'fileStore')->name('store');
                Route::get('/edit/{id}', 'edit')->name('edit');
                Route::post('/edit/{id}', 'fileEdit')->name('update');
                Route::post('/delete/{id}', 'fileDelete')->name('delete');

                Route::get('/download/{id}', 'download')->name('download');
                Route::get('/get/subscription/{id}', 'downloadBySubscription')->name('get');
            });

            //Copy Prompt
            Route::controller('WishlistController')->group(function () {
                Route::get('mark/wishlist', 'wishlist')->name('mark.wishlist');
                Route::get('wishlist-delete/{id}', 'wishlistDelete')->name('wishlist.delete');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile/setting', 'profile')->name('profile.setting');
                Route::post('profile/setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
                Route::post('change-image/{id}', 'changeProfileImage')->name('change.image');
            });


            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function () {
                Route::get('/', 'withdrawMoney');
                Route::post('/', 'withdrawStore')->name('.money');
                Route::get('preview', 'withdrawPreview')->name('.preview');
                Route::post('preview', 'withdrawSubmit')->name('.submit');
                Route::get('history', 'withdrawLog')->name('.history');
            });

            Route::middleware('kyc')->group(function () {
                // Category Management
                Route::controller('CategoryController')->prefix('category')->name('category.')->group(function () {
                    Route::get('index', 'index')->name('index');
                    Route::get('my-list', 'myList')->name('my.list');
                    Route::post('create', 'create')->name('create');
                    Route::post('update/{id}', 'update')->name('update');
                });

                // State Management
                Route::controller('StateController')->prefix('state')->name('state.')->group(function () {
                    Route::get('index', 'index')->name('index');
                    Route::get('my-list', 'myList')->name('my.list');
                    Route::post('create', 'create')->name('create');
                    Route::post('update/{id}', 'update')->name('update');
                });

                // Country Management
                Route::controller('CountyController')->prefix('county')->name('county.')->group(function () {
                    Route::get('index', 'index')->name('index');
                    Route::get('my-list', 'myList')->name('my.list');
                    Route::post('create', 'create')->name('create');
                    Route::post('update/{id}', 'update')->name('update');
                });

                // Neighborhood Management
                Route::controller('NeighborhoodController')->prefix('neighborhood')->name('neighborhood.')->group(function () {
                    Route::get('index', 'index')->name('index');
                    Route::get('my-list', 'myList')->name('my.list');
                    Route::post('create', 'create')->name('create');
                    Route::post('update/{id}', 'update')->name('update');
                });

                // Image Category Management
                Route::controller('ImageCategoryController')->prefix('image-category')->name('image.category.')->group(function () {
                    Route::get('index', 'index')->name('index');
                    Route::get('my-list', 'myList')->name('my.list');
                    Route::post('create', 'create')->name('create');
                    Route::post('update/{id}', 'update')->name('update');
                });


                // Building Management
                Route::controller('BuildingController')->prefix('building')->name('building.')->group(function () {
                    Route::get('index', 'index')->name('index');
                    Route::get('my-list', 'myList')->name('my.list');
                    Route::get('create/{id}', 'create')->name('create');
                    Route::post('store', 'store')->name('store');


                    Route::post('image-description-store', 'imageDescriptionStore')->name('image.description.store');
                    Route::post('image-description-update', 'imageDescriptionUpdate')->name('image.description.update');
                    Route::get('image-upload-create/{id}', 'imageUpload')->name('upload');
                    Route::get('image-upload-edit/{id}', 'editImageUpload')->name('edit.upload');
                    Route::post('upload-chunk',  'uploadChunk')->name('upload.chunk');
                    Route::post('image-upload',  'upload')->name('upload.store');
                    Route::post('upload-chunk-delete',  'chunkOrImageDelete')->name('upload.chunk.delete');


                    Route::get('claim/{id}', 'claimed')->name('claim');
                    Route::get('edit/{id}', 'edit')->name('edit');
                    Route::post('update/{id}', 'update')->name('update');
                    Route::post('delete/{id}', 'delete')->name('delete');
                    Route::post('building-image-delete/{id}', 'buildingImageDelete')->name('image.delete');
                });

                // Listing Image Management
                Route::controller('ListingAssetController')->prefix('listing-unit')->name('listing.asset.')->group(function () {
                    Route::get('index', 'index')->name('index');
                    Route::get('my-list', 'myList')->name('my.list');
                    Route::get('create', 'create')->name('create');
                    Route::post('store', 'store')->name('store');

                    Route::get('image-upload-create/{id}', 'imageUpload')->name('upload');
                    Route::post('upload-chunk',  'uploadChunk')->name('upload.chunk');
                    Route::post('image-upload',  'upload')->name('upload.store');
                    Route::post('upload-chunk-delete',  'chunkOrImageDelete')->name('upload.chunk.delete');

                    Route::get('edit/{id}', 'edit')->name('edit');
                    Route::post('update/{id}', 'update')->name('update');
                    Route::post('delete/{id}', 'delete')->name('delete');
                    Route::post('listing-image-delete/{id}', 'ListingImageDelete')->name('image.delete');
                    Route::post('add-images-store/{id}', 'addImagesStore')->name('add.images.store');
                });
            });
        });

        // Payment
        Route::middleware('registration.complete')->controller('Gateway\PaymentController')->group(function () {
            Route::post('payment', 'payment')->name('payment');
            Route::post('condo-building/payment', 'condoBuildingPayment')->name('condo.building.payment');
            Route::post('condo-listing/payment', 'condoListingPayment')->name('condo.listing.payment');
            Route::any('/deposit', 'deposit')->name('deposit');
            Route::post('condo-deposit/insert', 'condoDepositInsert')->name('condo.deposit.insert');
            Route::post('deposit/insert', 'depositInsert')->name('deposit.insert');
            Route::get('deposit/confirm', 'depositConfirm')->name('deposit.confirm');
            Route::get('deposit/manual', 'manualDepositConfirm')->name('deposit.manual.confirm');
            Route::post('deposit/manual', 'manualDepositUpdate')->name('deposit.manual.update');
        });
    });
});
