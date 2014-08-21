<?php
namespace requests;
require_once('authentication.php');
use authentication as auth;
use app;

/**
 * A switch for handling user requests.
 */
if (isset($_REQUEST['type'])) {
    switch ($_REQUEST['type']) {
    case 'login':
        $username = isset($_POST['username'])? $_POST['username'] : False;
        $password = isset($_POST['password'])? $_POST['password'] : False;
        if ($username && $password) {
            if (auth\valid_login($username, $password)) {
                session_start();
            }
        }
    }
    header('Location: '.$_SERVER['HTTP_REFERER']);
    die();
}

