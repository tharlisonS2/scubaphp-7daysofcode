<?php

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


//echo file_get_contents(VIEW_FOLDER . $page);