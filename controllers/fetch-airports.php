<?php

require "../models/config.php";


// Fetches airports from the database
$sql = "SELECT * FROM airports";
$result = $conn->query($sql);

// Checks if there are any airports
if ($result->num_rows > 0) {
    $airports = array();

    // Fetches and stores each airport name in the $airports array
    while ($row = $result->fetch_assoc()) {
        $airports[] = $row['airport_ID'];
    }

    // Converts the array to JSON and send the response
    echo json_encode($airports);
} else {

    echo json_encode([]);
    echo "Debugging output: No airports found";
}

$conn->close();
