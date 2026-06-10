<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$user = App\Models\User::where('email', 'test@example.com')->first();
if (!$user) {
    echo "No user\n";
    exit(0);
}
echo "User: {$user->email} id={$user->id}\n";
try {
    $token = Tymon\JWTAuth\Facades\JWTAuth::fromUser($user);
    echo "Token: {$token}\n";
} catch (Exception $e) {
    echo "JWT error: " . $e->getMessage() . "\n";
}
