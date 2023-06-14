<?php
session_start();

if($_SESSION["username"]){
    echo "<script> window.location.href='../controllers/passenger-details.php'</script>";
}
else{
    echo "<script> window.location.href='../controllers/makeAccount.php?hasSearched=true';</script>";
}
?>