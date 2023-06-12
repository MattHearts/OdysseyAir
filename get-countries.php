<?php

// Placeholder code for demonstration
require "config.php";

// Fetch countries from the database
$sql = "SELECT * FROM countries";
$result = $conn->query($sql);
// Check if there are any airports
if ($result->num_rows > 0) {
    $countries = array();

    // Fetch and store each airport name in the $airports array
    while ($row = $result->fetch_assoc()) {
        $countries[] = $row['country'];
    }

// Return the countries as JSON
header('Content-Type: application/json');
echo json_encode($countries);
}
else {
    // No airports found
    echo json_encode([]);
    echo "Debugging output: Hello, world!"; 
}

// Close the database connection
$conn->close();
?>
