<!DOCTYPE html>
<html>
<?php
session_start();

require "../models/Authentication.php";
$auth1=new Authentication();
require "../models/CheckInModel.php";
$check1=new CheckIn();
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);
if ($auth1->isAuthenticated($token)) {



}

else {
    echo "<script> window.location.href='../index.php'</script>";
}
if (!isset($_SESSION['checkInInfo'])||$_SESSION['checkInInfo']=="done") {
    echo "<script> window.location.href='../index.php'</script>";

}

if(isset($_SESSION['flightIDCheckin'])){
    $check1->flightIDCheck = $_SESSION['flightIDCheckin'];
    $check1->bookingIDCheck = $_SESSION['bookingIDCheckin'];
    $check1->flightTypeCheck = $_SESSION['flightTypeCheckin'];

    $check1->bookingCheck($check1->bookingIDCheck,$check1->flightTypeCheck);
}
else {
    echo "<script> window.location.href='../index.php'</script>";
}



if($_SERVER["REQUEST_METHOD"] == "POST")
{
    
    

    for($x=0;$x<$check1->x;$x++)
    {

        $check1->documentType[$x]= $_POST['document-type'.$x];
        $check1->documentNum[$x]= $_POST['document-num'.$x];
        $check1->countryOfIssue[$x]=$_POST['country-of-issue'.$x];
        $check1->nationality[$x]=$_POST['nationality'.$x];
        $check1->dateBirth[$x]=$_POST['dateBirth'.$x];
        
    }


    $check1->upload_info();
    $formErr=$check1->formErr;

}

include "../views/header.html";
include "../views/checkin-view.php";
include "../views/footer.html";
?>