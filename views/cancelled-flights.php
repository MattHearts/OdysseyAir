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
        $flightList = $options->getCancelledFlightsList();
?>

        <link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">

        <div class="layout2">
            <div class="flight-list">
                <h2 style="text-align: center; color: red;">Cancelled Flights List</h2>
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
                                echo "<td><button class='passengers-button' onclick='viewPassengers(" . $flight['flight_id'] . ")' id='cancelled-passengers-button'>Passengers</button></td>";
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
    } else {
        echo "<script> window.location.href='../index.php'</script>";
    }
} else {
    echo "<script> window.location.href='../index.php'</script>";
}
?>