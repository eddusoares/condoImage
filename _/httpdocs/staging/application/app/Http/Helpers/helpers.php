<?php

use Carbon\Carbon;
use App\Lib\Captcha;
use App\Notify\Notify;
use App\Lib\ClientInfo;
use App\Lib\CurlRequest;
use App\Lib\FileManager;
use App\Models\Frontend;
use App\Models\Extension;
use Illuminate\Support\Str;
use App\Models\Subscription;
use App\Models\GeneralSetting;
use App\Models\StorageProvider;
use App\Lib\GoogleAuthenticator;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

function slug($string)
{
    return Illuminate\Support\Str::slug($string);
}

function verificationCode($length)
{
    if ($length == 0)
        return 0;
    $min = pow(10, $length - 1);
    $max = (int) ($min - 1) . '9';
    return random_int($min, $max);
}

function getNumber($length = 8)
{
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function sysInfo()
{
    $system['name'] = gs()->site_name;
    $system['version'] = '10.2.0';
    $system['build_version'] = '10.3.3';
    $system['admin_version'] = '10.2.0';
    return $system;
}

function activeTemplate($asset = false)
{
    $general = gs();
    $template = $general->active_template;
    if ($asset)
        return 'assets/presets/' . $template . '/';
    return 'presets.' . $template . '.';
}

function activeTemplateName()
{
    $general = gs();
    $template = $general->active_template;
    return $template;
}

function updateEnvironmentVariable($envKey, $envValue, $shouldQuote = false)
{
    $envFilePath = app()->environmentFilePath(); // Get .env file path
    $fileContent = file_get_contents($envFilePath); // Read .env file

    // Ensure proper formatting of the value (quotes for spaces or special characters)
    $formattedValue = trim($envValue);
    if (preg_match('/\s/', $formattedValue)) { // If value contains spaces, wrap it in quotes
        $formattedValue = '"' . $formattedValue . '"';
    }

    // Check if the key already exists
    $keyPosition = strpos($fileContent, "{$envKey}=");

    if ($keyPosition !== false) {
        // Replace the existing key-value pair
        $fileContent = preg_replace("/^{$envKey}=.*/m", "{$envKey}={$formattedValue}", $fileContent);
    } else {
        // Append new key-value if it does not exist
        $fileContent .= "\n{$envKey}={$formattedValue}\n";
    }

    // Write the new content back to .env file
    file_put_contents($envFilePath, $fileContent);

    // Clear config cache so changes take effect
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
}


function spaceTrim($string)
{
    return $cleaned = preg_replace('/\s+/', '', $string);
}


function fileStorePath($file, $filetype = '')
{
    $cloudDisks = ['s3', 'wasabi'];
    $filetype =  trim($filetype, '/');

    if (in_array($file->type, $cloudDisks)) {
        $fullPath = $file->file_path . '/' . $filetype . '/' . $file->file_name;
        return $fullPath;
    } else {
        if ($filetype == '') {
            $filetype = 'file';
        }

        return getImage(getFilePath($filetype) . '/' . $file->file_name);
    }
}

function getAwsPath()
{
    $aws = StorageProvider::first();
    if (!$aws) {
        abort(404, 'CloudService record not found.');
    }
    $credentials = json_decode($aws->credentials, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        abort(500, 'Invalid JSON in AWS credentials.');
    }
    return $credentials['path'] ?? null;
}



function loadReCaptcha()
{
    return Captcha::reCaptcha();
}

function loadCustomCaptcha($width = '100%', $height = 46, $bgColor = '#003')
{
    return Captcha::customCaptcha($width, $height, $bgColor);
}

function verifyCaptcha()
{
    return Captcha::verify();
}

function loadExtension($key)
{
    $analytics = Extension::where('act', $key)->where('status', 1)->first();
    return $analytics ? $analytics->generateScript() : '';
}

function getTrx($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getAmount($amount, $length = 2)
{
    $amount = round($amount, $length);
    return $amount + 0;
}

function showAmount($amount, $decimal = 2, $separate = true, $exceptZeros = false)
{
    $separator = '';
    if ($separate) {
        $separator = ',';
    }
    $printAmount = number_format($amount, $decimal, '.', $separator);
    if ($exceptZeros) {
        $exp = explode('.', $printAmount);
        if ($exp[1] * 1 == 0) {
            $printAmount = $exp[0];
        }
    }
    return $printAmount;
}


function removeElement($array, $value)
{
    return array_diff($array, (is_array($value) ? $value : array($value)));
}

function cryptoQR($wallet)
{
    return "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$wallet&choe=UTF-8";
}


function keyToTitle($text)
{
    return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
}


function titleToKey($text)
{
    return strtolower(str_replace(' ', '_', $text));
}


function strLimit($title = null, $length = 10)
{
    return Str::limit($title, $length);
}


function getIpInfo()
{
    $ipInfo = ClientInfo::ipInfo();
    return $ipInfo;
}


function osBrowser()
{
    $osBrowser = ClientInfo::osBrowser();
    return $osBrowser;
}


function getTemplates()
{
    $param['purchasecode'] = env("PURCHASECODE");
    $param['website'] = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'] . ' - ' . env("APP_URL");
    $url = 'https://license.wstacks.com/updates/templates/' . systemDetails()['name'];
    $response = CurlRequest::curlPostContent($url, $param);
    if ($response) {
        return $response;
    } else {
        return null;
    }
}




function getPageSections($arr = false)
{
    $jsonUrl = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections/builder/builder.json';
    if (!is_file($jsonUrl)) {
        return $arr ? [] : (object)[];
    }
    $rawJson = @file_get_contents($jsonUrl);
    if ($rawJson === false) {
        return $arr ? [] : (object)[];
    }
    $assoc = json_decode($rawJson, true);
    if (!is_array($assoc)) {
        return $arr ? [] : (object)[];
    }
    ksort($assoc);
    return $arr ? $assoc : json_decode(json_encode($assoc));
}
function getImage($image, $size = null)
{
    $clean = '';

    if (empty($image)) {
        return $size ? baseRoute('placeholder.image', $size) : baseAsset('assets/images/general/default.png');
    }

    if (filter_var($image, FILTER_VALIDATE_URL)) {
        return $image;
    }

    $relativePath = ltrim($image, '/\\');
    $filesystemPath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);
    if ($filesystemPath === '') {
        return $size ? baseRoute('placeholder.image', $size) : baseAsset('assets/images/general/default.png');
    }

    $candidatePaths = [];

    try {
        $docRoot = rtrim(dirname(base_path()), DIRECTORY_SEPARATOR); // application/.. => httpdocs/staging
        $candidatePaths[] = $docRoot . DIRECTORY_SEPARATOR . $filesystemPath;
    } catch (\Throwable $e) {
        // ignore
    }

    try {
        $candidatePaths[] = base_path(str_replace('\\', '/', $relativePath));
    } catch (\Throwable $e) {
        // ignore
    }

    if (function_exists('public_path')) {
        try {
            $candidatePaths[] = public_path(str_replace('\\', '/', $relativePath));
        } catch (\Throwable $e) {
            // ignore
        }
    }

    foreach (array_filter(array_unique($candidatePaths)) as $candidate) {
        if ($candidate === DIRECTORY_SEPARATOR) {
            continue;
        }
        if (@is_file($candidate)) {
            return baseAsset($image) . $clean;
        }
    }

    if ($size) {
        return baseRoute('placeholder.image', $size);
    }
    return baseAsset('assets/images/general/default.png');
}

function notify($user, $templateName, $shortCodes = null, $sendVia = null, $createLog = true)
{
    $general = GeneralSetting::first();
    $globalShortCodes = [
        'site_name' => $general->site_name,
        'site_currency' => $general->cur_text,
        'currency_symbol' => $general->cur_sym,
    ];

    if (gettype($user) == 'array') {
        $user = (object) $user;
    }

    $shortCodes = array_merge($shortCodes ?? [], $globalShortCodes);

    $notify = new Notify($sendVia);
    $notify->templateName = $templateName;
    $notify->shortCodes = $shortCodes;
    $notify->user = $user;
    $notify->createLog = $createLog;
    $notify->userColumn = getColumnName($user);
    $notify->send();
}

function getColumnName($user)
{
    $array = explode("\\", get_class($user));
    return strtolower(end($array)) . '_id';
}

function getPaginate($paginate = 20)
{
    return $paginate;
}

function paginateLinks($data)
{
    return $data->appends(request()->all())->links();
}


function menuActive($routeName, $type = null, $param = null)
{
    if ($type == 3)
        $class = 'side-menu--open';
    elseif ($type == 2)
        $class = 'sidebar-submenu__open';
    else
        $class = 'active';

    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value))
                return $class;
        }
    } elseif (request()->routeIs($routeName)) {
        if ($param) {
            if (request()->route(@$param[0]) == @$param[1])
                return $class;
            else
                return;
        }
        return $class;
    }
}


