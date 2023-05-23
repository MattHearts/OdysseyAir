<?php
session_start();

if($_SESSION["username"]){
    echo "<script> window.location.href='isLogged.php'</script>";
}
else{
    echo "<script> window.location.href='makeAccount.php'</script>";
}
?>