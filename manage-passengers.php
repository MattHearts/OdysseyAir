<?php
session_start();
include "header-admin.html";
include "admin-options.php";

$flightID=$_GET['flightID'];

$options = new AdminOptions();
$passengersList = $options->getPassengersList($flightID);
?>

<link rel="stylesheet" href="admin.css?v=<?php echo time(); ?>">

<div class="layout2">
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
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            
        </div>
    </div>
</div>

<?php
include "footer.html";
?>