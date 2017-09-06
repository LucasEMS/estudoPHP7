<?php
$plainText = 'Super Secret Credentials';
$method = 'aes-256-xts';
$key = random_bytes(16);
$iv  = random_bytes(16);

echo $cipherText = openssl_encrypt($plainText, $method, $key, 0, $iv);
echo PHP_EOL;
echo $cipherText = base64_encode($cipherText);
echo PHP_EOL;
echo $plainText = openssl_decrypt(base64_decode($cipherText), 
        $method, $key, 0, $iv);