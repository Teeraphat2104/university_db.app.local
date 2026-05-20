<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$settings = App\Models\Setting::all();
$grouped = $settings->groupBy('group')->map(function($items) {
    return $items->map(function($s) {
        return ['id' => $s->id, 'key' => $s->key, 'value' => $s->value, 'type' => $s->type];
    })->values();
});
echo json_encode($grouped, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;