function fileUploader($file, $location, $size = null, $old = null, $thumb = null, $watermark = null)
{

    $fileManager = new FileManager($file);
    $fileManager->path = $location;
    $fileManager->size = $size;
    $fileManager->old = $old;
    $fileManager->thumb = $thumb;
    $fileManager->watermark = $watermark;
    $fileManager->upload();
    return $fileManager->filename;
}

function fileManager()
{
    return new FileManager();
}

function getFilePath($key)
{

    return fileManager()->$key()->path;
}

function getFileSize($key)
{

    return fileManager()->$key()->size;
}

function getFileThumbSize($key)
{

    return fileManager()->$key()->thumb;
}

function getFileWatermarkSize($key)
{
    return fileManager()->$key()->watermark;
}

function getFileExt($key)
{
    return fileManager()->$key()->extensions;
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->diffForHumans();
}


function showDateTime($date, $format = 'M Y, h:i A')
{
    $lang = session()->get('lang');
    Carbon::setlocale($lang);
    return Carbon::parse($date)->translatedFormat($format);
}


function getContent($dataKeys, $singleQuery = false, $limit = null, $orderById = false)
{
    if ($singleQuery) {
        $content = Frontend::where('data_keys', $dataKeys)->orderBy('id', 'desc')->first();
    } else {
        $article = Frontend::query();
        $article->when($limit != null, function ($q) use ($limit) {
            return $q->limit($limit);
        });
        if ($orderById) {
            $content = $article->where('data_keys', $dataKeys)->orderBy('id')->get();
        } else {
            $content = $article->where('data_keys', $dataKeys)->orderBy('id', 'desc')->get();
        }
    }
    return $content;
}


