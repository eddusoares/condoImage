<?php

namespace App\Http\Controllers\Storage;

use Exception;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class AmazonController extends Controller
{
    protected $disk = null;
    // use FileStorageHandler;
    public function __construct()
    {
        $this->disk = Storage::disk('s3');
    }

    public static function setCredentials($data)
    {
        updateEnvironmentVariable('AWS_ACCESS_KEY_ID', $data->credentials->access_key_id);
        updateEnvironmentVariable('AWS_SECRET_ACCESS_KEY', $data->credentials->secret_access_key);
        updateEnvironmentVariable('AWS_URL', $data->credentials->url);
        updateEnvironmentVariable('AWS_DEFAULT_REGION', $data->credentials->default_region);
        updateEnvironmentVariable('AWS_BUCKET', $data->credentials->bucket);
        updateEnvironmentVariable('AWS_ENDPOINT', $data->credentials->endpoint);
    }


}
