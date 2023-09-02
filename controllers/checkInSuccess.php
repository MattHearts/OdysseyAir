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

// Collects the data from SESSION
if (isset($_SESSION['flightIDCheckin'])) {
    $check1->flightIDCheck = $_SESSION['flightIDCheckin'];
    $check1->bookingIDCheck = $_SESSION['bookingIDCheckin'];
    $check1->flightTypeCheck = $_SESSION['flightTypeCheckin'];

    // Gets passengers data from database
    $passengerInfo = $check1->getPassengerInfoFromDatabase($check1->bookingIDCheck, $check1->flightTypeCheck);
} else {
    echo "<script> window.location.href='../index.php'</script>";
}

include "../views/headerAuth.php";
include "../views/checkInSuccess-view.php";
include "../views/footer.html";
