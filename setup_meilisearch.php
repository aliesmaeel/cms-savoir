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
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new Client(getenv('MEILISEARCH_HOST'), getenv('MEILISEARCH_KEY'));
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
        'country'=> $p->country,
    ];
})->toArray();

// Add documents to Meilisearch
$index->addDocuments($documents);

echo "✅ Meilisearch reindex complete.\n";


$index = $client->index('off_plan_projects');

$index->updateFilterableAttributes([
    'developer',
    'completion_date',
    'link',
    'price'
]);

$index->updateSortableAttributes([
    'updated_at',
    'title'
]);

$index->addDocuments(
    \App\Models\OffPlanProject::all()->map(function ($p) {
        return [
            'id' => $p->id,
            'title' => $p->title,
            'link' => $p->link,
            'image'=> $p->image,
            'location' => $p->location,
            'developer' => $p->developer,
            'completion_date' => $p->completion_date,
            'price' => $p->starting_price,
            'updated_at' => $p->updated_at->toIso8601String(),
        ];
    })->toArray()
);
