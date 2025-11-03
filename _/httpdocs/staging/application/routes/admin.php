<?php

use Illuminate\Support\Facades\Route;


Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return redirect()->back();
})->name('clear.cache');

Route::namespace('Auth')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'login')->name('login');
        Route::get('logout', 'logout')->name('logout');
    });

    // Admin Password Reset
    Route::controller('ForgotPasswordController')->group(function () {
        Route::get('password/reset', 'showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'sendResetCodeEmail');
        Route::get('password/code-verify', 'codeVerify')->name('password.code.verify');
        Route::post('password/verify-code', 'verifyCode')->name('password.verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'reset')->name('password.change');
    });
});

Route::middleware('admin')->group(function () {
    Route::controller('AdminController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::post('password', 'passwordUpdate')->name('password.update');

        //Notification
        Route::get('notifications', 'notifications')->name('notifications');
        Route::get('notification/read/{id}', 'notificationRead')->name('notification.read');
        Route::get('notifications/read-all', 'readAll')->name('notifications.readAll');

        //Report Bugs
        Route::get('request/report', 'requestReport')->name('request.report');
        Route::post('request/report', 'reportSubmit');

        Route::get('download/attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
    });

    // Storage Manager
    Route::name('storage.')->prefix('storage')->group(function () {
        Route::get('/', 'StorageController@index')->name('index');
        Route::get('edit/{storageProvider}', 'StorageController@edit')->name('edit');
        Route::post('update/{storageProvider}', 'StorageController@update')->name('update');
        Route::post('connect/{storageProvider}', 'StorageController@storageTest')->name('test');
        Route::post('default/{storageProvider}', 'StorageController@setDefault')->name('default');
        Route::post('status', 'StorageController@status')->name('status');
    });

    // Category Management
    Route::controller('CategoryController')->prefix('category')->name('category.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('create', 'create')->name('create');
        Route::post('update/{id}', 'update')->name('update');
    });

    // State Management
    Route::controller('StateController')->prefix('state')->name('state.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('create', 'create')->name('create');
        Route::post('update/{id}', 'update')->name('update');
    });

    // County Management
    Route::controller('CountyController')->prefix('county')->name('county.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('create', 'create')->name('create');
        Route::post('update/{id}', 'update')->name('update');
    });

    // Neighborhood Management
    Route::controller('NeighborhoodController')->prefix('neighborhood')->name('neighborhood.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('create', 'create')->name('create');
        Route::post('update/{id}', 'update')->name('update');
    });

    // Image Category Management
    Route::controller('ImageCategoryController')->prefix('image-category')->name('image.category.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::post('create', 'create')->name('create');
        Route::post('update/{id}', 'update')->name('update');
    });


    // Building Management
    Route::controller('BuildingController')->prefix('building')->name('building.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');

        Route::post('image-description-store', 'imageDescriptionStore')->name('image.description.store');
        Route::post('image-description-update', 'imageDescriptionUpdate')->name('image.description.update');
        Route::get('image-upload-create/{id}', 'imageUpload')->name('upload');
        Route::get('image-upload-edit/{id}', 'editImageUpload')->name('edit.upload');
        Route::post('upload-chunk',  'uploadChunk')->name('upload.chunk');
        Route::post('image-upload',  'upload')->name('upload.store');
        Route::post('upload-chunk-delete',  'chunkOrImageDelete')->name('upload.chunk.delete');

        Route::get('view/{id}', 'view')->name('view');
        Route::post('claim/{id}', 'claim')->name('claim');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('delete/{id}', 'delete')->name('delete');
        Route::post('status-change/{id}', 'statusChange')->name('status.change');
        Route::get('pending', 'pending')->name('pending');
        Route::get('active', 'active')->name('active');
        Route::post('building-image-delete/{id}', 'buildingImageDelete')->name('image.delete');

        Route::get('sold-by-contributor', 'soldByContributor')->name('sold.by.contributor');
    });

    // Listing Image Management
    Route::controller('ListingAssetController')->prefix('listing-unit')->name('listing.asset.')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('my-list', 'myList')->name('my.list');
        Route::get('create/', 'create')->name('create');
        Route::post('store', 'store')->name('store');

        Route::get('image-upload-create/{id}', 'imageUpload')->name('upload');
        Route::post('upload-chunk',  'uploadChunk')->name('upload.chunk');
        Route::post('image-upload',  'upload')->name('upload.store');
        Route::post('upload-chunk-delete',  'chunkOrImageDelete')->name('upload.chunk.delete');

        Route::get('view/{id}', 'view')->name('view');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('delete/{id}', 'delete')->name('delete');
        Route::post('status-change/{id}', 'statusChange')->name('status.change');
        Route::get('pending', 'pending')->name('pending');
        Route::get('active', 'active')->name('active');
        Route::post('listing-image-delete/{id}', 'ListingImageDelete')->name('image.delete');
        Route::post('add-images-store/{id}', 'addImagesStore')->name('add.images.store');
    });


    // Tag Management
    Route::controller('TagController')->prefix('tag')->name('tag.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::post('update', 'update')->name('update');
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
    Route::controller('ReviewerController')->prefix('reviewer')->name('reviewer.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('insert', 'insert')->name('insert');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('delete/{id}', 'delete')->name('delete');
    });

    // Users Manager
    Route::controller('ManageUsersController')->name('users.')->prefix('manage/users')->group(function () {
        Route::get('/', 'allUsers')->name('all');
        Route::get('active', 'activeUsers')->name('active');
        Route::get('banned', 'bannedUsers')->name('banned');
        Route::get('email/verified', 'emailVerifiedUsers')->name('email.verified');
        Route::get('email/unverified', 'emailUnverifiedUsers')->name('email.unverified');
        Route::get('mobile/unverified', 'mobileUnverifiedUsers')->name('mobile.unverified');
        Route::get('mobile/verified', 'mobileVerifiedUsers')->name('mobile.verified');
        Route::get('mobile/verified', 'mobileVerifiedUsers')->name('mobile.verified');
        Route::get('with/balance', 'usersWithBalance')->name('with.balance');

        Route::get('detail/{id}', 'detail')->name('detail');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('add/sub/balance/{id}', 'addSubBalance')->name('add.sub.balance');
        Route::get('send/notification/{id}', 'showNotificationSingleForm')->name('notification.single');
        Route::post('send/notification/{id}', 'sendNotificationSingle')->name('notification.single');
        Route::get('login/{id}', 'login')->name('login');
        Route::post('status/{id}', 'status')->name('status');

        Route::get('send/notification', 'showNotificationAllForm')->name('notification.all');
        Route::post('send/notification', 'sendNotificationAll')->name('notification.all.send');
        Route::get('notification/log/{id}', 'notificationLog')->name('notification.log');
    });

    // Subscriber
    Route::controller('SubscriberController')->group(function () {
        Route::get('subscriber', 'index')->name('subscriber.index');
        Route::get('subscriber/send/email', 'sendEmailForm')->name('subscriber.send.email');
        Route::post('subscriber/remove/{id}', 'remove')->name('subscriber.remove');
        Route::post('subscriber/send/email', 'sendEmail')->name('subscriber.send.email');
    });


    // Deposit Gateway
    Route::name('gateway.')->prefix('payment/gateways')->group(function () {

        // Automatic Gateway
        Route::controller('AutomaticGatewayController')->group(function () {
            Route::get('automatic', 'index')->name('automatic.index');
            Route::get('automatic/edit/{alias}', 'edit')->name('automatic.edit');
            Route::post('automatic/update/{code}', 'update')->name('automatic.update');
            Route::post('automatic/remove/{id}', 'remove')->name('automatic.remove');
            Route::post('automatic/activate/{code}', 'activate')->name('automatic.activate');
            Route::post('automatic/deactivate/{code}', 'deactivate')->name('automatic.deactivate');
        });


        // Manual Methods
        Route::controller('ManualGatewayController')->group(function () {
            Route::get('manual', 'index')->name('manual.index');
            Route::get('manual/new', 'create')->name('manual.create');
            Route::post('manual/new', 'store')->name('manual.store');
            Route::get('manual/edit/{alias}', 'edit')->name('manual.edit');
            Route::post('manual/update/{id}', 'update')->name('manual.update');
            Route::post('manual/activate/{code}', 'activate')->name('manual.activate');
            Route::post('manual/deactivate/{code}', 'deactivate')->name('manual.deactivate');
        });
    });


    // DEPOSIT SYSTEM
    Route::name('deposit.')->controller('DepositController')->prefix('manage/deposits')->group(function () {
        Route::get('/', 'deposit')->name('list');
        Route::get('pending', 'pending')->name('pending');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('approved', 'approved')->name('approved');
        Route::get('successful', 'successful')->name('successful');
        Route::get('initiated', 'initiated')->name('initiated');
        Route::get('details/{id}', 'details')->name('details');

        Route::post('reject', 'reject')->name('reject');
        Route::post('approve/{id}', 'approve')->name('approve');
    });


    // WITHDRAW SYSTEM
    Route::name('withdraw.')->prefix('manage/withdrawals')->group(function () {

        Route::controller('WithdrawalController')->group(function () {
            Route::get('pending', 'pending')->name('pending');
            Route::get('approved', 'approved')->name('approved');
            Route::get('rejected', 'rejected')->name('rejected');
            Route::get('log', 'log')->name('log');
            Route::get('details/{id}', 'details')->name('details');
            Route::post('approve', 'approve')->name('approve');
            Route::post('reject', 'reject')->name('reject');
        });


        // Withdraw Method
        Route::controller('WithdrawMethodController')->group(function () {
            Route::get('method/', 'methods')->name('method.index');
            Route::get('method/create', 'create')->name('method.create');
            Route::post('method/create', 'store')->name('method.store');
            Route::get('method/edit/{id}', 'edit')->name('method.edit');
            Route::post('method/edit/{id}', 'update')->name('method.update');
            Route::post('method/activate/{id}', 'activate')->name('method.activate');
            Route::post('method/deactivate/{id}', 'deactivate')->name('method.deactivate');
        });
    });

    // Report
    Route::controller('ReportController')->group(function () {
        Route::get('report/transaction', 'transaction')->name('report.transaction');
        Route::get('report/login/history', 'loginHistory')->name('report.login.history');
        Route::get('report/login/ipHistory/{ip}', 'loginIpHistory')->name('report.login.ipHistory');
        Route::get('report/notification/history', 'notificationHistory')->name('report.notification.history');
        Route::get('report/email/detail/{id}', 'emailDetails')->name('report.email.details');
    });


    // Admin Support
    Route::controller('SupportTicketController')->prefix('support')->group(function () {
        Route::get('tickets', 'tickets')->name('ticket');
        Route::get('tickets/pending', 'pendingTicket')->name('ticket.pending');
        Route::get('tickets/closed', 'closedTicket')->name('ticket.closed');
        Route::get('tickets/answered', 'answeredTicket')->name('ticket.answered');
        Route::get('tickets/view/{id}', 'ticketReply')->name('ticket.view');
        Route::post('ticket/reply/{id}', 'replyTicket')->name('ticket.reply');
        Route::post('ticket/close/{id}', 'closeTicket')->name('ticket.close');
        Route::get('ticket/download/{ticket}', 'ticketDownload')->name('ticket.download');
        Route::post('ticket/delete/{id}', 'ticketDelete')->name('ticket.delete');
    });


    // Language Manager
    Route::controller('LanguageController')->prefix('manage')->group(function () {
        Route::get('languages', 'langManage')->name('language.manage');
        Route::post('language', 'langStore')->name('language.manage.store');
        Route::post('language/delete/{id}', 'langDelete')->name('language.manage.delete');
        Route::post('language/update/{id}', 'langUpdate')->name('language.manage.update');
        Route::get('language/edit/{id}', 'langEdit')->name('language.key');
        Route::post('language/import', 'langImport')->name('language.import.lang');
        Route::post('language/store/key/{id}', 'storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'updateLanguageJson')->name('language.update.key');
        Route::get('language/search/', 'langSearch')->name('language.manage.search');
        Route::get('language/search/replace/', 'langSearchReplace')->name('language.manage.search.replace');
    });

    Route::controller('GeneralSettingController')->group(function () {
        // General Setting
        Route::get('global/settings', 'index')->name('setting.index');
        Route::post('global/settings', 'update')->name('setting.update');

        Route::post('update/commission', 'updateComission')->name('update.commission');
        Route::post('update/image/price', 'updateImagePrice')->name('update.image.price');
        Route::post('update/package/setting', 'updatePackageSetting')->name('update.package.setting');

        //configuration
        Route::post('setting/system-configuration', 'systemConfigurationSubmit');

        // Logo-Icon
        Route::get('setting/logo', 'logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo', 'logoIconUpdate')->name('setting.logo.icon');

        // watermark
        Route::post('setting/watermark', 'watermarkUpdate')->name('setting.watermark.update');
        // image resolution & compression
        Route::post('setting/resolution', 'resolutionUpdate')->name('setting.image.resolution.update');

        //Cookie
        Route::get('cookie', 'cookie')->name('setting.cookie');
        Route::post('cookie', 'cookieSubmit');

        //Custom CSS
        Route::get('custom-css', 'customCss')->name('setting.custom.css');
        Route::post('custom-css', 'customCssSubmit');
    });

    //Notification Setting
    Route::name('setting.notification.')->controller('NotificationController')->prefix('notifications')->group(function () {
        //Template Setting
        Route::get('global', 'global')->name('global');
        Route::post('global/update', 'globalUpdate')->name('global.update');
        Route::get('templates', 'templates')->name('templates');
        Route::get('template/edit/{id}', 'templateEdit')->name('template.edit');
        Route::post('template/update/{id}', 'templateUpdate')->name('template.update');

        //Email Setting
        Route::get('email/setting', 'emailSetting')->name('email');
        Route::post('email/setting', 'emailSettingUpdate');
        Route::post('email/test', 'emailTest')->name('email.test');

        //SMS Setting
        Route::get('sms/setting', 'smsSetting')->name('sms');
        Route::post('sms/setting', 'smsSettingUpdate');
        Route::post('sms/test', 'smsTest')->name('sms.test');
    });

    // Plugin
    Route::controller('ExtensionController')->group(function () {
        Route::get('extensions', 'index')->name('extensions.index');
        Route::post('extensions/update/{id}', 'update')->name('extensions.update');
        Route::post('extensions/status/{id}', 'status')->name('extensions.status');
    });
    // SEO
    Route::get('seo', 'FrontendController@seoEdit')->name('seo');


    // Frontend
    Route::name('frontend.')->prefix('frontend')->group(function () {

        Route::controller('FrontendController')->group(function () {
            Route::get('templates', 'templates')->name('templates');
            Route::post('templates', 'templatesActive')->name('templates.active');
            Route::get('frontend-sections/{key}', 'frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'frontendElement')->name('sections.element');
            Route::post('remove/{id}', 'remove')->name('remove');
        });

        // Page Builder
        Route::controller('PageBuilderController')->prefix('manage')->group(function () {
            Route::get('pages', 'managePages')->name('manage.pages');
            Route::post('pages', 'managePagesSave')->name('manage.pages.save');
            Route::post('pages/update', 'managePagesUpdate')->name('manage.pages.update');
            Route::post('pages/delete/{id}', 'managePagesDelete')->name('manage.pages.delete');
            Route::get('section/{id}', 'manageSection')->name('manage.section');
            Route::post('section/{id}', 'manageSectionUpdate')->name('manage.section.update');
        });
    });
});
