<?php
session_start();

$_SESSION['checkInInfo']="working";


if (isset($_SESSION['bookingID'])) {
    require "../models/Search.php";
    $srch1 = new Search();
    $srch1->whosGoing = $_SESSION['whosGoing'];
    require "../models/Ticket.php";
    $ticket1=new Ticket();
    $ticket1->show_booking();

    
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["bookingID"])) {
      $bookingID = $_POST["bookingID"];
  
      // Save the bookingID in the session
      $_SESSION["bookingIDCheckin"] = $bookingID;
  
      // Redirect to another page after processing
      echo "<script>window.location.href='manage-my-flights.php'</script>";
      exit; // Make sure to exit after redirection
    }
  }

include "../views/header7.html";
include "../views/success-view.php";
include "../views/footer.html";
        ?>
