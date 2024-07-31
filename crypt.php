<?php

function ssl_crypt($data)
{
    $method = 'aes-128-cbc';
    $ivLength = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivLength);
    $encryptedData = openssl_encrypt($data, $method, 'scubaphp', 0, $iv);
    $token = base64_encode($iv . $encryptedData);
    return $token;
}
function ssl_decrypt($token)
{
    return openssl_decrypt($token, 'aes-128-cbc-hmac-sha256', 'scubaphp');
}