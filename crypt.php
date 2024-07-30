<?php

function ssl_crypt($data)
{
    $method = 'aes-128-cbc';
    $ivLength = openssl_cipher_iv_length($method);
    $iv = openssl_random_pseudo_bytes($ivLength);
    $token = openssl_encrypt($data, $method, 'scubaphp', 0, $iv);
    return $token;
}
function ssl_decrypt($token)
{
    return openssl_decrypt($token, 'aes-128-cbc-hmac-sha256', 'scubaphp');
}