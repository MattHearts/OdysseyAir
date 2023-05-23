<?php
session_start();
include "header7.html";



if (isset($_SESSION['bookingID'])) {
    require "Search.php";
    $srch1 = new Search();
    $srch1->whosGoing = $_SESSION['whosGoing'];
    require "Ticket.php";
    $ticket1=new Ticket();
    $ticket1->show_booking();
}
else{
    echo "<script>window.location.href='index.php'</script>";
}
?>
<div class="layout">
    <div class="content">
        <h1>Success! Thank you for booking with us</h1>
        <h2>Take a look at your booking:<h2>
            
           <?php 
           for($x=1;$x<=$srch1->whosGoing;$x++)
           {echo $ticket1->passengerTitleList[$x];
            echo $ticket1->passengerNameList[$x];
            echo $ticket1->passengerSurnameList[$x];}
           ?>
           
    </div>
</div>

<?php
            include "footer.html";
        ?>