function gatewayRedirectUrl($type = false)
{
    if ($type) {
        return 'user.deposit.history';
    } else {
        return 'user.deposit';
    }
}

function verifyG2fa($user, $code, $secret = null)
{
    $authenticator = new GoogleAuthenticator();
    if (!$secret) {
        $secret = $user->tsc;
    }
    $oneCode = $authenticator->getCode($secret);
    $userCode = $code;
    if ($oneCode == $userCode) {
        $user->tv = 1;
        $user->save();
        return true;
    } else {
        return false;
    }
}


function urlPath($routeName, $routeParam = null)
{
    if ($routeParam == null) {
        $url = route($routeName);
    } else {
        $url = route($routeName, $routeParam);
    }
    $basePath = route('home');
    $path = str_replace($basePath, '', $url);
    return $path;
}


function showMobileNumber($number)
{
    $length = strlen($number);
    return substr_replace($number, '***', 2, $length - 4);
}

function showEmailAddress($email)
{
    $endPosition = strpos($email, '@') - 1;
    return substr_replace($email, '***', 1, $endPosition);
}


function getRealIP()
{
    $ip = $_SERVER["REMOTE_ADDR"];
    //Deep detect ip
    if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED'];
    }
    if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    if ($ip == '::1') {
        $ip = '127.0.0.1';
    }

    return $ip;
}


function appendQuery($key, $value)
{
    return request()->fullUrlWithQuery([$key => $value]);
}

function dateSort($a, $b)
{
    return strtotime($a) - strtotime($b);
}

function dateSorting($arr)
{
    usort($arr, "dateSort");
    return $arr;
}

function gs()
{
    $general = Cache::get('GeneralSetting');
    if (!$general) {
        // During first boot or before DB is fully migrated, the table may not exist.
        // Guard to prevent errors during artisan commands like migrate.
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('general_settings')) {
                $general = GeneralSetting::first();
            }
        } catch (\Throwable $e) {
            // Ignore and fall back to defaults below
        }

        if (!$general) {
            $general = (object) [
                'site_name'       => config('app.name', 'Laravel'),
                'active_template' => 'default',
                'cur_text'        => 'USD',
                'cur_sym'         => '$',
                'force_ssl'       => false,
            ];
        } else {
            Cache::put('GeneralSetting', $general);
        }
    }
    return $general;
}

