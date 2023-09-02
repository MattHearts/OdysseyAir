<?php
session_start();

require "../models/Authentication.php";
$auth1 = new Authentication();
require "../models/CheckInModel.php";
$check1 = new CheckIn();
// Collects token
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);

// Checks if user is authenticated
if ($auth1->isAuthenticated($token)) {
    $username = $_SESSION['username'];
    
} else {
    echo "<script> window.location.href='../index.php'</script>";
}
if (isset($_SESSION['flightIDCheckin'])) {
    include "../views/headerAuth.php";
    include "../views/checkInGone-view.php";
    include "../views/footer.html";
} else {
    echo "<script> window.location.href='../index.php'</script>";
}
?>