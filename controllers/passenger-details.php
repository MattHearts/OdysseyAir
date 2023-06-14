<?php
session_start();


$passengersErr="";
$checkInErr="";
$suitcaseNum=0;

if (isset($_SESSION['depAirport'])) {
    require "../models/Search.php";
    $srch1 = new Search();
    $srch1->depAirport = $_SESSION['depAirport'];
    $srch1->destAirport = $_SESSION['destAirport'];
    $srch1->depDate = $_SESSION['depDate'];
    $srch1->depTime = $_SESSION['depTime'];
    $srch1->arrTime = $_SESSION['arrTime'];
    $srch1->durationMin = $_SESSION['durationMin'];
    $srch1->pricePerPerson = $_SESSION['pricePerPerson'];
    $srch1->whosGoing = $_SESSION['whosGoing'];
}
else
{
echo "something went wrong";
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    require "../models/Passengers.php";
    $pass1 = new Passengers();
    if (!isset($_POST['check-in'])) 
    {
        $pass1->checkInRadio=false;
    }
    else{
        $pass1->checkInRadio=true;
        $pass1->checkIn=$_POST['check-in'];
    }

    $pass1->howMany=$srch1->whosGoing;
    
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {

        $pass1->passengerName[$x]= $_POST['passenger-name'.$x];
        $pass1->passengerSurname[$x]=$_POST['passenger-surname'.$x];
        $pass1->passengerTitle[$x]=$_POST['passenger-title'.$x];


    }
    $pass1->validate_passengers();
    $passengersErr=$pass1->passengersErr;
    $checkInErr=$pass1->checkInErr;

}

include "../views/header3.html";
include "../views/passenger-details-view.php";
include "../views/footer.html";
        ?>