<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$jsonUrl = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections/builder/builder.json';
echo "jsonUrl=", $jsonUrl, "\n";
echo file_exists($jsonUrl) ? "exists\n" : "missing\n";
