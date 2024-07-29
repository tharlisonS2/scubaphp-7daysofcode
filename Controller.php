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
        crud_create($_POST['person']);
        header("Location: /?page=login&from=register");
    } else {
        $messages = [
            'validations_erros' => $validation_errors
        ];
        render_view('register', $messages);
    }
    exit();
}
function do_login()
{
    $messages = [];
    switch (isset($_GET['from'])) {
        case 'register':
            $messages['success'] = "Você ainda precisa confirmar o email!";
            break;
    }
    render_view('login', $messages);
}
function do_not_found()
{
    http_response_code(404);
    render_view('not_found');
}

