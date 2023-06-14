<?php
session_start();

$usernameErr="";
$surnameErr="";
$passwordErr="";
$txtSurname="";
$txtUsername="";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    require "../models/user.php";
    $usr1= new User();

    $txtUsername=$_POST['username'];
    $txtSurname=$_POST['surname'];

    $usr1->username= $_POST['username'];
    $usr1->password=$_POST['password'];
    $usr1->surname= $_POST['surname'];
    $usr1->type = 1;
    $usr1->register_user();

    $usernameErr=$usr1->usernameErr;
    $surnameErr=$usr1->surnameErr;
    $passwordErr=$usr1->passwordErr;

}
if(isset($_SESSION['username']) )
{
	echo "<script> window.location.href='../index.php'</script>";
}
else{
    if(isset($_SESSION['loggedToBook']) && $_SESSION['loggedToBook']==TRUE)
    {
        include "../views/header.html";
    }
    else{
        include "../views/header.html";
    }
    
    include "../views/register-view.php";
    include "../views/footer.html";    
    }

            

?>