<?php
// demonstrates a PDO connection "factory"

include __DIR__ . '/../../Application/Database/Connection.php';
use Application\Database\Connection;

$connection = Connection::factory(
        'mysql', 'php7cookbook', 'localhost', 'cook', 'book');
$stms = $connection->query('SELECT name FROM iso_country_codes');
while ($country = $stms->fetch(PDO::FETCH_COLUMN))
        echo $country . ' ';