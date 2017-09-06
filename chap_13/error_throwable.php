<?php
require __DIR__ . '/../../Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__ . '/../..');

use Application\Error\ { Handler, ThrowsError };

$error = new ThrowsError();

//$error->divideByZero();
//$error->willNotParse();
//echo 'Application continues ... ' . PHP_EOL;

try {
    $error->divideByZero();
} catch (Throwable $ex) {
    echo 'Error Caught: ' . get_class($ex) . ':' .
            $ex->getMessage() . PHP_EOL;
}

try {
    $error->willNotParse();
} catch (Throwable $ex) {
    echo 'Error Caught: ' . get_class($ex) . ':' .
            $ex->getMessage() . PHP_EOL;
}

$handler = new Handler(__DIR__ . '/logs');
$error->divideByZero();
$error->willNotParse();
echo 'Application continues ... ' . PHP_EOL;


