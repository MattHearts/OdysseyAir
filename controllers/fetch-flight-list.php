<?php
session_start();
include "../models/admin-options.php";


if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $adminOptions = new AdminOptions();
    $flightList = $adminOptions->getFlightList();

    $html = '';


    if (!empty($flightList)) { ?>
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
                    echo "<td><button class='passengers-button' data-flight-id='" . $flight['flight_id'] . "' id='passengers-button'>Passengers</button></td>";
                    echo "<td><button class='edit-button' data-flight-id='" . $flight['flight_id'] . "' id='edit-flights-button'>Edit</button></td>";
                    echo "<td><button class='delete-button' onclick='deleteFlight(" . $flight['flight_id'] . ")'>Cancel</button></td>";
                    echo "</tr>";
                }
            } else {

                echo "<tr><td colspan='11'>No flights available</td></tr>";
            }
                ?>
                </tbody>
            </table>
        </div>
    <?php

    // Sends the flight list HTML markup as the response
    echo $html;
}
    ?>