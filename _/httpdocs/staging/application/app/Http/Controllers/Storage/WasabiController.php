<?php

namespace App\Http\Controllers\Storage;

use Exception;
use App\Traits\FileStorageHandler;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

class WasabiController extends Controller
{
    // use FileStorageHandler;

    public function __construct()
    {
        $this->disk = Storage::disk('wasabi');
    }

    public static function setCredentials($data)
    {
        updateEnvironmentVariable('WAS_ACCESS_KEY_ID', $data->credentials->access_key_id);
        updateEnvironmentVariable('WAS_SECRET_ACCESS_KEY', $data->credentials->secret_access_key);
        updateEnvironmentVariable('WAS_BUCKET', $data->credentials->bucket);
        updateEnvironmentVariable('WAS_DEFAULT_REGION', $data->credentials->default_region);
        updateEnvironmentVariable('WAS_URL', $data->credentials->url);
        updateEnvironmentVariable('WAS_ENDPOINT', $data->credentials->endpoint);
    }

}
