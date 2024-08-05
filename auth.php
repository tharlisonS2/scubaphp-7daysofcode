<?php


function authentication($email, $password)
{
    $user = crud_find($email);

    if (isset($user->mail_validation) && $user->mail_validation === false) {
        $errors['random'] = 'Voce precisa verificar o e-mail';
        $messages['errors'] = $errors;
        render_view('login', $messages);
        return;
    }
    if (crud_restore($email) && password_verify($password, $user->password)) {
        $_SESSION['user'] = json_encode($user);
        render_view('home');
    } else {
        $errors['random'] = 'Usuário ou/e senha incorretos';
        $messages['errors'] = $errors;
        render_view('login', $messages);
    }
}

function auth_user()
{
    return  isset($_SESSION['user']) ?  json_decode($_SESSION['user']) : '';
}