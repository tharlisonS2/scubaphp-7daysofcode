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
    if (crud_restore($data['email'])) {
        $errors['email'] = 'Email já usado, tente outro';
    }
    return $errors;
}
function validate_change_password($data)
{
    $errors = [];
    if (strlen($data['password']) < 10) {
        $errors['password'] = "A senha deve ter mais de 10 caracteres";
    }
    if ($data['password'] !== $data['password-confirm']) {
        $errors['password-confirm'] = 'Senha e confirmação devem ser iguais';
    }
    return $errors;
}
function validate_email_field($email)
{
    $email = trim($email);
    $emailFiltro = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (filter_var($emailFiltro, FILTER_VALIDATE_EMAIL)) {
        return $emailFiltro;
    } else {
        return new Exception('Email Invalido: ' . $emailFiltro);
    }
}
function validade_token_newpassword($data)
{
    $data = ssl_decrypt($data);
    [$email, $date] = explode(',', $data);
    $timestampAtual = time();
    $timestampSubtraido = $timestampAtual - 86400;
    $dti = new DateTimeImmutable($date);
    $date = $dti->getTimestamp();
    if (crud_restore($email) && $timestampSubtraido < $date) {
        return true;
    }
    return false;
}