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
    $check1->find_bookings($username);
} else {
    echo "<script> window.location.href='../controllers/login.php'</script>";
}
// Collects the data from POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['booking_id'])) {
        $_SESSION['bookingIDCheckin'] = $_POST['booking_id'];
        echo "<script>window.location.href='../controllers/manage-my-flights.php'</script>";
    }
}



include "../views/headerAuth.php";
include "../views/manage-booking-user-view.php";
include "../views/footer.html";
