<?php
session_start();

require "../models/Authentication.php";
$auth1 = new Authentication();
require "../models/CheckInModel.php";
$check1 = new CheckIn();
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);

if ($auth1->isAuthenticated($token)) {
    $username = $_SESSION['username'];
} else {
    echo "<script> window.location.href='../index.php'</script>";
}

if (isset($_SESSION['flightIDCheckin'])) {
    $check1->flightIDCheck = $_SESSION['flightIDCheckin'];
    $check1->bookingIDCheck = $_SESSION['bookingIDCheckin'];
    $check1->flightTypeCheck = $_SESSION['flightTypeCheckin'];

    $passengerInfo = $check1->getPassengerInfoFromDatabase($check1->bookingIDCheck, $check1->flightTypeCheck);
    // Prevent output before generating PDF
    //ob_clean(); // Clean (erase) the output buffer
    //$check1->makeBoardingPass($check1->bookingIDCheck, $check1->flightTypeCheck, $check1->flightIDCheck);
    //exit; // Terminate the script after generating the PDF
} else {
    echo "<script> window.location.href='../index.php'</script>";
}

include "../views/header.html";
include "../views/checkInSuccess-view.php";
include "../views/footer.html";
?>
