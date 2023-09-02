<?php

require "../models/config.php";

$sql = "SELECT * FROM countries";
$result = $conn->query($sql);
// Checks if there are any airports
if ($result->num_rows > 0) {
    $countries = array();

    // Fetches and stores each airport name in the $airports array
    while ($row = $result->fetch_assoc()) {
        $countries[] = $row['country'];
    }

// Returns the countries as JSON
header('Content-Type: application/json');
echo json_encode($countries);
}
else {

    echo json_encode([]);
}

$conn->close();
?>
