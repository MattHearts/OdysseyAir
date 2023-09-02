<?php

require "../models/config.php";


if (isset($_GET['country'])) {
    $selectedCountry = $_GET['country'];

    $sql = "SELECT * FROM airports WHERE country = '$selectedCountry'";
    $result = $conn->query($sql);
    // Checks if there are any airports
    if ($result->num_rows > 0) {
        $airports = array();

        // Fetches and stores each airport in the $airports array
        while ($row = $result->fetch_assoc()) {
            $airports[] = $row;
        }

        // Returns the airports as JSON
        header('Content-Type: application/json');
        echo json_encode($airports);
    } else {
        // No airports found for the selected country
        echo json_encode([]);
    }
} else {
    echo "Country parameter is missing.";
}


$conn->close();
