<?php
session_start();


$numErr="";
$nameErr="";
$CVVErr="";



if (isset($_SESSION['overallPriceV3'])&&$_SESSION['isPurchaceComplete']==false) {

    require "../models/Search.php";
    $srch1 = new Search();
    $srch1->whosGoing = $_SESSION['whosGoing'];
    $srch1->depAirport = $_SESSION['depAirport'];
    $srch1->destAirport = $_SESSION['destAirport'];
    $srch1->depDate = $_SESSION['depDate'];
    $srch1->depTime = $_SESSION['depTime'];
    $srch1->arrTime = $_SESSION['arrTime'];
    $srch1->durationMin = $_SESSION['durationMin'];
    $srch1->pricePerPerson = $_SESSION['pricePerPerson'];
    
    if (isset($_SESSION['depAirportR'])) {
        $srch1->depAirportR = $_SESSION['depAirportR'];
        $srch1->destAirportR = $_SESSION['destAirportR'];
        $srch1->depDateR = $_SESSION['depDateR'];
        $srch1->depTimeR = $_SESSION['depTimeR'];
        $srch1->arrTimeR = $_SESSION['arrTimeR'];
        $srch1->durationMinR = $_SESSION['durationMinR'];
        $srch1->pricePerPersonR = $_SESSION['pricePerPersonR'];
    }

    require "../models/Passengers.php";
    $pass1=new Passengers();
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {

        $pass1->passengerName[$x]= $_SESSION['passengerName'.$x];
        $pass1->passengerSurname[$x]=$_SESSION['passengerSurname'.$x];
        $pass1->passengerTitle[$x]=$_SESSION['passengerTitle'.$x];
        $pass1->passengerSeat[$x]=$_SESSION['passengerSeat'.$x];
        $pass1->passengerInsurance[$x]=$_SESSION['insurance'.$x];
        $pass1->passengerInsuranceCost[$x]=$_SESSION['insuranceCost'.$x];
        $pass1->suitcaseNumber[$x]=$_SESSION['suitcaseNumber'.$x];


    }
    $pass1->checkIn=$_SESSION['checkIn'];
    $pass1->checkInCost=$_SESSION['checkInCost'];

}
else{
    echo "<script>window.location.href='../index.php'</script>";
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    require "../models/Pay.php";
    $pay1 = new Pay();

    

        $pay1->cardName= $_POST['card-name'];
        $pay1->cardNumber=$_POST['card-number'];
        $pay1->cardCVV=$_POST['card-cvv'];


    $pay1->validateCard();
    if($pay1->err==false){
        require "../models/Ticket.php";
        $ticket1= new Ticket();
        $ticket1->register_booking();
        for($x=1;$x<=$srch1->whosGoing;$x++)
        {
        $ticket1->register_passengers($x);
        if($_SESSION['flightType']=="return")
        $ticket1->register_passengersR($x);
        }
        //session_destroy();
        //session_start();
        
        echo "<script>window.location.href='../controllers/success.php'</script>";
        
    }
    else{

    
    $nameErr=$pay1->nameErr;
    $numErr=$pay1->numErr;
    $CVVErr=$pay1->CVVErr;
    }
}
include "../views/header6.html";
include "../views/checkout-view.php";
include "../views/footer.html";
        ?>