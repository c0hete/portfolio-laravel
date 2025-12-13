<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing HubEventReporter...\n\n";

$hub = app(\App\Services\HubEventReporter::class);

echo "1. Testing AppRegistered event:\n";
$hub->reportAppRegistered('1.0.0-test', 'local');

echo "\n2. Testing PageView event:\n";
$hub->reportPageView('/test-page', 'Mozilla/5.0', 'https://google.com');

echo "\n3. Testing ContactFormSubmitted event:\n";
$hub->reportContactFormSubmitted('test@example.com', 'Test Subject');

echo "\n✅ All tests completed!\n";
echo "Check storage/logs/laravel.log for [HUB] log entries.\n";
