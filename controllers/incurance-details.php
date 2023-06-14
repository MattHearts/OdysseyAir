<?php
session_start();


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
echo "<script>window.location.href='../index.php'</script>";
}

if (isset($_SESSION['checkIn'])) {
    require "../models/Passengers.php";
    $pass1=new Passengers();
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {

        $pass1->passengerName[$x]= $_SESSION['passengerName'.$x];
        $pass1->passengerSurname[$x]=$_SESSION['passengerSurname'.$x];
        $pass1->passengerTitle[$x]=$_SESSION['passengerTitle'.$x];


    }
    $pass1->checkIn=$_SESSION['checkIn'];
    $pass1->checkInCost=$_SESSION['checkInCost'];
}
else{
    echo "<script>window.location.href='../index.php'</script>";
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {
    $_SESSION['insurance'.$x]= $_POST['insurance'.$x];
    if($_POST['insurance'.$x]=="noInsurance"){
        $_SESSION['insuranceCost'.$x]=0;
        $_SESSION['insurance'.$x]="no_insurance";
    }
    else{
        $_SESSION['insuranceCost'.$x]=8;
        $_SESSION['insurance'.$x]="go_insurance";
    }
    
    }
    echo "<script>window.location.href='../controllers/checkout.php'</script>";

}
include "../views/header5.html";
include "../views/incurance-details-view.php";
include "../views/footer.html";
        ?>
