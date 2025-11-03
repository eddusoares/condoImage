<?php
$app = require __DIR__.'/_/httpdocs/staging/application/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$u = App\Models\User::where('username','admin')->orWhere('email','admin')->first();
if ($u) {
    echo "FOUND: id={$u->id} email={$u->email} username={$u->username}\n";
} else {
    echo "NOT FOUND\n";
}
