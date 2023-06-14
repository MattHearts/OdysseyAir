<?php
session_start();

//$isFlight = false;
//$pricePerPersonNum;

if (isset($_SESSION['searchDepAirport'])) {
    require "../models/Search.php";
    $srch1 = new Search();
    $srch1->searchDepAirport = $_SESSION['searchDepAirport'];
    $srch1->searchDestAirport = $_SESSION['searchDestAirport'];
    $srch1->searchDepDate = $_SESSION['searchDepDate'];
    $srch1->whosGoing = $_SESSION['whosGoing'];

    $srch1->depDateMinus3 = $_SESSION['depDateMinus3'];
    $srch1->depDateMinus2 = $_SESSION['depDateMinus2'];
    $srch1->depDateMinus1 = $_SESSION['depDateMinus1'];
    $srch1->depDatePlus1 = $_SESSION['depDatePlus1'];
    $srch1->depDatePlus2 = $_SESSION['depDatePlus2'];
    $srch1->depDatePlus3 = $_SESSION['depDatePlus3'];

    $srch1->pricePerPersonMinus3 = $_SESSION['pricePerPersonMinus3'];
    $srch1->pricePerPersonMinus2 = $_SESSION['pricePerPersonMinus2'];
    $srch1->pricePerPersonMinus1 = $_SESSION['pricePerPersonMinus1'];
    $srch1->pricePerPersonPlus1 = $_SESSION['pricePerPersonPlus1'];
    $srch1->pricePerPersonPlus2 = $_SESSION['pricePerPersonPlus2'];
    $srch1->pricePerPersonPlus3 = $_SESSION['pricePerPersonPlus3'];

    if (isset($_SESSION['depAirport'])) {
        $srch1->depAirport = $_SESSION['depAirport'];
        $srch1->destAirport = $_SESSION['destAirport'];
        $srch1->depDate = $_SESSION['depDate'];
        $srch1->depTime = $_SESSION['depTime'];
        $srch1->arrTime = $_SESSION['arrTime'];
        $srch1->durationMin = $_SESSION['durationMin'];
        $srch1->pricePerPerson = $_SESSION['pricePerPerson'];
        
        if ($srch1->pricePerPerson == "-") {
            $srch1->pricePerPersonNum = 0;
        } else {
            $srch1->pricePerPersonNum = $srch1->pricePerPerson;
        }


    } else {
        $srch1->isFlight = false;
    }
    if ($srch1->depAirport == "-") {
        $srch1->isFlight = false;
    } else {
        $srch1->isFlight = true;
    }

    if (isset($_POST['dayMinus3'])) {
        $srch1->searchDepDate = $srch1->depDateMinus3;
        $srch1->search_flights();
        $searchErr = $srch1->searchErr;
    }

    if (isset($_POST['dayMinus2'])) {
        $srch1->searchDepDate = $srch1->depDateMinus2;
        $srch1->search_flights();
        $searchErr = $srch1->searchErr;
    }

    if (isset($_POST['dayMinus1'])) {
        $srch1->searchDepDate = $srch1->depDateMinus1;
        $srch1->search_flights();
        $searchErr = $srch1->searchErr;
    }

    if (isset($_POST['dayPlus1'])) {
        $srch1->searchDepDate = $srch1->depDatePlus1;
        $srch1->search_flights();
        $searchErr = $srch1->searchErr;
    }

    if (isset($_POST['dayPlus2'])) {
        $srch1->searchDepDate = $srch1->depDatePlus2;
        $srch1->search_flights();
        $searchErr = $srch1->searchErr;
    }

    if (isset($_POST['dayPlus3'])) {
        $srch1->searchDepDate = $srch1->depDatePlus3;
        $srch1->search_flights();
        $searchErr = $srch1->searchErr;
    }

    include "../views/headerFlights.html";
include "../views/search-results-view.php";
include "../views/footer.html";

} else {
    echo "Something went wrong :(";
}
?>