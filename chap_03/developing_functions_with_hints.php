<?php
// developing functions -- type hints

// it's a best practice to place all functions definitons
// in a separate file whice is then included
include (__DIR__ . DIRECTORY_SEPARATOR . 'developing_functions_type_hints_library.php');

// executes someTypeHint()
echo "\nsomeTypeHint()\n";
try {
    $callable = function () { return 'Callback Return'; };
    echo someTypeHint([1,2,3], new DateTime(), $callable);
    // cause a TypeError to be thorwn
    echo someTypeHint('A', 'B', 'C');
} catch (TypeError $e) {
    echo $e->getMessage();
    echo PHP_EOL;
}

// executes someScalarHint()
echo "\nsomeScalarHint()\n";
try {
    echo someScalarHint(TRUE, 11, 22.22, 'This is a string');
    // causes a TypeError to be thown
    echo someScalarHint('A', 'B', 'C', 'D');
} catch (TypeError $e) {
    echo $e->getMessage();
    echo PHP_EOL;
}

// executes someBooleanHint() with values which convert to TRUE or FALSE
echo "\nsomeBooleanHint()\n";
try {
    // boolean type hinting doesn't thow TypeError if you pass in any scalar
    // positive results
    $b = someBooleanHint(TRUE);
    $i = someBooleanHint(1);
    $f = someBooleanHint(22.22);
    $s = someBooleanHint('X');
    var_dump($b, $i, $f, $s);
    echo PHP_EOL;
    // negative results
    $b = someBooleanHint(FALSE);
    $i = someBooleanHint(0);
    $f = someBooleanHint(0.0);
    $s = someBooleanHint('');
    var_dump($b, $i, $f, $s);
    echo PHP_EOL;
} catch (TypeError $e) {
    echo $e->getMessage();
}

// executes someBooleanHint() catches TypeError
echo "\nsomeBooleanHint()\n";
try {
    // boolean type hinting will throw TypeError if you pass in other data typw
    $a = someBooleanHint([1, 2, 3]);
    var_dump($a);
    echo PHP_EOL;
} catch (TypeError $e) {
    echo $e->getMessage();
}

try {
    $o = someBooleanHint(new stdClass());
    var_dump($o);
    echo PHP_EOL;
} catch (TypeError $e) {
    echo $e->getMessage();
}