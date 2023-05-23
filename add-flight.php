<?php
require "admin-options.php";
// Retrieve the flight details from the form submission
$repeatWeeks = $_POST['repeat-weeks'];
$departureAirport = $_POST['departure_airport'];
$destinationAirport = $_POST['destination_airport'];
$date = $_POST['flight_date'];
$departureTime = $_POST['departure_time'];
$arrivalTime = $_POST['arrival_time'];
$duration = $_POST['flight_duration'];
$price = $_POST['flight_price'];

// Instantiate the AdminOptions class
$adminOptions = new AdminOptions();

// Add the flight to the database
$adminOptions->addFlight($departureAirport, $destinationAirport, $date, $departureTime, $arrivalTime, $duration, $price, $repeatWeeks);

?>
