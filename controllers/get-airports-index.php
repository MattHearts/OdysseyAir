<?php
// Include the database configuration file
require_once '../models/config.php';

// Function to fetch airports from the database based on the user input
function getAirports($query)
{
    global $conn;
    // Sanitize user input
    $query = trim($query);

    // Query to fetch the airports based on the user input
    $sql = "SELECT airport_ID, airport_city FROM airports WHERE airport_ID LIKE '%$query%' OR airport_city LIKE '%$query%'";
    $result = $conn->query($sql);

    // Fetch the results and create an array of airports
    $airports = array();
    while ($row = $result->fetch_assoc()) {
        $airports[] = array(
            'airport_ID' => $row['airport_ID'],
            'airport_city' => $row['airport_city']
        );
    }

    return $airports;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["keyword"])) {
    $keyword = $_POST["keyword"];

    // Call the function to get the matching airports based on the user input
    $airportData = getAirports($keyword);

    // Return the results as a JSON array
    echo json_encode($airportData);
}
?>