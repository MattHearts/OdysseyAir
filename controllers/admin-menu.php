<?php
session_start();


if (isset($_POST['manage-flights-button'])) {
    header("Location: ../views/manage-flights.php");
    exit();
}

if (isset($_POST['manage-airports-button'])) {
    header("Location: manage-airports.php");
    exit();
}
if (isset($_POST['manage-accounts-button'])) {
    header("Location: manage-accounts.php");
    exit();
}

include "../views/header-admin.html";
include "../views/admin-menu-view.php";
include "../views/footer.html";
?>
