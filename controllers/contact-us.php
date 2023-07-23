<?php
session_start();
require "../models/Authentication.php";
$auth1=new Authentication();
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);
if ($auth1->isAuthenticated($token)) {


        $username = $_SESSION['username']; 
        include "../views/headerAuth.php";

}
else {
    // User is not authenticated, redirect to login or show an error message
    include "../views/header.html";
}

include "../views/contact-us-view.php";
include "../views/footer.html";
