<?php
$key = 'c5710a1f4104edb233cebb4d2d5e6ec7';

function encryptData($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    $iv_base64 = base64_encode($iv);
    $encrypted_base64 = base64_encode($encrypted);
    return $iv_base64 . $encrypted_base64;
}

function decryptData($data, $key) {
    $iv_base64 = substr($data, 0, 24); // Assuming IV length of 16 bytes base64 encoded
    $encrypted_base64 = substr($data, 24); // Assuming IV length of 16 bytes base64 encoded
    $iv = base64_decode($iv_base64);
    $encrypted = base64_decode($encrypted_base64);
    return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
}
?>