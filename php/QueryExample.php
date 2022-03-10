<?php

require __DIR__ . '/vendor/autoload.php';

use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;

$url =  "https://us-west-2-1.aws.cloud2.influxdata.com";
$token = "my-token";
$org = "my-org";
$bucket = "my-bucket";

$client = new Client(["url" => $url, "token" => $token, "org" => $org, "precision" => WritePrecision::S]);

$queryApi = $client->createQueryApi();
$query = "from(bucket: \"$bucket\") |> range(start: -1d)";
$result = $queryApi->query($query);

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
