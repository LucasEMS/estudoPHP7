<?php
// demonstrate ways stdClass is used

define('DB_CONFIG_FILE', '/../data/config/db.config.php');

// demonstrates simple usage of stdClass
$obj = new stdClass();
$obj->test = 'TEST';
echo $obj->test;
echo PHP_EOL;

// demonstrates a return value of stdClass form a PDO database query

// set up database connection
include(__DIR__ . '/../../Application/Database/Connection.php');
$connection = new Application\Database\Connection(
        include __DIR__ . DB_CONFIG_FILE);

// PDO query which outputs instances of stdClass
$sql    = 'SELECT * FROM iso_country_codes';
$stmt   = $connection->pdo->query($sql);
$row    = $stmt->fetch(PDO::FETCH_OBJ);
var_dump($row);