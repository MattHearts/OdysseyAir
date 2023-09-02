<?php
session_start();

// Clears all session variables
$_SESSION = array();

// Destroys the session
session_destroy();

// Redirects the user to the main page
header("Location: ../index.php");
exit();
