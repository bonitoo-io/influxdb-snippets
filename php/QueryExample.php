<?php

require __DIR__ . '/../vendor/autoload.php';

use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;

$client = new Client([
    "url" => "https://us-west-2-1.aws.cloud2.influxdata.com",
    "token" => "my-token",
    "org" => "my-org",
    "precision" => WritePrecision::S
]);

$queryApi = $client->createQueryApi();
$result = $queryApi->query('from(bucket: "my-bucket") |> range(start: -1d)');

foreach ($result as $table) {
    foreach ($table->records as $record) {
        $measurement = $record->getMeasurement();
        $field = $record->getField();
        $time = $record->getTime();
        $value = $record->getValue();
        print "$time $measurement: $field=$value\n";
    }
}

$client->close();
