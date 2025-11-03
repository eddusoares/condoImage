<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Frontend;

$key = 'top_categories.content';
$defaults = [
  'heading' => 'Stand out with better visuals',
  'subheading_primary' => 'Discover premium images crafted for real estate professionals. From drone shots to interiors and floor plans — all organized by building and neighborhood.',
  'subheading_secondary' => 'Stand out from the competition with stunning, ready‑to‑use visuals.',
  'button_text' => 'Explore all buildings',
  'button_link' => route('condo.building'),
];

$rec = Frontend::where('data_keys', $key)->orderBy('id','desc')->first();
if (!$rec) {
  $rec = new Frontend();
  $rec->data_keys = $key;
  $rec->data_values = (object) $defaults;
  $rec->save();
  echo "CREATED top_categories.content\n";
} else {
  $dv = (array)$rec->data_values;
  $changed = false;
  foreach ($defaults as $k=>$v) { if (!array_key_exists($k,$dv)) { $dv[$k] = $v; $changed = true; } }
  if ($changed) { $rec->data_values = (object)$dv; $rec->save(); echo "UPDATED data_values\n"; } else { echo "EXISTS with fields\n"; }
}
