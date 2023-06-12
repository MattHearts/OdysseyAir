<?php
session_start();
session_destroy();
session_start();
$searchErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "../models/Search.php";
    $srch1 = new Search();
    $srch1->searchDepAirport = $_POST['departure-airport'];
    $srch1->searchDestAirport = $_POST['destination-airport'];
    $srch1->searchDepDate = $_POST['date1'];
    $srch1->whosGoing = $_POST['how-many'];
    $srch1->search_flights();
    $searchErr = $srch1->searchErr;
}

include "../views/header.html";
include "../views/index_view.php";
include "../views/footer.html";
?>