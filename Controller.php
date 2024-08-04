<?php

function do_register()
{
    if (!empty($_POST['person'])) {
        register_post();
    } else {
        register_get();
    }
}
function register_get()
{
    render_view('register');
}
function register_post()
{
    $validation_errors = validate_registration($_POST['person']);
    if (count($validation_errors) == 0) {
        unset($_POST['person']['password-confirm']);

        $email = filter_var($_POST['person']['email'], FILTER_VALIDATE_EMAIL);
        $name = htmlspecialchars(trim($_POST['person']['name']));

        $_POST['person']['password'] = password_hash($_POST['person']['password'], PASSWORD_ARGON2ID);
        $_POST['person']['mail_validation'] = false;
        $_POST['person']['verify_code'] = ssl_crypt($email);
        $verifyCode = htmlspecialchars(trim($_POST['person']["verify_code"]));

        $url = "http://localhost:8000?page=mail_validation&token=$verifyCode";

        crud_create($_POST['person']);
        sendMailConfirmation($email, $name, $url);
        header("Location: /?page=login&from=register");
    } else {
        $messages = [
            'errors' => $validation_errors
        ];
        render_view('register', $messages);
    }
    exit();
}
function do_login()
{
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            login_get();
            break;
        case 'POST':
            $email = $_POST['person']['email'];
            $password = $_POST['person']['password'];
            authentication($email, $password);
            if (auth_user()) {
                header("Location: /");
            }
            break;
        default:
            do_not_found();
            var_dump($_SERVER['REQUEST_METHOD']);
            break;
    }
}
function login_get()
{
    $messages = [];
    switch (isset($_GET['from'])) {
        case 'register':
            $messages['success'] = "Você ainda precisa confirmar o email!";
            break;
    }
    render_view('login', $messages);
}
function login_post()
{

}
function do_validation()
{
    $messages = [];

    if (!isset($_GET['token'])) {
        render_view('login');
    }
    $data = ssl_decrypt($_GET['token']);
    if (crud_restore($data)) {
        crud_update($data);
        $messages['success'] = 'Email confirmado login autorizado!';

    } else {
        $errors['random'] = 'Token invalido!';
        $messages['errors'] = $errors;
    }
    render_view('login', $messages);
}
function do_logout()
{
    session_destroy();
    header("Location: /?page=login");
    render_view('login');
}
function do_delete()
{
    $user = $_SESSION['user'];
    crud_delete($user);
}
function do_not_found()
{
    http_response_code(404);
    render_view('not_found');
}

function do_home()
{

    render_view('home');
}