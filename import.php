<?php
require 'vendor/autoload.php';

use Elastic\Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->setHosts(['localhost:9200'])->build();
$index_name = 'nation_info';

$indexParams = [
  'index' => $index_name,
  'body' => [
    'settings' => [
      'number_of_shards' => 1,
      'number_of_replicas' => 0
    ],
    'mappings' => [
      'properties' => [
        'title' => [
          'type' => 'text'
        ],
        'content' => [
          'type' => 'text'
        ]
      ]
    ]
  ]
];

$response = $client->indices()->create($indexParams);

echo "Index created.\n";


// Read the json file
$json = file_get_contents('output.json');

// Decode the json to an array
$data = json_decode($json, true);

$params = ['body' => []];

foreach ($data as $id => $doc) {
    $params['body'][] = [
        'index' => [
            '_index' => $index_name,
            '_id'    => $id
        ]
    ];

    $params['body'][] = $doc;

    // Every 1000 documents stop and send the bulk request
    if ($id % 1000 == 0) {
        $responses = $client->bulk($params);

        // erase the old bulk request
        $params = ['body' => []];

        // unset the bulk response when you are done to save memory
        unset($responses);
    }
}

// Send the last batch if it exists
if (!empty($params['body'])) {
    $responses = $client->bulk($params);
}

echo "Done.\n";
?>

?>
