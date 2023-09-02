<?php

require "../models/PDFGenerator.php"; 

$PDF = new PDFGenarator();

// Gets the booking ID, flight ID, flight type, and passenger ID from the URL parameters
$bookingID = $_GET['bookingID'];
$flightID = $_GET['flightID'];

$passengerID = $_GET['passengerID'];

// Calls the makeBoardingPass function with the selected passenger's information
$PDF->makeBoardingPass($bookingID , $flightID, $passengerID);
?>