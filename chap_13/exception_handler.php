<?php
define('DB_CONFIG_FILE', __DIR__ . '/../data/config/db.config.php');

$config = include DB_CONFIG_FILE;

require __DIR__ . '/../../Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__ . '/../..');

use Application\Error\ { Handler, ThrowsException };

//$throws1 = new ThrowsException($config);

$handler = new Handler(__DIR__ . '/logs');
try {
    $throws1 = new ThrowsException($config);
} catch (Exception $ex) {
    echo 'Exception Caught: ' . get_class($ex) . ':' . $ex->getMessage()
            . PHP_EOL;
}
$throws1 = new ThrowsException($config);
echo 'Application Continues ...' . PHP_EOL;