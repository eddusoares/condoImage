<?php

namespace App\Providers;

use App\Models\File;
use App\Models\User;
use App\Models\Admin;
use App\Models\Deposit;
use App\Models\Building;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Withdrawal;
use App\Models\ListingUnit;
use App\Models\ListingImage;
use App\Models\SupportTicket;
use App\Models\AdminNotification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $general = gs();
        $activeTemplate = activeTemplate();
        $viewShare['general'] = $general;
        $viewShare['activeTemplate'] = $activeTemplate;
        $viewShare['activeTemplateTrue'] = activeTemplate(true);
        $viewShare['language'] = Language::all();
        $viewShare['emptyMessage'] = 'No data';
        view()->share($viewShare);


        view()->composer('admin.components.tabs.user', function ($view) {
            $view->with([
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount' => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),
                'kycUnverifiedUsersCount'   => User::kycUnverified()->count(),
                'kycPendingUsersCount'   => User::kycPending()->count(),
            ]);
        });
        view()->composer('admin.components.tabs.owner', function ($view) {
            $view->with([
                'allFileCount'           => File::where('user_id', '!=', 0)->count(),
                'adminFileCount'           => File::where('user_id', 0)->count(),
            ]);
        });
        view()->composer('admin.components.tabs.review', function ($view) {
            $view->with([
                'filePendingCount'           => File::where('reviewer_id', null)->where('status', 0)->count(),
                'fileOnReviewingCount'       => File::where('reviewer_id', 0)->where('status', 3)->count(),
                'filePublishedCount'         => File::where('reviewer_id', 0)->where('status', 1)->count(),
                'fileRejectedCount'          => File::where('reviewer_id', 0)->where('status', 2)->count()
            ]);
        });
        view()->composer('reviewer.components.tabs.review', function ($view) {
            $view->with([
                'filePendingCount'           => File::where('reviewer_id', null)->where('status', 0)->count(),
                'fileOnReviewingCount'        => File::where('reviewer_id', auth()->guard('reviewer')->user()->id)->where('status', 3)->count(),
                'filePublishedCount'         => File::where('reviewer_id', auth()->guard('reviewer')->user()->id)->where('status', 1)->count(),
                'fileRejectedCount'          => File::where('reviewer_id', auth()->guard('reviewer')->user()->id)->where('status', 2)->count()
            ]);
        });
        view()->composer('admin.components.tabs.deposit', function ($view) {
            $view->with([
                'pendingDepositsCount'    => Deposit::pending()->count(),
            ]);
        });
        view()->composer('admin.components.tabs.building', function ($view) {
            $view->with([
                'allBuildings'    => Building::all()->count(),
        
                'pendingBuildings'    => Building::pending()->count(),
                'activeBuildings'    => Building::active()->count(),
            ]);
        });
        view()->composer('admin.components.tabs.listing_image', function ($view) {
            $view->with([
                'allListing'    => ListingUnit::all()->count(),

                'pendingListingImages'    => ListingUnit::pending()->count(),
                'activeListingImages'    => ListingUnit::active()->count(),
            ]);
        });
        view()->composer('admin.components.tabs.withdrawal', function ($view) {
            $view->with([
                'pendingWithdrawCount'    => Withdrawal::pending()->count(),
            ]);
        });
        view()->composer('admin.components.tabs.ticket', function ($view) {
            $view->with([
                'pendingTicketCount'         => SupportTicket::whereIN('status', [0, 2])->count(),
            ]);
        });
        view()->composer('admin.components.sidenav', function ($view) {
            $view->with([
                'bannedUsersCount'           => User::banned()->count(),
                'emailUnverifiedUsersCount' => User::emailUnverified()->count(),
                'mobileUnverifiedUsersCount'   => User::mobileUnverified()->count(),
                'kycUnverifiedUsersCount'   => User::kycUnverified()->count(),
                'kycPendingUsersCount'   => User::kycPending()->count(),
                'pendingTicketCount'         => SupportTicket::whereIN('status', [0, 2])->count(),
                'pendingDepositsCount'    => Deposit::pending()->count(),
                'pendingWithdrawCount'    => Withdrawal::pending()->count(),
            ]);
        });
     

        view()->composer('admin.components.topnav', function ($view) {
            $view->with([
                'adminNotifications' => AdminNotification::where('read_status', 0)->with('user')->orderBy('id', 'desc')->take(10)->get(),
                'adminNotificationCount' => AdminNotification::where('read_status', 0)->count(),
            ]);
        });

        view()->composer('includes.seo', function ($view) {
            $seo = Frontend::where('data_keys', 'seo.data')->first();
            $view->with([
                'seo' => $seo ? $seo->data_values : $seo,
            ]);
        });

        if ($general->force_ssl) {
            \URL::forceScheme('https');
        }


        Paginator::useBootstrapFour();

        // Morph Map (optional but recommended) source (Laravel)
        Relation::morphMap([
            'user' => User::class,
            'admin' => Admin::class,
        ]);
    }
}
