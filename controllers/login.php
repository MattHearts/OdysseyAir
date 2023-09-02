<?php
session_start();


$loginErr = " ";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	require "../models/user.php";
	$usr1 = new User();
	$usr1->username = $_POST['username'];
	$usr1->password = $_POST['password'];
	// Checks if user exists and has given the correct password
	$usr1->loginUser();
	$loginErr = $usr1->loginErr;
}
if (isset($_SESSION['username'])) {
	echo "<script> window.location.href='../index.php'</script>";
} else {
	if (isset($_SESSION['loggedToBook']) && $_SESSION['loggedToBook'] == TRUE) {
		include "../views/header.html";
	} else {
		include "../views/header.html";
	}

	include "../views/login-view.php";
	include "../views/footer.html";
}
