<?php
require "../models/admin-options.php";
// Collects the data from POST method
$flightID = $_POST['e-flight-id'];
$departureAirport = $_POST['e-departure_airport'];
$destinationAirport = $_POST['e-destination_airport'];
$date = $_POST['e-flight_date'];
$departureTime = $_POST['e-departure_time'];
$arrivalTime = $_POST['e-arrival_time'];
$duration = $_POST['e-flight_duration'];
$price = $_POST['e-flight_price'];

$adminOptions = new AdminOptions();

// Adds the flight to the database
$adminOptions->updateFlight($flightID, $departureAirport, $destinationAirport, $date, $departureTime, $arrivalTime, $duration, $price);
