<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = App\Models\Order::all();
foreach($orders as $o) {
    $pp = $o->paymentProof;
    $ppStatus = $pp ? $pp->status : 'none';
    echo "ID: $o->id | Status: $o->status | Total: $o->total | Payment: $ppStatus\n";
}
