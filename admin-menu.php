<?php
session_start();


if (isset($_POST['manage-flights-button'])) {
    header("Location: manage-flights.php");
    exit();
}

if (isset($_POST['manage-passengers-button'])) {
    header("Location: manage-passengers.php");
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
            
                <button type="submit" name="manage-passengers-button" class="manage-passengers-button">Manage Passengers</button>
                </div>
            </form>
        
    </div>
</div>

<?php
include "footer.html";
?>
