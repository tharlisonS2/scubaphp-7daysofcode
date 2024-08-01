<?php
include "config.php";
function crud_create($user)
{
    $dados = file_get_contents(DATA_LOCATION);
    $dados = json_decode($dados);
    $dados[] = $user;
    $dados = json_encode($dados);
    file_put_contents(DATA_LOCATION, $dados);
}
function crud_restore($email)
{
    $dados = file_get_contents(DATA_LOCATION);
    $dados = json_decode($dados);
    foreach ($dados as $data) {
        if ($email === $data->email) {
            return $email;
        }
    }
    return false;
}
function crud_update($email)
{
    $dados = file_get_contents(DATA_LOCATION);
    $dados = json_decode($dados);
    foreach ($dados as $data) {
        if ($email === $data->email) {
            $data->mail_validation = true;
            $dados = json_encode($dados);
            file_put_contents(DATA_LOCATION, $dados);
        }
    }
}
