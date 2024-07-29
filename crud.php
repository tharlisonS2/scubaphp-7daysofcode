<?php

function crud_create($user)
{
    $dados = file_get_contents(DATA_LOCATION);
    $dados = json_decode($dados);
    $dados[] = $user;
    $dados = json_encode($dados);
    file_put_contents(DATA_LOCATION, $dados);
}
function checkEmail($email)
{
    $dados = file_get_contents(DATA_LOCATION);
    $dados = json_decode($dados);
    foreach ($dados[0] as $data) {
        if ($email == $data) {
            return $email;
        }
    }
    return false;
}
