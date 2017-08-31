<?php
$validator = [
    'email' => [
        'callback' => function ($item) {
        return filter_var($item, FILTER_VALIDATE_EMAIL); },
        'message' => 'Invalid email address'],
    'alpha' => [ 
        'callback' => function ($item) {
        return ctype_alpha(str_replace(' ', '', $item)); },
        'message' => 'Data contains non-alpha characters'],
    'alnum' => [
        'callback' => function ($item) {
        return ctype_alnum(str_replace(' ', '', $item)); },
        'message' => 'Data contains characters which are '
                . 'not letters or numbers'],
    'digits' => [
        'callback' => function ($item) {
        return preg_match('/[^0-9.]/', $item); },
        'message' => 'Data contains characters which '
                . 'are not numbers'],
    'length' => [
        'callback' => function ($item, $length) {
        return strlen($item) <= $length; },
        'message' => 'Item has too many characters'],
    'upper' => [
        'callback' => function ($item) {
        return $item == strtoupper($item); },
        'message' => 'Item is not upper case'],
    'phone' => [
        'callback' => function ($item) {
        return preg_match('/[^0-9() -+]/', $item); },
        'message' => 'Item is not a valid phone number'],
];
        
$assignments = [
    'first_name'    => ['length' => 32, 'alnum' => NULL],
    'last_name'     => ['length' => 32, 'alnum' => NULL],
    'address'       => ['length' => 64, 'alnum' => NULL],
    'city'          => ['length' => 32, 'alnum' => NULL],
    'state_province'=> ['length' => 20, 'alpha' => NULL],
    'postal_code'   => ['length' => 12, 'alnum' => NULL],
    'phone'         => ['length' => 12, 'phone' => NULL],
    'country'       => ['length' => 2, 'alpha' => NULL, 
        'upper' => NULL],
    'email'         => ['length' => 128, 'email' => NULL],
    'budget'        => ['digits' => NULL],
];
    

$goodData  = [
        'first_name'    => 'Doug',
        'last_name'     => 'Bierer',
        'address'       => '123 Main Street',
        'city'          => 'San Francisco',
        'state_province'=> 'California',
        'postal_code'   => '94101',
        'phone'         => '+ 415-555-1212',
        'country'       => 'US',
        'email'         => 'doug@unlikelysource.com',
        'budget'        => '123,45'
        ];
$badData = [
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
    ];

foreach ($goodData as $field => $item) {
    echo 'Processing: ' . $field . PHP_EOL;
    foreach ($assignments[$field] as $key => $option) {
        if ($validator[$key]['callback'] ($item, $option)) {
            $message = 'OK';
        } else {
           $message = $validator[$key]['message'];
        }
        printf('%8s : %s' . PHP_EOL, $key, $message);
    }
}
echo PHP_EOL;

foreach ($badData as $field => $item) {
    echo 'Processing: ' . $field . PHP_EOL;
    foreach ($assignments[$field] as $key => $option) {
        if ($validator[$key]['callback'] ($item, $option)) {
            $message = 'OK';
        } else {
           $message = $validator[$key]['message'];
        }
        printf('%8s : %s' . PHP_EOL, $key, $message);
    }
}