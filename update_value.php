<?php
session_start();

// Check if the action and passenger values are received via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['passenger'])) {
    $action = $_POST['action'];
    $passenger = $_POST['passenger'];

    // Check the action type
    if ($action == "increment") {
        // Increment the suitcaseNum value for the passenger
        $_SESSION['suitcaseNum'.$passenger] = isset($_SESSION['suitcaseNum'.$passenger]) ? $_SESSION['suitcaseNum'.$passenger] + 1 : 1;
        $updatedValue = $_SESSION['suitcaseNum'.$passenger];
    } elseif ($action == "decrement") {
        // Decrement the suitcaseNum value for the passenger
        if (isset($_SESSION['suitcaseNum'.$passenger]) && $_SESSION['suitcaseNum'.$passenger] > 0) {
            $_SESSION['suitcaseNum'.$passenger]--;
        }
        $updatedValue = isset($_SESSION['suitcaseNum'.$passenger]) ? $_SESSION['suitcaseNum'.$passenger] : 0;
    } else {
        // Invalid action, return an error response
        echo "Invalid action.";
        exit();
    }

    // Return the updated suitcaseNum value as the response
    echo $updatedValue;
} else {
    // Invalid request, return an error response
    echo "Invalid request.";
    exit();
}
?>