<?php
require 'vendor/autoload.php';

use Elastic\Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->setHosts(['localhost:9200'])->build();

$params = [
    "scroll" => "1m", // how long between scroll requests
    "size" => 500,    // how many results *per shard* you want back
    "index" => "new_index",
    "body" => [
        "query" => [
            "match_all" => new \stdClass()
        ]
    ]
];

// Execute the search
$response = $client->search($params);

// Get the first scroll_id
$scroll_id = $response['_scroll_id'];

// Hold all the documents
$allDocuments = [];

// Loop until all the documents are fetched
do {
    foreach ($response['hits']['hits'] as $doc) {
        $allDocuments[] = $doc['_source'];
    }

    // Execute a Scroll request and repeat
    $response = $client->scroll([
            "scroll_id" => $scroll_id,  //...using our previously obtained _scroll_id
            "scroll" => "1m"           // and the same timeout window
        ]
    );

    // Check if we got any results from the scroll request
    if(count($response['hits']['hits']) > 0){
        // If yes, update the scroll_id
        $scroll_id = $response['_scroll_id'];
    }else{
        // No results, set the scroll_id to null to terminate the loop
        $scroll_id = null;
    }

} while ($scroll_id);

// Write the documents to a json file
file_put_contents('output.json', json_encode($allDocuments));

echo "Done.\n";
?>
