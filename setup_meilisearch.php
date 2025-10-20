<?php

// Autoload
require __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Now you can use Eloquent & Scout
use App\Models\NewProperty;
use Meilisearch\Client;
use Carbon\Carbon;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Client($_ENV['MEILISEARCH_HOST'], $_ENV['MEILISEARCH_KEY']);
$index = $client->index('new_properties');

// Update Meilisearch attributes
$index->updateFilterableAttributes([
    'offering_type',
    'property_type',
    'completion_status',
    'bedroom',
    'bathroom',
    'price',
]);

$index->updateSortableAttributes([
    'price',
    'updated_at',
    'title_en',
]);

// Fetch all properties
$allProperties = NewProperty::all();

$documents = $allProperties->map(function ($p) {
    return [
        'id' => $p->id,
        'title_en' => $p->title_en,
        'price' => $p->price,
        'bedroom' => $p->bedroom,
        'bathroom' => $p->bathroom,
        'offering_type' => $p->offering_type,
        'completion_status' => $p->completion_status,
        'property_type' => $p->property_type,
        'updated_at' => $p->updated_at->toIso8601String(),
        'city' => $p->city,
        'community' => $p->community,
        'sub_community' => $p->sub_community,
    ];
})->toArray();

// Add documents to Meilisearch
$index->addDocuments($documents);

echo "✅ Meilisearch reindex complete.\n";
