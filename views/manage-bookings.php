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

        if (isset($_GET['username'])) {
            $selectedUsername = $_GET['username'];

            $options = new AdminOptions();
            $bookingsList = $options->getAccountBookings($selectedUsername);
?>

            <link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">
            <?php
            if (is_array($bookingsList) && !empty($bookingsList)) {
               
            ?>

                <div class="layout2">
                    <div class="flight-list">
                        <h2 style="text-align: center;"><?php echo $selectedUsername; ?> Bookings</h2>
                        <?php foreach ($bookingsList as $booking) { ?>
                            <div class="booking-box">
                                Booking ID: <?php echo $booking['booking_id']; ?><br>
                                Date Booked: <?php echo $booking['book_date']; ?><br>
                                Time Booked: <?php echo $booking['book_time']; ?><br>
                                Price: <?php echo $booking['book_price']; ?><br>
                                ______________________________________________________
                                <br>
                                <div class="go-flights">
                                    Flight ID: <?php echo $booking['flight_id']; ?><br>
                                    Departure Airport: <?php echo $booking['dep_airport']; ?><br>
                                    Arrival Airport: <?php echo $booking['dest_airport']; ?><br>
                                    Departure Date: <?php echo $booking['dep_date']; ?><br>
                                    Departure Time: <?php echo substr($booking['dep_time'], 0, 5); ?><br>
                                    Arrival Time: <?php echo substr($booking['arr_time'], 0, 5); ?><br>
                                    Status: <?php echo $booking['status']; ?><br>
                                </div>
                                <?php if ($booking['isReturn'] == true) { ?>
                                    <div class="return-flights">
                                        Flight ID (Return): <?php echo $booking['flight_idR']; ?><br>
                                        Departure Airport (Return): <?php echo $booking['dep_airportR']; ?><br>
                                        Arrival Airport (Return): <?php echo $booking['dest_airportR']; ?><br>
                                        Departure Date (Return): <?php echo $booking['dep_dateR']; ?><br>
                                        Departure Time (Return): <?php echo substr($booking['dep_timeR'], 0, 5); ?><br>
                                        Arrival Time (Return): <?php echo substr($booking['arr_timeR'], 0, 5); ?><br>
                                        Status: <?php echo $booking['statusR']; ?><br>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="booking-list-container">
                                <div>
                                    <label for="search-input">Search:</label>
                                    <input type="text" id="search-input" oninput="performSearch()">
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Passenger ID</th>
                                            <th>Title</th>
                                            <th>Name</th>
                                            <th>Surname</th>
                                            <th>Seat</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($booking['passengers'] as $passenger) { ?>
                                            <tr>
                                                <td><?php echo $passenger['passenger_id']; ?></td>
                                                <td><?php echo $passenger['title']; ?></td>
                                                <td><?php echo $passenger['name']; ?></td>
                                                <td><?php echo $passenger['surname']; ?></td>
                                                <td><?php echo $passenger['seat']; ?></td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php
            } else {

            ?>

                <div class="layout2">
                    <div class="flight-list">
                        <h2 style="text-align: center;"><?php echo $selectedUsername; ?> Bookings</h2>
                        <p>No bookings found for the selected account.</p>
                        <div id="log-message"></div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../js/adminBookingsScript.js"></script>
        <script src="../js/adminCommonScript.js"></script>
<?php
        include "../views/footer.html";
    } else {
        echo "<script> window.location.href='../index.php'</script>";
    }
} else {
    echo "<script> window.location.href='../index.php'</script>";
} ?>