function isSubscribe($userId)
{
    $subscription = Subscription::where('user_id', $userId)
        ->orderBy('id', 'desc')
        ->first();
    if ($subscription && $subscription->ends_at >= now()) {
        // Active
        return $subscription;
    } else if ($subscription) {
        // Expired
        $subscription->delete();
        return false;
    } else {
        // No subscription
        return null;
    }
}



function s3ConnectOrNot($uuid, $filename)
{
    $storageProvider = StorageProvider::where('status', 1)->first();
    if ($storageProvider && $storageProvider->alias == "s3") {
        // Try connecting to S3
        try {
            $connected = Storage::disk('s3')->exists('/');

            if ($connected) {
                return true;
            } else {
                $finalPath = fileChunkDelete($filename, $uuid);
                unlink($finalPath);

                return [
                    'status' => 'error',
                    'message' => 'S3 connected, but access to root failed.'
                ];
            }
        } catch (\Exception $e) {
            $finalPath = fileChunkDelete($filename, $uuid);
            unlink($finalPath);
            return [
                'status' => 'error',
                'message' => 'Image upload and S3 connection failed: Missing required client configuration options.'
            ];
        }
    } else {
        $finalPath = fileChunkDelete($filename, $uuid);

        unlink($finalPath);
        return [
            'status' => 'error',
            'message' => 'Storage provider not found or not S3.'
        ];
    }
}


function fileChunkDelete($filename, $uuid)
{

    $uploadDir = storage_path("app/public/uploads");
    $chunkDir = storage_path("app/chunks/{$uuid}");
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $finalPath = "{$uploadDir}/{$filename}";

    if (!is_dir($chunkDir)) {
    }


    $chunks = collect(scandir($chunkDir))
        ->filter(fn($f) => str_ends_with($f, '.part'))
        ->sort()
        ->values();

    if ($chunks->isEmpty()) {
    }

    $output = fopen($finalPath, 'ab');

    foreach ($chunks as $chunk) {
        $chunkFile = "{$chunkDir}/{$chunk}";
        fwrite($output, file_get_contents($chunkFile));
        unlink($chunkFile);
    }

    fclose($output);
    rmdir($chunkDir);

    return $finalPath;
}


function awsUploader($tempPath, $fileName, $imageWatermarkSize)
{
    //main image Upload S3
    $upload = Storage::disk('s3')->put($fileName, fopen($tempPath, 'r+'));

    // make watermark image
    $watermark = explode('x', $imageWatermarkSize); // [width, height]
    $watermarkImage = Image::make(getFilePath('others') . '/' . 'watermark.png')->resize(180, 80);

    // Resize the main image to watermark image
    $uploadWaterMarkDir = storage_path("app/public/uploads/watermark");
    if (!is_dir($uploadWaterMarkDir)) {
        mkdir($uploadWaterMarkDir, 0777, true);
    }

    $tempWatermarkedImagePath = $uploadWaterMarkDir . '/watermark_' . $fileName;
    Image::make($tempPath)
        ->resize($watermark[0], $watermark[1])
        ->insert($watermarkImage, 'center')
        ->save($tempWatermarkedImagePath);  //store tempory file

    // watermark image Upload S3
    $watermarkUpload = Storage::disk('s3')->put('watermark_' . $fileName, fopen($tempWatermarkedImagePath, 'r+'));

    if ($watermarkUpload) {
        unlink($tempWatermarkedImagePath);
    }

    //    // make thumb image 
    // $imageThumbSize = getFileThumbSize('listing_asset_image');
    // $size = explode('x', strtolower($imageThumbSize)); // [width, height]


    // $uploadThumbDir = storage_path("app/public/uploads/thumb");
    // if (!is_dir($uploadThumbDir)) {
    //     mkdir($uploadThumbDir, 0777, true);
    // }
    // $tempThumbImagePath = $uploadThumbDir . '/thumb_' . $fileName;
    // Image::make($tempPath)->resize($size[0], $size[1])->save($tempThumbImagePath);  //store tempory file

    // //thumb image Upload S3
    // $thumbUpload = Storage::disk('s3')->put('thumb_' . $fileName, fopen($tempThumbImagePath, 'r+'));


    // if ($thumbUpload) {
    //     unlink($tempThumbImagePath);
    // }


    if ($upload) {
        // $url = Storage::disk('s3')->url($fileName);
        return [
            'success' => true,
            'message' => 'File uploaded successfully!',
            'filename' => $fileName
        ];
    } else {
        return [
            'success' => false,
            'message' => 'File upload failed.'
        ];
    }
}


