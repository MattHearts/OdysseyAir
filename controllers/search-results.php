<?php
session_start();


//$isFlight = false;
//$pricePerPersonNum;

// Collects the data from SESSION
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


    if ($_SESSION['flightType'] == "return") {

        $srch1->searchDepAirportR = $_SESSION['searchDepAirportR'];
        $srch1->searchDestAirportR = $_SESSION['searchDestAirportR'];
        $srch1->searchDepDateR = $_SESSION['searchDepDateR'];

        $srch1->depDateMinus3R = $_SESSION['depDateMinus3R'];
        $srch1->depDateMinus2R = $_SESSION['depDateMinus2R'];
        $srch1->depDateMinus1R = $_SESSION['depDateMinus1R'];
        $srch1->depDatePlus1R = $_SESSION['depDatePlus1R'];
        $srch1->depDatePlus2R = $_SESSION['depDatePlus2R'];
        $srch1->depDatePlus3R = $_SESSION['depDatePlus3R'];

        $srch1->pricePerPersonMinus3R = $_SESSION['pricePerPersonMinus3R'];
        $srch1->pricePerPersonMinus2R = $_SESSION['pricePerPersonMinus2R'];
        $srch1->pricePerPersonMinus1R = $_SESSION['pricePerPersonMinus1R'];
        $srch1->pricePerPersonPlus1R = $_SESSION['pricePerPersonPlus1R'];
        $srch1->pricePerPersonPlus2R = $_SESSION['pricePerPersonPlus2R'];
        $srch1->pricePerPersonPlus3R = $_SESSION['pricePerPersonPlus3R'];
    }



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

    if (isset($_SESSION['depAirportR'])) {
        $srch1->depAirportR = $_SESSION['depAirportR'];
        $srch1->destAirportR = $_SESSION['destAirportR'];
        $srch1->depDateR = $_SESSION['depDateR'];
        $srch1->depTimeR = $_SESSION['depTimeR'];
        $srch1->arrTimeR = $_SESSION['arrTimeR'];
        $srch1->durationMinR = $_SESSION['durationMinR'];
        $srch1->pricePerPersonR = $_SESSION['pricePerPersonR'];

        if ($srch1->pricePerPersonR == "-") {
            $srch1->pricePerPersonNumR = 0;
        } else {
            $srch1->pricePerPersonNumR = $srch1->pricePerPersonR;
        }
    } else {
        $srch1->isFlightR = false;
    }
    if ($srch1->depAirportR == "-") {
        $srch1->isFlightR = false;
    } else {
        $srch1->isFlightR = true;
    }


    if ($_SESSION['flightType'] == "return") {
        $overallPrice = ($srch1->pricePerPersonNum * $srch1->whosGoing) + ($srch1->pricePerPersonNumR * $srch1->whosGoing);
    } else {
        $overallPrice = $srch1->pricePerPersonNum * $srch1->whosGoing;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
        if ($_POST["action"] == "dayMinus3") {
            $srch1->searchDepDate = $srch1->depDateMinus3;
            $srch1->search_flights();
            $searchErr = $srch1->searchErr;
        } elseif ($_POST["action"] == "dayMinus2") {
            $srch1->searchDepDate = $srch1->depDateMinus2;
            $srch1->search_flights();
            $searchErr = $srch1->searchErr;
        } elseif ($_POST["action"] == "dayMinus1") {
            $srch1->searchDepDate = $srch1->depDateMinus1;
            $srch1->search_flights();
            $searchErr = $srch1->searchErr;
        } elseif ($_POST["action"] == "dayPlus1") {
            $srch1->searchDepDate = $srch1->depDatePlus1;
            $srch1->search_flights();
            $searchErr = $srch1->searchErr;
        } elseif ($_POST["action"] == "dayPlus2") {
            $srch1->searchDepDate = $srch1->depDatePlus2;
            $srch1->search_flights();
            $searchErr = $srch1->searchErr;
        } elseif ($_POST["action"] == "dayPlus3") {
            $srch1->searchDepDate = $srch1->depDatePlus3;
            $srch1->search_flights();
            $searchErr = $srch1->searchErr;
        } else if ($_POST["action"] == "dayMinus3R") {
            $srch1->searchDepDateR = $srch1->depDateMinus3R;
            $srch1->search_flights_return();
            $searchErr = $srch1->searchErr;
        } elseif ($_POST["action"] == "dayMinus2R") {
            $srch1->searchDepDateR = $srch1->depDateMinus2R;
            $srch1->search_flights_return();
            $searchErr = $srch1->searchErr;
        } elseif ($_POST["action"] == "dayMinus1R") {
            $srch1->searchDepDateR = $srch1->depDateMinus1R;
            $srch1->search_flights_return();
            $searchErr = $srch1->searchErr;
        } elseif ($_POST["action"] == "dayPlus1R") {
            $srch1->searchDepDateR = $srch1->depDatePlus1R;
            $srch1->search_flights_return();
            $searchErr = $srch1->searchErr;
        } elseif ($_POST["action"] == "dayPlus2R") {
            $srch1->searchDepDateR = $srch1->depDatePlus2R;
            $srch1->search_flights_return();
            $searchErr = $srch1->searchErr;
        } elseif ($_POST["action"] == "dayPlus3R") {
            $srch1->searchDepDateR = $srch1->depDatePlus3R;
            $srch1->search_flights_return();
            $searchErr = $srch1->searchErr;
        }
    }



    include "../views/headerFlights.html";
    include "../views/search-results-view.php";
    include "../views/footer.html";
} else {
    echo "<script>window.location.href='../index.php'</script>";
}
