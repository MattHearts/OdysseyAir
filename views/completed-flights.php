<?php
session_start();
require "../models/Authentication.php";
$auth1 = new Authentication();
// Selects token
$token = isset($_COOKIE['auth_token']) ? $_COOKIE['auth_token'] : (isset($_SESSION['auth_token']) ? $_SESSION['auth_token'] : null);

if ($auth1->isAuthenticated($token)) {
    $username = $_SESSION['username'];
    // Check if user is admin
    if ($auth1->isAdmin($username)) {
        include "../views/header-admin.html";
        include "../models/admin-options.php";


        $options = new AdminOptions();
        $flightList = $options->getCompletedFlightList();



?>

        <link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">

        <div class="layout2">
            <div class="flight-list">
                <h2 style="text-align: center;">Completed Flight List</h2>

                <div class="flight-list-container">
                    <div>
                        <label for="search-input">Search:</label>
                        <input type="text" id="search-input" oninput="performSearch()">
                    </div>
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
                                echo "<td><button class='passengers-button' onclick='viewPassengers(" . $flight['flight_id'] . ")' id='passengers-button'>Passengers</button></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>



        <!-- Pop-up Prompt -->
        <div id="add-flights-popup" class="popup">
            <div class="popup-content">
                <span class="close">&times;</span>

                <form id="flight-form">

                    <label for="departure-airport">Departure Airport:</label>
                    <select id="departure-airport" name="departure_airport">
                        <!-- Options are populated using AJAX -->
                    </select>


                    <label for="destination-airport">Destination Airport:</label>
                    <select id="destination-airport" name="destination_airport">
                        <!-- Options are populated using AJAX -->
                    </select>

                    <label for="flight-date">Date of Flight:</label>
                    <input type="date" id="flight-date" name="flight_date" placeholder="Select date from calendar">

                    <label for="departure-time">Departure Time:</label>
                    <input type="text" id="departure-time" name="departure_time" placeholder="Enter departure time">

                    <label for="arrival-time">Arrival Time:</label>
                    <input type="text" id="arrival-time" name="arrival_time" placeholder="Enter arrival time">

                    <label for="flight-duration">Duration of Flight (minutes):</label>
                    <input type="number" id="flight-duration" name="flight_duration">

                    <label for="flight_price">Price:</label>
                    <input type="number" id="price" name="flight_price">

                    <label for="repeat-weeks">Repeat for how many weeks:</label>
                    <input type="number" id="repeat-weeks" name="repeat-weeks" min="1" required>

                    <button type="submit">Add Flight</button>
                </form>
            </div>
        </div>


        <!-- Pop-up Prompt -->
        <div id="edit-flights-popup" class="popup">
            <div class="popup-content">
                <span class="close">&times;</span>
                <form id="e-flight-form">

                    <label for="e-flight-id">ID:</label>
                    <input type="number" id="e-flight-id" name="e-flight-id" placeholder="Enter departure time" readonly>
                    <label for="e-departure-airport">Departure Airport:</label>
                    <select id="e-departure-airport" name="e-departure_airport">
                        <!-- Options are populated using AJAX -->
                    </select>

                    <label for="e-destination-airport">Destination Airport:</label>
                    <select id="e-destination-airport" name="e-destination_airport">
                        <!-- Options are populated using AJAX -->
                    </select>

                    <label for="e-flight-date">Date of Flight:</label>
                    <input type="date" id="e-flight-date" name="e-flight_date" placeholder="Select date from calendar">

                    <label for="e-departure-time">Departure Time:</label>
                    <input type="text" id="e-departure-time" name="e-departure_time" placeholder="Enter departure time">

                    <label for="e-arrival-time">Arrival Time:</label>
                    <input type="text" id="e-arrival-time" name="e-arrival_time" placeholder="Enter arrival time">

                    <label for="e-flight-duration">Duration of Flight (minutes):</label>
                    <input type="number" id="e-flight-duration" name="e-flight_duration">

                    <label for="e-flight_price">Price:</label>
                    <input type="number" id="e-price" name="e-flight_price">

                    <button type="submit" data-flight-id="<?php echo $flightId; ?>">Add Flight</button>

                </form>
            </div>
        </div>



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../js/adminScript.js"></script>
        <script src="../js/adminCommonScript.js"></script>



<?php
        include "../views/footer.html";
    } else {
        echo "<script> window.location.href='../index.php'</script>";
    }
} else {
    echo "<script> window.location.href='../index.php'</script>";
}
?>