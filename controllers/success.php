<?php
session_start();




if (isset($_SESSION['bookingID'])) {
    require "../models/Search.php";
    $srch1 = new Search();
    $srch1->whosGoing = $_SESSION['whosGoing'];
    require "../models/Ticket.php";
    $ticket1=new Ticket();
    $ticket1->show_booking();
}
else{
    echo "<script>window.location.href='../index.php'</script>";
}
include "../views/header7.html";
include "../views/success-view.php";
include "../views/footer.html";
        ?>
