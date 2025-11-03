<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$assoc = getPageSections(true);
echo is_array($assoc) ? ('ARRAY '.count($assoc)."\n") : ('TYPE '.gettype($assoc)."\n");
foreach ($assoc as $k=>$v) { echo $k."\n"; }
