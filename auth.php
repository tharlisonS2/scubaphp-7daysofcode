<?php


function authentication($email, $password)
{
    $user = crud_find($email);

    if (crud_restore($email) && password_verify($password, $user->password)) {
        $_SESSION["email"] = $email;
        render_view('home');
    } else {
        $errors['random'] = 'Usuário ou/e senha incorretos';
        $messages['errors'] = $errors;
        render_view('login', $messages);
    }
}
function auth_user()
{
    return isset($_SESSION['email']);
}