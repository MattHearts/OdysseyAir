<?php

include "admin-options.php";


    // Instantiate the AdminOptions class
    
// Retrieve the airport ID from the AJAX request
$airportID = $_GET['airportID'];

$adminOptions = new AdminOptions();
$isAirportInFlights = $adminOptions->checkAirportInFlights($airportID); 

// Prepare the response as JSON
$response = array('inFlights' => $isAirportInFlights);

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>