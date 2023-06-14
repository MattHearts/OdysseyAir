<?php

// Placeholder code for demonstration
require "../models/config.php";

// Check if the country parameter is set
if (isset($_GET['country'])) {
    $selectedCountry = $_GET['country'];

    // Fetch airports for the selected country from the database
    $sql = "SELECT * FROM airports WHERE country = '$selectedCountry'";
    $result = $conn->query($sql);
    // Check if there are any airports
    if ($result->num_rows > 0) {
        $airports = array();

        // Fetch and store each airport in the $airports array
        while ($row = $result->fetch_assoc()) {
            $airports[] = $row;
        }

        // Return the airports as JSON
        header('Content-Type: application/json');
        echo json_encode($airports);
    } else {
        // No airports found for the selected country
        echo json_encode([]);
    }
} else {
    // Country parameter is missing
    echo "Country parameter is missing.";
}

// Close the database connection
$conn->close();
?>