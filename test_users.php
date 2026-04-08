<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = App\Models\Order::whereIn('status', ['confirmed', 'shipped', 'completed'])->with('user')->get();
foreach($orders as $o) {
    if ($o->status == 'cancelled') continue;
    echo 'Order ' . $o->id . ': User ' . $o->user_id . ' (' . $o->user->role . ') Total=' . $o->total . PHP_EOL;
}
