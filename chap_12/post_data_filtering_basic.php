<?php

$filter = [
    'trim' => function ($item) { return trim($item); },
    'float' => function ($item) { return (float) $item; },
    'upper' => function ($item) { return strtoupper($item); },
    'email' => function ($item) { 
        return filter_var($item, FILTER_SANITIZE_EMAIL); },
    'alpha' => function ($item) {
        return preg_replace('/[^A-Za-z]/', '', $item); },
    'alnum' => function ($item) {
        return preg_replace('/[^0-9A-Za-z]/', '', $item); },
    'length' => function ($item, $length) {
        return substr($item, 0, $length); },
    'stripTags' => function ($item) { return strip_tags($item); },
];

$assignments = [
    '*'             => ['trim' => NULL, 'stripTags' => NULL],
    'first_name'    => ['length' => 32, 'alnum' => NULL],
    'last_name'     => ['length' => 32, 'alnum' => NULL],
    'address'       => ['length' => 64, 'alnum' => NULL],
    'city'          => ['length' => 32],
    'state_province'=> ['length' => 20],
    'postal_code'   => ['length' => 12, 'alnum' => NULL],
    'phone'         => ['length' => 12],
    'country'       => ['length' => 2, 'alpha' => NULL, 
        'upper' => NULL],
    'email'         => ['length' => 128, 'email' => NULL],
    'budget'        => ['float' => NULL],
];
    

$testData = [
    'goodData'  => [
        'first_name'    => 'Doug',
        'last_name'     => 'Bierer',
        'address'       => '123 Main Street',
        'city'          => 'San Francisco',
        'state_province'=> 'California',
        'postal_code'   => '94101',
        'phone'         => '+ 415-555-1212',
        'country'       => 'US',
        'email'         => 'doug@unlikelysource.com',
        'budget'        => '123.45'
        ],
    'badData' => [
        'first_name'    => 'This+Name<script>bad tag</script>Valid!',
        'last_name'     => 'ThisLastNameIsWayTooLongAbcdefghijklmnopqrstuvxyz0123456890'
        . 'Abcdefghijklmnopqrstuvxyz0123456890Abcdefghijklmnopqrstuvxyz0123456890'
        . 'Abcdefghijklmnopqrstuvxyz0123456890',
        //'address'       => '', // missing
        'city'          => 'ThisLastNameIsWayTooLongAbcdefghijklmnopqrstuvxyz0123456890',
        //'state_province'=> 'California', // missing
        'postal_code'   => '!"£%^Non Alpha Chars',
        'phone'         => '12345',
        'country'       => '12345',
        'email'         => 'this.is@not@an.email',
        'budget'        => 'XXX'
    ],
    ];
    
foreach ($testData As $data) {
    foreach ($data As $field => $item) {
        foreach ($assignments['*'] as $key => $option) {
            $item = $filter[$key] ($item, $option);
        }
        
        foreach ($assignments[$field] as $key => $option) {
            $item = $filter[$key]($item, $option);
        }
        
        printf("%16s : %s\n", $field, $item);
    }
    echo PHP_EOL;
}