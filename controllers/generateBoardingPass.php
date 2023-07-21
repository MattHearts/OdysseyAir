<?php
require "../models/PDFGenerator.php"; 
// Create an instance of the CheckInModel class
$PDF = new PDFGenarator();

// Get the booking ID, flight ID, flight type, and passenger ID from the URL parameters
$bookingID = $_GET['bookingID'];
$flightID = $_GET['flightID'];

$passengerID = $_GET['passengerID'];

// Call the makeBoardingPass function with the selected passenger's information
$PDF->makeBoardingPass($bookingID , $flightID, $passengerID);
?>