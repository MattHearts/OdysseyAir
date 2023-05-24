<?php
session_start();
include "admin-options.php";


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        // Instantiate the AdminOptions class
        $adminOptions = new AdminOptions();
    $flightList = $adminOptions->getFlightList();

    $html = '';

// Check if there are flights in the list
if (!empty($flightList)) {?>
            <div class="flight-list">
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
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
    foreach ($flightList as $flight) {
        echo "<tr>";
        echo "<td>" . $flight['flight_id'] . "</td>";
        echo "<td>HOLDER</td>";
        echo "<td>" . $flight['dep_airport'] . "</td>";
        echo "<td>" . $flight['dest_airport'] . "</td>";
        echo "<td>" . $flight['dep_date'] . "</td>";
        echo "<td>" . $flight['dep_time'] . "</td>";
        echo "<td>" . $flight['arr_time'] . "</td>";
        echo "<td>" . $flight['duration_min'] . " minutes</td>";
        echo "<td>" . $flight['price'] . "</td>";
        echo "<td><button class='edit-button'>Edit</button></td>";
        echo "<td><button class='delete-button' data-flight-id='" . $flight['flight_id'] . "'>Delete</button></td>";
        echo "</tr>";
    }
} else {
    // If there are no flights in the list, display a message
    echo "<tr><td colspan='11'>No flights available</td></tr>";
}
?>
                    </tbody>
                </table>
            </div>
            <?php

// Send the flight list HTML markup as the response
echo $html;
}
?>
