<?php


function guest_routes()
{
    $page = $_GET['page'] ?? 'login';

    switch ($page) {
        case 'login':
            do_login();
            break;

        case 'register':
            do_register();
            break;
        case 'mail_validation':
            do_validation();
            break;
        case 'forget-password':
            do_forget_password();
            break;
        case 'change-password':
            do_change_password();
            break;
        default:
            do_not_found();
            break;
    }
}
function auth_routes()
{
    $path = $_SERVER['PATH_INFO'] ?? '/home';
    switch ($path) {
        case '/home':
            do_home();
            break;
        case '/logout':
            do_logout();
            break;
        case '/delete':
            do_delete();
            break;
        default:
            do_not_found();
            break;
    }
}

//echo file_get_contents(VIEW_FOLDER . $page);