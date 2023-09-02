<?php
require "../models/admin-options.php";
// Retrieves the flight details from the form submission
$airportID = $_POST['airport-id'];
$airportCity = $_POST['airport-city'];
$airportName = $_POST['airport-name'];
$airportCountry = $_POST['airport-country'];

$adminOptions = new AdminOptions();

// Adds the flight to the database
try {
    $adminOptions->addAirport($airportID, $airportCity, $airportName, $airportCountry);
    
} catch (Exception $e) {
    echo "Failed to add the airport. Please try again.";
}
