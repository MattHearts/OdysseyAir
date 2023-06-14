<?php
require "../models/admin-options.php";
// Retrieve the flight details from the form submission
$airportID = $_POST['airport-id'];
$airportCity = $_POST['airport-city'];
$airportName = $_POST['airport-name'];
$airportCountry = $_POST['airport-country'];

// Instantiate the AdminOptions class
$adminOptions = new AdminOptions();

// Add the flight to the database
try {
    $adminOptions->addAirport($airportID, $airportCity, $airportName, $airportCountry);
    
} catch (Exception $e) {
    echo "Failed to add the airport. Please try again.";
    // Handle the error, such as logging or displaying a user-friendly message
}
?>
