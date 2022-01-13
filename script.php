<?php

require_once("vendor/autoload.php");

use App\App;

$app = new App($argv);
$response = $app->start();
if (gettype($response) === 'integer') exit('Program exited with code ' . $response);
$chars = array_slice($response, 2);
echo 'File: ' . $response['file'] . PHP_EOL;
foreach ($chars as $key => $value)
{
    echo 'First ' . $response['format'] . ' ' . $key . ': ' . $value . PHP_EOL;
}
