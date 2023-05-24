<?php
session_start();
include "admin-options.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the flight ID from the POST data
    $flightId = $_POST['flightId'];

    // Instantiate the AdminOptions class
    $adminOptions = new AdminOptions();

    $arePassengersDeleted=$adminOptions->movePassengersToCancelledTable($flightId);
    if($arePassengersDeleted==true){
    // Move the flight to the cancelled-flights table
    $result = $adminOptions->moveFlightToCancelledTable($flightId);
    }
    else{
        echo "Failed to move the flight to the cancelled-flights table. Please try again.";
    }
    // Check the result and send the response
    if ($result) {
        echo "Flight with ID " . $flightId . " has been cancelled.";
    } else {
        echo "Failed to move the flight to the cancelled-flights table. Please try again.";
    }
}
?>