function localUploader($sourcePath, $newPath, $fileName, $imageWatermarkSize, $watermarkDir)
{

    $fileContent = file_get_contents($sourcePath);
    file_put_contents($newPath, $fileContent);


    // // make thumb image 
    // $imageThumbSize = getFileThumbSize('listing_asset_image');
    // $size = explode('x', strtolower($imageThumbSize));
    // Image::make($newPath)->resize($size[0], $size[1])->save($newDir . '/thumb_' . $newFileName);


    // make watermark
    $watermark = explode('x', $imageWatermarkSize);
    $watermarkImage = Image::make(getFilePath('others') . '/' . 'watermark.png')->resize(180, 80);

    // Resize the main image to watermark image
    $mainImage = Image::make($newPath)->resize($watermark[0], $watermark[1]);

    if (!is_dir($watermarkDir)) {
        mkdir($watermarkDir, 0777, true);
    }

    $mainImage->insert($watermarkImage, 'center')->save($watermarkDir . '/watermark_' . $fileName);

    unlink($sourcePath);

    // $url = Storage::disk('s3')->url($fileName);
    return [
        'success' => true,
        'message' => 'File uploaded successfully!',
        'filename' => $fileName
    ];
}


function findMainImagePath($data, $dir)
{

    $storageProvider = StorageProvider::where('status', 1)->first();
    if ($data->storage == 's3') {
        return $storageProvider->credentials->url . '/' . $data->image;
    } else {
        return getImage($dir . '/' . $data->image);
    }
}

function findWatermarkImagePath($dir, $data, $image)
{

    $storageProvider = StorageProvider::where('status', 1)->first();
    $data = (object) $data;
    if ($data->storage == 's3') {
        return $storageProvider->credentials->url . '/watermark_' . $image;
    } else {
        return getImage($dir . '/watermark_' . $image);
    }
}

if (!function_exists('findWatermarkOrMainImagePath')) {
    function findWatermarkOrMainImagePath($data, $type)
    {
        $storageProvider = StorageProvider::where('status', 1)->first();
        $data = (object) $data;
        if ($data->storage == 's3') {
            $filePath = '/watermark_' . $data->image;
            $s3 = Storage::disk('s3');
            if ($s3->exists($filePath)) {
                return $storageProvider->credentials->url . $filePath;
            }

            return $storageProvider->credentials->url . $data->image;
        }

        $watermarkImagePath = getFilePath($type . '_watermark') . '/watermark_' . $data->image;
        $mainImagePath = getFilePath($type) . '/' . $data->image;

        if (file_exists($watermarkImagePath) && is_file($watermarkImagePath)) {
            return asset($watermarkImagePath);
        }

        if (file_exists($mainImagePath) && is_file($mainImagePath)) {
            return asset($mainImagePath);
        }

        return asset('assets/images/general/default.png');
    }
}

if (!function_exists('building_route_params')) {
    function building_route_params($building)
    {
        return [
            'county' => slug($building->neighborhood->county->name),
            'neighborhood' => slug($building->neighborhood->name),
            'slug' => slug($building->name),
            'id' => $building->id,
        ];
    }
}

if (!function_exists('building_listing_unit_route_params')) {
    function building_listing_unit_route_params($listingUnit)
    {
        return [
            'county' => slug($listingUnit->building->neighborhood->county->name),
            'neighborhood' => slug($listingUnit->building->neighborhood->name),
            'slug' => slug($listingUnit->building->name),
            'id' => $listingUnit->building->id,
        ];
    }
}
if (!function_exists('listing_unit_route_params')) {
    function listing_unit_route_params($listingUnit)
    {

        return [
            'county' => slug($listingUnit->building->neighborhood->county->name),
            'neighborhood' => slug($listingUnit->building->neighborhood->name),
            'slug' => slug($listingUnit->building->name),
            'unit' => slug($listingUnit->unit_number),
            'id' => $listingUnit->id,
        ];
    }
}

