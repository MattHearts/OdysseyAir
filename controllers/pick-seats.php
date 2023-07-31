<?php
session_start();

require "../models/Seats.php";
$seatErr="";
$flight_id=$_SESSION['flightID'];
$seats1= new Seats();
$seats1->find_free_seats($flight_id);
if($_SESSION['flightType']=="return"){
    $flight_id_r=$_SESSION['flightIDR'];
    $seats1->find_free_seats_r($flight_id_r);
}




if (isset($_SESSION['checkIn'])&&$_SESSION['isPurchaceComplete']==false) {

    require "../models/Search.php";
    $srch1 = new Search();

    $srch1->whosGoing = $_SESSION['whosGoing'];

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
    echo "<script>window.location.href='../controllers/index.php'</script>";
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {
        
        
        $pass1->passengerSeat[$x]= $_POST['seat'.$x];
        if($_SESSION['flightType']=="return"){
            $pass1->passengerSeatR[$x]= $_POST['seatR'.$x];
        }

    }
    $arr_unique = array_unique($pass1->passengerSeat);
    $check = count($pass1->passengerSeat) !== count($arr_unique);
    $seatErr ="";
    $arr_duplicates = [];
    $checkR=0;
    if($_SESSION['flightType']=="return"){
        $arr_uniqueR = array_unique($pass1->passengerSeatR);
        $checkR = count($pass1->passengerSeatR) !== count($arr_uniqueR);
    }
    
    if($check == 1||$checkR == 1) {
        $seatErr ="Please select different seats for each passenger";
        $arr_duplicates = array_diff_assoc($pass1->passengerSeat, $arr_unique);
    }
    else{
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {
    $_SESSION['passengerSeat'.$x]= $_POST['seat'.$x];
    if($_SESSION['flightType']=="return"){
        $_SESSION['passengerSeatR'.$x]= $_POST['seatR'.$x];
    }
    }

    echo "<script>window.location.href='../controllers/incurance-details.php'</script>";
    }
}

include "../views/header4.html";
include "../views/pick-seats-view.php";
include "../views/footer.html";
        ?>





