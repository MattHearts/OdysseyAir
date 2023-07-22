<?php
session_start();
require "../models/Authentication.php";
$auth1=new Authentication();
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);
if (!$auth1->isAuthenticated($token) || $_SESSION['username']!="admin") {

    header("Location: ../index.php");

}

if (isset($_POST['manage-flights-button'])) {
    header("Location: ../views/manage-flights.php");
    exit();
}

if (isset($_POST['manage-airports-button'])) {
    header("Location: ../views/manage-airports.php");
    exit();
}
if (isset($_POST['manage-accounts-button'])) {
    header("Location: ../views/manage-accounts.php");
    exit();
}

include "../views/header-admin.html";
include "../views/admin-menu-view.php";
include "../views/footer.html";
?>
