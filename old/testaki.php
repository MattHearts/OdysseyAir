<?php
session_start();
for ($x=1;$x<=$_SESSION['whosGoing'];$x++){
echo $_SESSION['passengerName'.$x]." ".
$_SESSION['passengerSurname'.$x]." ".
$_SESSION['passengerTitle'.$x]." ".
$_SESSION['passengerSeat'.$x]." ".
$_SESSION['incurance'.$x]." ".
$_SESSION['incuranceCost'.$x]." ";}
echo $_SESSION['checkIn'];
?>