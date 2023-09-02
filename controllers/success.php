<?php
session_start();
$_SESSION['checkInInfo'] = "working";

require "../models/Authentication.php";
$auth1 = new Authentication();
// Collects token
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);

// Checks if user is authenticated
if ($auth1->isAuthenticated($token)) {
    // Collects the data from SESSION
    if (isset($_SESSION['bookingID'])) {
        require "../models/Search.php";
        $srch1 = new Search();
        $srch1->whosGoing = $_SESSION['whosGoing'];
        require "../models/Ticket.php";
        $ticket1 = new Ticket();
        $ticket1->show_booking();

        // Checks if the PDF generation is requested
        if (isset($_GET['generatePDF']) && $_GET['generatePDF'] === 'true') {
            // Generates and serves the PDF receipt
            $ticket1->generateReceiptPDF();
        } else {

            include "../views/header7.html";
            include "../views/success-view.php";
            include "../views/footer.html";
        }
        $_SESSION['isPurchaceComplete'] = true;
    } else {
        echo "<script>window.location.href='index.php'</script>";
    }
    // Collects the data from POST method
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["bookingID"])) {
            $bookingID = $_POST["bookingID"];

            $_SESSION["bookingIDCheckin"] = $bookingID;

            echo "<script>window.location.href='manage-my-flights.php'</script>";
            exit;
        }
    }
} else {
    echo "<script> window.location.href='../index.php'</script>";
}
