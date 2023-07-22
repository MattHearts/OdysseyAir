<?php
session_start();
include "../views/header-admin.html";
include "../models/admin-options.php";

$passengerID = $_GET['passengerID'];

$options = new AdminOptions();
// Assuming you have a function to fetch passenger document info based on the passengerID
$passengerDocumentInfo = $options->getPassengerDocumentInfo($passengerID);

?>

<link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">

<div class="layout2">
    <div class="flight-list">
        <h2 style="text-align: center;">Flight List</h2>
        <div class="flight-list-container">
        <div>
                <label for="search-input">Search:</label>
                <input type="text" id="search-input" oninput="performSearch()">
            </div>
                <table>
                    <thead>
                        <tr>
                            <th>Check In ID</th>
                            <th>Passenger ID</th>
                            <th>Document Type</th>
                            <th>Document Number</th>
                            <th>Country of Issue</th>
                            <th>Nationality</th>
                            <th>Date of Birth</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($passengerDocumentInfo as $passengerInfo) {
                            echo "<tr>";
                            echo "<td>" . $passengerInfo['check_in_id'] . "</td>";
                            echo "<td>" . $passengerInfo['passenger_id'] . "</td>";
                            echo "<td>" . $passengerInfo['document_type'] . "</td>";
                            echo "<td>" . $passengerInfo['document_num'] . "</td>";
                            echo "<td>" . $passengerInfo['country_of_issue'] . "</td>";
                            echo "<td>" . $passengerInfo['nationality'] . "</td>";
                            echo "<td>" . $passengerInfo['date_birth'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../js/adminScript.js"></script>
<script src="../js/adminCommonScript.js"></script>
<?php
include "../views/footer.html";
?>