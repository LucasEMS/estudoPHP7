<?php

define('DB_CONFIG_FILE', '/../data/config/db.config.php');
require __DIR__ . '/../../Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__ . '/../..');
use Application\Database\Connection;
use Application\Database\CustomerService;

// get service instance
$service = new CustomerService(new Connection(
        include __DIR__ . DB_CONFIG_FILE));

echo "\nSingle Result\n";
var_dump($service->fetchById(rand(1, 79)));

echo "\nMultiple Result\n";
printf('%4s | %20s | %5s' . PHP_EOL, 'ID', 'NAME', 'LEVEL');
printf('%4s | %20s | %5s' . PHP_EOL, '----', str_repeat('-', 20), '-----');
foreach ($service->fetchByLevel('ADV') as $cust) {
	printf('%4d | %20s | %5s' . PHP_EOL, $cust->getId(), $cust->getName(), $cust->getLevel());
}


