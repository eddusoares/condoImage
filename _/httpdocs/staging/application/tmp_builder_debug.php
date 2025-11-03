<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$path = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections/builder/builder.json';
$raw = file_get_contents($path);
try {
    json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
    echo "ok\n";
} catch (Throwable $e) {
    echo $e->getMessage(), "\n";
}
