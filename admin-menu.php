<?php
session_start();


if (isset($_POST['manage-flights-button'])) {
    header("Location: manage-flights.php");
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

include "header-admin.html";

?>
<link rel="stylesheet" href="admin.css?v=<?php echo time(); ?>">
<div class="layout">
    <div class="options-box">
        <h2 style="text-align: center;">Choose one of the following:</h2>
        
            <form method="post">
            <div class="options-buttons">
                <button type="submit" name="manage-flights-button" class="manage-flights-button">Add/Remove flights</button>
                <button type="submit" name="manage-airports-button" class="manage-airports-button">Manage Airports</button>
                <button type="submit" name="manage-accounts-button" class="manage-accounts-button">Manage Accounts</button>
                </div>
            </form>
        
    </div>
</div>

<?php
include "footer.html";
?>
