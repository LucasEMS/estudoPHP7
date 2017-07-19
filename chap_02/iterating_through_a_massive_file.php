<?php

define('MASSIVE_FILE', '/../data/files/war_and_peace.txt');
require __DIR__ . '/../../Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__ . '/../..');

try {
    $largeFile = new Application\Iterator\LargeFile(__DIR__ . MASSIVE_FILE);
    $iterator = $largeFile->getIterator('ByLine');
    $words = 0;
    foreach ($iterator as $line) {
        echo $line;
        $words += str_word_count($line);
    }
    echo str_repeat('-', 52) . PHP_EOL;
    printf("%-40s : %8d\n", 'Total Words', $words);
    printf("%-40s : %8d\n", 'Average Words per Line', 
            ($words / $iterator->getReturn()));
    echo str_repeat('-', 52) . PHP_EOL;
} catch (Throwable $e) {
    echo $e->getMessage;
}