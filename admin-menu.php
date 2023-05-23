<?php
session_start();

if (isset($_POST['add-flights-button'])) {
    header("Location: manage-flights.php");
    exit();
}

if (isset($_POST['manage-passengers-button'])) {
    header("Location: manage-passengers.php");
    exit();
}

include "header-admin.html";

?>

<div class="layout">
    <div class="options-box">
        <h2 style="text-align: center;">Choose one of the following:</h2>
        <div class="options-buttons">
            <form method="post">
                <button type="submit" name="add-flights-button" class="add-flights-button">Add/Remove flights</button>
            </form>
            <form method="post">
                <button type="submit" name="manage-passengers-button" class="manage-passengers-button">Manage Passengers</button>
            </form>
        </div>
    </div>
</div>

<?php
include "footer.html";
?>
