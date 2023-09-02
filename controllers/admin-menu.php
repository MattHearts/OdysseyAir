<?php
session_start();
require "../models/Flight.php";
Flight::moveCompletedFlights();
require "../models/Authentication.php";
$auth1 = new Authentication();
// Selects token
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);
// Checks if user is authenticated
if ($auth1->isAuthenticated($token)) {
    $username = $_SESSION['username'];
    // Check if user is admin
    if ($auth1->isAdmin($username)) {

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
    } else {
        echo "<script> window.location.href='../index.php'</script>";
    }
} else {
    echo "<script> window.location.href='../index.php'</script>";
}
