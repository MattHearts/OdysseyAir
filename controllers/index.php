<?php
session_start();
//session_destroy();
//session_start();
$_SESSION['loggedToBook']=false;
$_SESSION['flightType']="";
require "../models/Authentication.php";
$auth1=new Authentication();
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);

$searchErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../models/Search.php";
    $srch1 = new Search();
    $srch1->searchDepAirport = $_POST['departure-airport'];
    $srch1->searchDestAirport = $_POST['destination-airport'];
    $srch1->searchDepDate = $_POST['date1'];
    $srch1->whosGoing = $_POST['how-many'];
    if (isset($_POST['trip-type']) && $_POST['trip-type'] === 'one-way') {
        $_SESSION['flightType']="one-way";
    $srch1->validate_search();
    if (empty($srch1->searchErr)){
        echo "<script>window.location.href='../controllers/search-results.php'</script>";
        exit();
    }
    }
    else if (isset($_POST['trip-type']) && $_POST['trip-type'] === 'return') {

        $_SESSION['flightType']="return";
        $srch1->searchDepDateR = $_POST['date2'];
        $srch1->validate_search();
        $srch1->validate_return_search();
        if (empty($srch1->searchErr)){
            echo "<script>window.location.href='../controllers/search-results.php'</script>";
            exit();
        }

    } 
    

    $searchErr = $srch1->searchErr;
}

if ($auth1->isAuthenticated($token)) {
    if($_SESSION['username']=="admin")
    {
        $username = $_SESSION['username']; 
        include "../views/headerAdminPage.php";
    }
    else{    // User is authenticated, proceed with the request
        $username = $_SESSION['username']; 
        include "../views/headerAuth.php";}

}
else {
    // User is not authenticated, redirect to login or show an error message
    include "../views/header.html";
}

include "../views/index_view.php";
include "../views/footer.html";
?>