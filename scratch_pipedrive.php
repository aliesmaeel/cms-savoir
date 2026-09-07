<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$token = env('PIPEDRIVE_TOKEN');
$apiUrl = 'https://api.pipedrive.com/v1/';

// Fetch one open deal to inspect structure
$response = \Illuminate\Support\Facades\Http::get("{$apiUrl}deals", [
    'api_token' => $token,
    'status' => 'open',
    'limit' => 1
]);

$deal = $response->json()['data'][0] ?? null;
file_put_contents(__DIR__ . '/storage/app/scratch_deal.json', json_encode($deal, JSON_PRETTY_PRINT));

// Fetch dealFields to inspect structure
$fieldsResponse = \Illuminate\Support\Facades\Http::get("{$apiUrl}dealFields", [
    'api_token' => $token
]);
$fields = $fieldsResponse->json()['data'] ?? [];
$targetFields = array_filter($fields, function($field) {
    return in_array($field['key'], [
        '1da5fc3b6713a605fa147077db49064ae9493df6', 
        'af1f61eb5b7dcb81884f97e42ea331041e44828e', 
        '8abbf4a2a68242278a05332544e8a1c795f7b513'
    ]);
});

file_put_contents(__DIR__ . '/storage/app/scratch_fields.json', json_encode(array_values($targetFields), JSON_PRETTY_PRINT));
echo "Done";
