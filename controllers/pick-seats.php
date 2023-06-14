<?php
session_start();

require "../models/Seats.php";
$seatErr="";
$seats1= new Seats();
$seats1->find_free_seats();


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
    echo "something went wrong";
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {
        
        
        $pass1->passengerSeat[$x]= $_POST['seat'.$x];

    }
    $arr_unique = array_unique($pass1->passengerSeat);
    $check = count($pass1->passengerSeat) !== count($arr_unique);
    $seatErr ="";
    $arr_duplicates = [];
    if($check == 1) {
        $seatErr ="Please select different seats for each passenger";
        $arr_duplicates = array_diff_assoc($pass1->passengerSeat, $arr_unique);
    }
    else{
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {
    $_SESSION['passengerSeat'.$x]= $_POST['seat'.$x];
    }

    echo "<script>window.location.href='../controllers/incurance-details.php'</script>";
    }
}
include "../views/header4.html";
include "../views/pick-seats-view.php";
include "../views/footer.html";
        ?>





