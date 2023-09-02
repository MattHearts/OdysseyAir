<?php

include "../models/admin-options.php";




// Retrieves the airport ID from the AJAX request
$airportID = $_GET['airportID'];

$adminOptions = new AdminOptions();
$isAirportInFlights = $adminOptions->checkAirportInFlights($airportID);

// Prepares the response as JSON
$response = array('inFlights' => $isAirportInFlights);

// Sends the JSON response
header('Content-Type: application/json');
echo json_encode($response);
