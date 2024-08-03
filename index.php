<?php
session_start();

require_once 'boot.php';

if (auth_user()) {
    auth_routes();
} else {
    guest_routes();
}