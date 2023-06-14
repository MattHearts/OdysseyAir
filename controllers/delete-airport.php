<?php
session_start();
require "../models/config.php";

// Check if the airport ID is provided
if (isset($_POST['airportID'])) {
    $airportID = $_POST['airportID'];

    // Perform the delete operation
    $sql = "DELETE FROM airports WHERE airport_ID = '$airportID'";
    $result = $conn->query($sql);

    // Check if the deletion was successful
    if ($result) {
        echo "Airport deleted successfully!";
    } else {
        echo "Failed to delete the airport. Please try again.";
    }
} else {
    echo "Airport ID not provided.";
}
?>