<?php

require __DIR__ . '/../vendor/autoload.php';

use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;

$client = new Client([
    "url" => "https://us-west-2-1.aws.cloud2.influxdata.com",
    "token" => "my-token",
    "bucket" => "my-bucket",
    "org" => "my-org",
    "precision" => WritePrecision::S
]);

$writeApi = $client->createWriteApi();

$point = Point::measurement("weatherstation")
    ->addTag("location", "San Francisco")
    ->addField("temperature", 25.1)
    ->time(time(), WritePrecision::S);

$writeApi->write($point);
$client->close();

