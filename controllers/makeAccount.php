<?php
session_start();
if ($_GET['hasSearched'] == true) {

    $_SESSION["loggedToBook"] = true;
    include "../views/headerFlights.html";
    include "../views/makeAccount-view.php";
    include "../views/footer.html";
} else {
    header("Location: ../index.php");
    exit;
}
