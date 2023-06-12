<?php
session_start();
include "header-admin.html";
include "admin-options.php";


$options = new AdminOptions();
$flightList = $options->getCancelledFlightsList();
?>

<link rel="stylesheet" href="admin.css?v=<?php echo time(); ?>">

<div class="layout2">
    <div class="flight-list">
        <h2 style="text-align: center; color: red;">Cancelled Flights List</h2>
        <div class="flight-list-container">
            
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Flight Code</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Date</th>
                            <th>Departure Time</th>
                            <th>Arrival Time</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th></th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($flightList as $flight) {
                            echo "<tr>";
                            echo "<td>" . $flight['flight_id'] . "</td>";
                            echo "<td>" . " HOLDER" . "</td>";
                            echo "<td>" . $flight['dep_airport'] . "</td>";
                            echo "<td>" . $flight['dest_airport'] . "</td>";
                            echo "<td>" . $flight['dep_date'] . "</td>";
                            echo "<td>" . $flight['dep_time'] . "</td>";
                            echo "<td>" . $flight['arr_time'] . "</td>";
                            echo "<td>" . $flight['duration_min'] . " minutes</td>";
                            echo "<td>" . $flight['price'] . "</td>";
                            echo "<td><button class='passengers-button' onclick='viewCancelledPassengers(" . $flight['flight_id'] . ")' id='cancelled-passengers-button'>Passengers</button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="adminScript.js"></script>

<?php
include "footer.html";
?>