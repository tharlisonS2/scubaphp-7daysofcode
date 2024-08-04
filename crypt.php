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
    $method = 'aes-128-cbc';
    $token = base64_decode($token);

    $ivLength = openssl_cipher_iv_length($method);
    $iv = substr($token, 0, $ivLength);
    $encryptedData = substr($token, $ivLength);
    $data = openssl_decrypt($encryptedData, $method, 'scubaphp', 0, $iv);
  
    return $data;
}
