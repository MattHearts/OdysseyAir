<?php
session_start();
//session_destroy();
//session_start();
require "../models/Flight.php";
Flight::moveCompletedFlights();
$_SESSION['loggedToBook'] = false;
$_SESSION['flightType'] = "";
$_SESSION['isPurchaceComplete'] = false;
unset($_SESSION['checkIn']);
unset($_SESSION['searchDepAirport']);
unset($_SESSION['depAirport']);
unset($_SESSION['depAirportR']);
unset($_SESSION['checkIn']);
unset($_SESSION['overallPriceV3']);
unset($_SESSION['bookingID']);
require "../models/Authentication.php";
$auth1 = new Authentication();
// Selects token
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);

$searchErr = "";
// Collects the data from GET method
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    require "../models/Search.php";
    $srch1 = new Search();

    if (isset($_GET['departure-airport'])) {
        $srch1->searchDepAirport = $_GET['departure-airport'];
    }
    if (isset($_GET['destination-airport'])) {
        $srch1->searchDestAirport = $_GET['destination-airport'];
    }
    if (isset($_GET['date1'])) {
        $srch1->searchDepDate = $_GET['date1'];
    }
    if (isset($_GET['how-many'])) {
        $srch1->whosGoing = $_GET['how-many'];
    }
    if (isset($_GET['trip-type']) && $_GET['trip-type'] === 'one-way') {
        $_SESSION['flightType'] = "one-way";
        // Validates Search
        $srch1->validate_search();
        if (empty($srch1->searchErr)) {
            // If no error then add the GET parameters to URL
            header("Location: ../controllers/search-results.php?" . http_build_query($_GET));
            exit();
        }
    } else if (isset($_GET['trip-type']) && $_GET['trip-type'] === 'return') {

        $_SESSION['flightType'] = "return";
        $srch1->searchDepDateR = $_GET['date2'];
        $srch1->validate_search();
        $srch1->validate_return_search();
        if (empty($srch1->searchErr)) {
            header("Location: ../controllers/search-results.php?" . http_build_query($_GET));
            exit();
        }
    }


    $searchErr = $srch1->searchErr;
}
// Checks if user is authenticated
if ($auth1->isAuthenticated($token)) {
    $username = $_SESSION['username'];
    if ($auth1->isAdmin($username)) {

        include "../views/headerAdminPage.php";
    } else {

        include "../views/headerAuth.php";
    }
} else {

    include "../views/header.html";
}

include "../views/index_view.php";
include "../views/footer.html";