if (!function_exists('baseUrl')) {
    /**
     * Generate URL with BASE_URL prefix support
     * Works both for local (localhost) and production (with /staging/ prefix)
     */
    function baseUrl($path = '')
    {
        $baseUrl = env('BASE_URL');
        if (empty($baseUrl)) {
            // Se BASE_URL não estiver definida, usa a URL da aplicação normal
            return url($path);
        }

        if (is_null($path)) {
            $path = '';
        }

        $stringPath = (string) $path;

        // Se já for uma URL completa, retorna como está
        if (preg_match('#^https?://#i', $stringPath)) {
            return $stringPath;
        }

        $cleanBaseUrl = rtrim($baseUrl, '/');
        $cleanPath = ltrim($stringPath, '/');

        // Separa query string e fragmentos para tratarmos apenas o path
        $fragment = '';
        if (($hashPos = strpos($cleanPath, '#')) !== false) {
            $fragment = substr($cleanPath, $hashPos);
            $cleanPath = substr($cleanPath, 0, $hashPos);
        }

        $query = '';
        if (($queryPos = strpos($cleanPath, '?')) !== false) {
            $query = substr($cleanPath, $queryPos);
            $cleanPath = substr($cleanPath, 0, $queryPos);
        }

        // Remove prefixo duplicado (ex.: staging/staging)
        $basePath = trim(parse_url($cleanBaseUrl, PHP_URL_PATH) ?? '', '/');
        if ($basePath !== '') {
            if ($cleanPath === $basePath) {
                $cleanPath = '';
            } elseif (strpos($cleanPath, $basePath . '/') === 0) {
                $cleanPath = substr($cleanPath, strlen($basePath) + 1);
            }
        }

        $rebuilt = $cleanBaseUrl . ($cleanPath !== '' ? '/' . $cleanPath : '');

        return $rebuilt . $query . $fragment;
    }
}

if (!function_exists('baseRoute')) {
    /**
     * Generate route URL with BASE_URL prefix support
     */
    function baseRoute($name, $parameters = [])
    {
        $baseUrl = env('BASE_URL');
        if (empty($baseUrl)) {
            // Se BASE_URL não estiver definida, usa route normal
            return route($name, $parameters);
        }

        // Gera a rota relativa
        $routeUrl = route($name, $parameters);
        $parsedUrl = parse_url($routeUrl);
        $path = $parsedUrl['path'] ?? '';
        $query = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
        $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';

        // Remove o prefixo da APP_URL se presente
        $appUrl = env('APP_URL', 'http://localhost');
        $appParsedUrl = parse_url($appUrl);
        $appPath = $appParsedUrl['path'] ?? '';
        if ($appPath && strpos($path, $appPath) === 0) {
            $path = substr($path, strlen($appPath));
        }

        // Remove prefixo duplicado diretamente aqui também
        $basePath = trim(parse_url($baseUrl, PHP_URL_PATH) ?? '', '/');
        $relativePath = ltrim($path, '/');
        if ($basePath !== '') {
            if ($relativePath === $basePath) {
                $relativePath = '';
            } elseif (strpos($relativePath, $basePath . '/') === 0) {
                $relativePath = substr($relativePath, strlen($basePath) + 1);
            }
        }

        return baseUrl($relativePath . $query . $fragment);
    }
}

if (!function_exists('baseAsset')) {
    /**
     * Generate asset URL with BASE_URL prefix support
     */
    function baseAsset($path)
    {
        $baseUrl = env('BASE_URL');
        if (empty($baseUrl)) {
            // Se BASE_URL não estiver definida, usa asset normal
            return asset($path);
        }

        if (is_null($path)) {
            $path = '';
        }

        $stringPath = (string) $path;

        if (preg_match('#^https?://#i', $stringPath)) {
            return $stringPath;
        }

        $cleanBaseUrl = rtrim($baseUrl, '/');
        $cleanPath = ltrim($stringPath, '/');

        $basePath = trim(parse_url($cleanBaseUrl, PHP_URL_PATH) ?? '', '/');
        if ($basePath !== '') {
            if ($cleanPath === $basePath) {
                $cleanPath = '';
            } elseif (strpos($cleanPath, $basePath . '/') === 0) {
                $cleanPath = substr($cleanPath, strlen($basePath) + 1);
            }
        }

        return $cleanBaseUrl . ($cleanPath !== '' ? '/' . $cleanPath : '');
    }
}




