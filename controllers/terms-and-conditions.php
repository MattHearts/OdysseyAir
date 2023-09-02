<?php
session_start();
require "../models/Authentication.php";
$auth1 = new Authentication();
// Collects token
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);
// Checks if user is authenticated
if ($auth1->isAuthenticated($token)) {

    if ($_SESSION['username'] == "admin@admin.com") {
        $username = $_SESSION['username'];
        include "../views/headerAdminPage.php";
    } else {
        $username = $_SESSION['username'];
        include "../views/headerAuth.php";
    }
} else {
    include "../views/header.html";
}

include "../views/terms-and-conditions-view.php";
include "../views/footer.html";
