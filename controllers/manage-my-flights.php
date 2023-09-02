<!DOCTYPE html>
<html>
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
    if (isset($_SESSION['bookingIDCheckin'])) {
        $selectedBookingId = $_SESSION['bookingIDCheckin'];
        $check1->find_flights($selectedBookingId);
    }
} else {
    echo "<script> window.location.href='../controllers/login.php'</script>";
}

// Collects the data from POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['flightCode']) && isset($_POST['flightType'])) {
        $_SESSION['flightIDCheckin'] = $_POST['flightCode'];
        $_SESSION['flightTypeCheckin'] = $_POST['flightType'];
        if($check1->isflightGone())
        {
            echo "<script>window.location.href='checkInGone.php'</script>";
        }
        // Checks if user has submitted for an online Check In
        if ($check1->isCheckinOnline()) {
            // Checks if users has already Checked In
            if ($check1->isChecked()) {
                echo "<script>window.location.href='checkInSuccess.php'</script>";
            } else {
                $_SESSION['checkInInfo'] = "working";
                echo "<script>window.location.href='checkin.php'</script>";
            }
        } else {
            echo "<script>window.location.href='checkInAirport.php'</script>";
        }
    } else {
        echo "<script> window.location.href='../controllers/login.php'</script>";
    }
}


include "../views/headerAuth.php";
include "../views/manage-my-flights-view.php";
include "../views/footer.html";
