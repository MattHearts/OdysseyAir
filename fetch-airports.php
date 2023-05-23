<?php

// Placeholder code for demonstration
require "config.php";


// Fetch airports from the database
$sql = "SELECT * FROM airports";
$result = $conn->query($sql);

// Check if there are any airports
if ($result->num_rows > 0) {
    $airports = array();

    // Fetch and store each airport name in the $airports array
    while ($row = $result->fetch_assoc()) {
        $airports[] = $row['airport_ID'];
    }

    // Convert the array to JSON and send the response
    echo json_encode($airports);
} else {
    // No airports found
    echo json_encode([]);
    echo "Debugging output: Hello, world!"; 
}

// Close the database connection
$conn->close();
?>
