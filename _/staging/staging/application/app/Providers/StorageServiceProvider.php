<?php

namespace App\Providers;

use App\Models\StorageProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $serviceProvider = Cache::remember('storage_provider', 120, function () {
            return StorageProvider::where('status', 1)->first();
        });

        if ($serviceProvider && $serviceProvider->alias === "s3") {
            Config::set('filesystems.disks.s3', [
                'driver' => $serviceProvider->alias,
                'key' => $serviceProvider->credentials->access_key_id ?? '',
                'secret' => $serviceProvider->credentials->secret_access_key ?? '',
                'region' => $serviceProvider->credentials->default_region,
                'bucket' => $serviceProvider->credentials->bucket,
                'url' => $serviceProvider->credentials->url,
                'endpoint' => $serviceProvider->credentials->endpoint,
                'use_path_style_endpoint' => false,
                'throw' => false,
            ]);
        } elseif ($serviceProvider && $serviceProvider->alias === 'wasabi') {
            Config::set('filesystems.disks.s3', [
                'driver' => $serviceProvider->alias,
                'key' => $serviceProvider->credentials->access_key_id,
                'secret' => $serviceProvider->credentials->secret_access_key,
                'region' => $serviceProvider->credentials->default_region,
                'bucket' => $serviceProvider->credentials->bucket,
                'url' => $serviceProvider->credentials->url,
                'endpoint' => $serviceProvider->credentials->endpoint,
            ]);
        }
    }
}
