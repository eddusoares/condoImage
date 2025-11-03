<?php

use App\Lib\Router;
use Illuminate\Support\Facades\Route;

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->group(function () {
    Route::get('/', 'supportTicket')->name('ticket');
    Route::get('/new', 'openSupportTicket')->name('ticket.open');
    Route::post('/create', 'storeSupportTicket')->name('ticket.store');
    Route::get('/view/{ticket}', 'viewTicket')->name('ticket.view');
    Route::post('/reply/{ticket}', 'replyTicket')->name('ticket.reply');
    Route::post('/close/{ticket}', 'closeTicket')->name('ticket.close');
    Route::get('/download/{ticket}', 'ticketDownload')->name('ticket.download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::post('newsletter/create', 'sendNewsLetter')->name('newsletter.create');
     Route::get('search', 'searchBuilding')->name('search.building');
   

    Route::get('search/tag/{id}', 'searchByTag')->name('search.by.tag');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/explore', 'exploreFiles')->name('explore');
    Route::get('county/{slug}/{id}', 'county')->name('county');
    Route::get('/neighborhood', 'neighborhood')->name('neighborhood');
    Route::get('/{county}/{slug}/{id}', 'neighborhoodDetails')->name('neighborhood.details');
    Route::get('/condo-building', 'condoBuilding')->name('condo.building');
    Route::get('/{county}/{neighborhood}/{slug}/{id}', 'condoBuildingDetails')->name('condo.building.details');
    Route::get('/{county}/{neighborhood}/{slug}/{unit}/{id}', 'condoBuildingListingImages')->name('condo.building.listing.images');

    Route::get('/category/{id}', 'filesByCategory')->name('files.category');
    Route::get('filter/by/category', 'filterByCat')->name('filter.by.category');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('file/details/{id}', 'fileDetails')->name('file.details');
    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');
    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');

});


