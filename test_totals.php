<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$orders = App\Models\Order::whereIn('status', ['confirmed', 'shipped', 'completed'])->with('items')->get();
$sumItems = 0;
$sumOrders = 0;
foreach($orders as $o) {
    if ($o->status == 'cancelled') continue;
    $sumOrders += $o->total;
    $itemsTotal = $o->items->sum('subtotal');
    $sumItems += $itemsTotal;
    echo 'Order ' . $o->id . ': Total=' . $o->total . ' Items=' . $itemsTotal . PHP_EOL;
}
echo 'Total Orders: ' . $sumOrders . ' Total Items: ' . $sumItems . PHP_EOL;
