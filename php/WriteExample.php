<?php

require __DIR__ . '/vendor/autoload.php';

use InfluxDB2\Client;
use InfluxDB2\Model\WritePrecision;
use InfluxDB2\Point;

$url = "https://us-west-2-1.aws.cloud2.influxdata.com";
$token = "my-token";
$org = "my-org";
$bucket = "my-bucket";

$client = new Client(["url" => $url, "token" => $token, "org" => $org,
    "bucket" => $bucket, "precision" => WritePrecision::S]);

$writeApi = $client->createWriteApi();

$point = Point::measurement("weatherstation")
    ->addTag("location", "San Francisco")
    ->addField("temperature", 25.1)
    ->time(time(), WritePrecision::S);

$writeApi->write($point);
$client->close();

