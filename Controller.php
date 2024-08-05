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
    $messages = [];
    $messages['fields'] = auth_user();
    render_view('home', $messages);
}

function do_forget_password()
{
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        render_view('forget_password');
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = validate_email_field($_POST['person']['email']);

        if (crud_restore($email)) {
            $dados = crud_find($email);
            date_default_timezone_set('America/Sao_Paulo');
            $conteudo = $dados->email . ',' . date('Y-m-d-h-i');
            $token = ssl_crypt($conteudo);
            $url = 'http://localhost:8000?page=change-password&token=' . $token;
            sendMailForgetPassword($dados->email, $dados->name, $url);
            $messages['success'] = "Confirmação enviada para o email";
            render_view('forget_password', $messages);
        } else {
            $messages['errors'] = ['random' => "Email nao atribuido a nenhuma conta"];
            render_view('forget_password', $messages);
        }

    }
}
function do_change_password()
{

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $token = $_GET['token'];
        if (validade_token_newpassword($token) === false) {
            header("Location: /");
            render_view('login');
        }
        $messages['fields'] = (object) ['random' => "<input type='hidden' name='token' value='$token'>"];
        render_view('change_password', $messages);
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['token'];
        if (validade_token_newpassword($token) === false) {
            header("Location: /");
            render_view('login');
        }
        $validation_errors = validate_change_password($_POST['person']);
        if (count($validation_errors) > 0) {
            $messages = [
                'errors' => $validation_errors
            ];
            $messages['fields'] = (object) ['random' => "<input type='hidden' name='token' value='$token'>"];
            render_view("change_password", $messages);
        } else {
            $data = ssl_decrypt($token);
            [$email, $date] = explode(',', $data);
            $user = crud_find($email);
            $user->password = $_POST['person']['password'];
            crud_save_password($user);
            $messages['success'] = 'Senha alterada';
            render_view("login", $messages);
        }
    }
}