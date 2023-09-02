<?php
session_start();
include "../models/admin-options.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gets the flight ID from the POST data
    $flightId = $_POST['flightId'];

   
    $adminOptions = new AdminOptions();

    if($adminOptions->moveCancelledFlights($flightId)){
    // Moves the flight to the cancelled-flights table
    echo "Flight with ID " . $flightId . " has been cancelled.";
    }
    else{
        echo "Failed to move the flight to the cancelled-flights table. Please try again.";
    }
    
}
