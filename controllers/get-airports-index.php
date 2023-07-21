<?php
// Include the database configuration file
require_once 'config.php';

// Function to fetch all airports from the database
function getAirports()
{
    global $conn;
    $airports = array();

    // Query to fetch all airports from the database
    $query = "SELECT airport_ID, airport_name FROM airports";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Fetch the results as an associative array
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $airports[] = $row;
    }

    return $airports;
}

// Call the function to get all airports
$airportData = getAirports();

// Set the response content type to JSON
header('Content-Type: application/json');

// Return the airport data as JSON
echo json_encode($airportData);
?>