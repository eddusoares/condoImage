<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$jsonUrl = resource_path('views/') . str_replace('.', '/', activeTemplate()) . 'sections/builder/builder.json';
$c = file_get_contents($jsonUrl);
$a = json_decode($c, true);
echo 'len='.strlen($c).' err='.json_last_error_msg().' type='.gettype($a).' count='.(is_array($a)?count($a):0)."\n";
print_r(array_keys((array)$a));
