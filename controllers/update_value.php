<?php
session_start();

// Collects the data from POST method
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['passenger'])) {
    $action = $_POST['action'];
    $passenger = $_POST['passenger'];

    // Checks the action type
    if ($action == "increment") {
        // Increments the suitcaseNum
        $_SESSION['suitcaseNum' . $passenger] = isset($_SESSION['suitcaseNum' . $passenger]) ? $_SESSION['suitcaseNum' . $passenger] + 1 : 1;
        $updatedValue = $_SESSION['suitcaseNum' . $passenger];
    } elseif ($action == "decrement") {
        // Decrements the suitcaseNum
        if (isset($_SESSION['suitcaseNum' . $passenger]) && $_SESSION['suitcaseNum' . $passenger] > 0) {
            $_SESSION['suitcaseNum' . $passenger]--;
        }
        $updatedValue = isset($_SESSION['suitcaseNum' . $passenger]) ? $_SESSION['suitcaseNum' . $passenger] : 0;
    } else {
        echo "Invalid action.";
        exit();
    }

    // Returns the updated suitcaseNum value as the response
    echo $updatedValue;
} else {
    echo "Invalid request.";
    exit();
}
