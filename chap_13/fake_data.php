<?php
define('DB_CONFIG_FILE', __DIR__ . '/../config/db.config.php');
define('FIRST_NAME_FILE', __DIR__ . '/../data/file/first_names.txt');
define('LAST_NAME_FILE', __DIR__ . '/../data/file/surnames.txt');
require __DIR__ . '/../../Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__ . '/../..');
use Application\Test\FakeData;
use Application\Database\Connection;

$mapping = [
    'first_name'    => ['source' => FakeData::SOURCE_FILE,
        'name'          => FIRST_NAME_FILE,
        'type'          => FakeData::FILE_TYPE_TXT],
    'last_name'     => ['source' => FakeData::SOUCE_FILE,
        'name'          => LAST_NAME_FILE,
        'type'          => FakeData::FILE_TYPE_TXT],
]

