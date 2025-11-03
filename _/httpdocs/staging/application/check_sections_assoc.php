<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$assoc = getPageSections(true);
var_dump(is_array($assoc), count($assoc));
