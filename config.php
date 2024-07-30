<?php

$variaveis_envs = parse_ini_file('.env'); //carrega arquivo com variaveis ambiente
foreach ($variaveis_envs as $key => $value) { // $variaveis = 'INDICE' => 'valores'
    define($key, $value);                   // loop para definir todas as variavies como ambientes como constantes
}

define('SLASH', DIRECTORY_SEPARATOR);
define('VIEW_FOLDER', __DIR__ . SLASH . 'view' . SLASH);
define('DATA_LOCATION', __DIR__ . SLASH . 'data' . SLASH . 'users.json');