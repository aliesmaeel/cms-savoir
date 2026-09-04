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
    'city',
    'country',
    'community',
    'sub_community',
    'community_name',
    'sub_community_name',
]);

$index->updateSortableAttributes([
    'price',
    'updated_at',
    'title_en',
]);

// Fetch all properties
$allProperties = NewProperty::with(['pcommunity:id,name', 'psubcommunity:id,name'])->get();
$dbPropertyCount = $allProperties->count();

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
        'community_name' => $p->pcommunity?->name,
        'sub_community_name' => $p->psubcommunity?->name,
        'country' => $p->country,
    ];
})->toArray();

echo "MySQL properties: {$dbPropertyCount}\n";
echo "Indexing " . count($documents) . " property documents...\n";

// Add documents to Meilisearch (async) and wait until searchable
$propertyTask = $index->addDocuments($documents);
$client->waitForTask($propertyTask['taskUid'], 120000);

$propertyStats = $index->stats();
$indexedPropertyCount = $propertyStats['numberOfDocuments'] ?? 0;

echo "✅ Properties reindex complete.\n";
echo "Indexed properties (Meilisearch): {$indexedPropertyCount}\n";


$offPlanIndex = $client->index('off_plan_projects');

$offPlanIndex->updateFilterableAttributes([
    'developer',
    'completion_date',
    'link',
    'price'
]);

$offPlanIndex->updateSortableAttributes([
    'updated_at',
    'title'
]);

$offPlanProjects = \App\Models\OffPlanProject::all();
$dbOffPlanCount = $offPlanProjects->count();
$offPlanDocuments = $offPlanProjects->map(function ($p) {
    return [
        'id' => $p->id,
        'title' => $p->title,
        'link' => $p->link,
        'image' => $p->image,
        'location' => $p->location,
        'developer' => $p->developer,
        'completion_date' => $p->completion_date,
        'starting_price' => $p->starting_price,
        'updated_at' => $p->updated_at->toIso8601String(),
    ];
})->toArray();

echo "MySQL off-plan projects: {$dbOffPlanCount}\n";
echo "Indexing " . count($offPlanDocuments) . " off-plan documents...\n";

$offPlanTask = $offPlanIndex->addDocuments($offPlanDocuments);
$client->waitForTask($offPlanTask['taskUid'], 120000);

$offPlanStats = $offPlanIndex->stats();
$indexedOffPlanCount = $offPlanStats['numberOfDocuments'] ?? 0;

echo "✅ Off-plan reindex complete.\n";
echo "Indexed off-plan projects (Meilisearch): {$indexedOffPlanCount}\n";
echo "✅ Meilisearch reindex complete.\n";
