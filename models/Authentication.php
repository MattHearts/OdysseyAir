<?php
//class for ticket search
class Authentication{
function isAuthenticated($token) {
    require "config.php"; // Include your database configuration file
    
    if(isset($_SESSION['username'])){
    // Retrieve the stored token for the user from the database
    $username = $_SESSION['username']; // Assuming you have the username stored in the session
    $query = "SELECT token FROM user WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedToken = $row['token'];

        // Compare the retrieved token with the provided token
        return ($token === $storedToken);
    }

    return false; // User not found or token retrieval failed
    }
else {
    return false; 
}
}
}
?>