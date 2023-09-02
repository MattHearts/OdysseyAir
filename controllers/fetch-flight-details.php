<?php
session_start();
require "../models/config.php";

// Checks if the flight ID is provided via POST
if (isset($_POST['flightId'])) {
    $flightId = $_POST['flightId'];

    
    $sql = "SELECT * FROM flights WHERE flight_id = '$flightId'";

    
    $result = $conn->query($sql);

    // Checks if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch the flight details
        $flight = $result->fetch_assoc();

        // Returns the flight details as JSON
        echo json_encode($flight);
    } else {

        echo json_encode(array('error' => 'Flight not found.'));
    }

    $conn->close();
} else {

    echo json_encode(array('error' => 'Flight ID not specified.'));
}
