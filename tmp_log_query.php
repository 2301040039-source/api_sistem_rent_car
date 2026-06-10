<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$log = App\Models\LogModel::orderBy('log_id','desc')->first();
if (!$log) {
    echo "No log entry found\n";
    exit(0);
}
echo "URL: {$log->log_url}\n";
echo "Method: {$log->log_method}\n";
echo "Request: {$log->log_request}\n";
echo "Response: {$log->log_response}\n";
