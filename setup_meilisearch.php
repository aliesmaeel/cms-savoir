<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$client = new \Meilisearch\Client($_ENV['MEILISEARCH_HOST'], $_ENV['MEILISEARCH_KEY']);
$index = $client->index('new_properties');

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

echo "✅ Meilisearch attributes updated successfully.\n";
