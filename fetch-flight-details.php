<?php
session_start();
require "config.php";

// Check if the flight ID is provided via POST
if (isset($_POST['flightId'])) {
    $flightId = $_POST['flightId'];

    // Prepare the SQL statement
    $sql = "SELECT * FROM flights WHERE flight_id = '$flightId'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch the flight details
        $flight = $result->fetch_assoc();

        // Return the flight details as JSON
        echo json_encode($flight);
    } else {
        // Handle the case when the flight is not found
        echo json_encode(array('error' => 'Flight not found.'));
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle the case when flight ID is not provided
    echo json_encode(array('error' => 'Flight ID not specified.'));
}
?>
