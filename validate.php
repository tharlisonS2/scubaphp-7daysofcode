<?php
function validate_registration($data)
{
    $errors = [];
    if (strlen($data['password']) < 10) {
        $errors['password'] = "A senha deve ter mais de 10 caracteres";
    }
    if ($data['password'] !== $data['password-confirm']) {
        $errors['password-confirm'] = 'Senha e confirmação devem ser iguais';
    }
    if(checkEmail($data['email'])){
        $errors['email'] = 'Email já usado, tente outro';
    }
    return $errors;
}