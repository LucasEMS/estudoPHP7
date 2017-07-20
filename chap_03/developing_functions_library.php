<?php
// developing funcsions library

// it's a best practice to place all functions definitions a the top of
// the file any procedural code should go at the end

// single mandatory pram
function someName ($parameter)
{
    $result = 'INIT';
    // one or more statements which do something
    // to affect $result
    $result .= ' and also ' . $parameter;
    return $result;
}

// two params: one mandatory the other optional
function someOtherName ($requiredParam, $optionalParam = NULL)
{
    $result = 0;
    $result += $requiredParam;
    $result += $optionalParam ?? 0;
    return $result;
}

// infinet number of params
function someInfinite(...$params)
{
    // any params passed go into an array $params
    return var_export($params, TRUE);
}

// recursion
function someDirScan($dir)
{
    // uses "static" to retain value of $list
    static $list = array();
    // get a list of files and directories for this path
    $list = glob($dir . DIRECTORY_SEPARATOR . '*');
    // loop through
    foreach ($list as $item) {
        if (is_dir($item)) {
            $list = array_merge($list, someDirScan($item));
        }
    }
    return $list;
}

function someTypeHint(Array $a, DateTime $t, Callable $c)
{
    $message = '';
    $message .= 'Array Count : ' . count($a) . PHP_EOL;
    $message .= 'Date: ' . $t->format('Y-m-d') . PHP_EOL;
    $message .= 'Callable Return: ' . $c() . PHP_EOL;
    return $message;
}

