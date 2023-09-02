<?php
require "../models/admin-options.php";
// Retrieves the flight details from the form submission
$repeatWeeks = $_POST['repeat-weeks'];
$departureAirport = $_POST['departure_airport'];
$destinationAirport = $_POST['destination_airport'];
$date = $_POST['flight_date'];
$departureTime = $_POST['departure_time'];
$arrivalTime = $_POST['arrival_time'];
$duration = $_POST['flight_duration'];
$price = $_POST['flight_price'];

$adminOptions = new AdminOptions();

// Adds the flight to the database
$adminOptions->addFlight($departureAirport, $destinationAirport, $date, $departureTime, $arrivalTime, $duration, $price, $repeatWeeks);
