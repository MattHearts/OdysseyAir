<?php
session_start();
include "../views/header-admin.html";
include "../models/admin-options.php";

$flightID=$_GET['flightID'];

$options = new AdminOptions();
$passengersList = $options->getCancelledPassengersList($flightID);
?>

<link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">

<div class="layout-passengers">
    <div class="flight-list">
        <h2 style="text-align: center;">Flight List</h2>
        <div class="flight-list-container">
            
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Flight ID</th>
                            <th>Booking ID</th>
                            <th>Title</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Seat</th>
                            <th>Insurance</th>
                            <th>Baggage Number</th>
                            <th>Trip Type</th>
                            <th>Check in Method</th>
                            <th>Is Checked Ιn</th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($passengersList as $passenger) {
                            echo "<tr>";
                            echo "<td>" . $passenger['passenger_id'] . "</td>";
                            echo "<td>" . $flightID . "</td>";
                            echo "<td>" . $passenger['booking_id'] . "</td>";
                            echo "<td>" . $passenger['title'] . "</td>";
                            echo "<td>" . $passenger['name'] . "</td>";
                            echo "<td>" . $passenger['surname'] . "</td>";
                            echo "<td>" . $passenger['seat'] . "</td>";
                            echo "<td>" . $passenger['insurance'] . "</td>";
                            echo "<td>" . $passenger['baggage_num'] . "</td>";
                            echo "<td>" . $passenger['trip_type'] . "</td>";
                            echo "<td>" . $passenger['checkin_type'] . "</td>";
                            echo "<td>" . $passenger['isChecked'] . "</td>";
                             // Add the Document Info button
                             echo "<td><button class='passengers-button' onclick='viewPassengerDoc(" . $passenger['passenger_id'] . ")' id='passenger-info-button'>Document Info</button></td>";
                            
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