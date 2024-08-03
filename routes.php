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
        default:
            do_not_found();
            break;
    }
}

//echo file_get_contents(VIEW_FOLDER . $page);