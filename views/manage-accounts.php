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
        $userList = $options->getUserList();

?>
        <link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">

        <div class="layout2">
            <div class="flight-list">
                <h2 style="text-align: center;">Accounts List</h2>

                <div class="search-box">
                    <label for="search-input">Search:</label>
                    <input type="text" id="search-input" oninput="performSearch()">
                </div>
                <div class="flight-list-container">

                    <table>
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Surname</th>
                                <th>Account Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($userList as $user) {
                                echo "<tr>";
                                echo "<td>" . $user['username'] . "</td>";
                                echo "<td>" . $user['surname'] . "</td>";
                                echo "<td>" . $user['type'] . "</td>";
                                echo "<td><button class='bookings-button' onclick='viewAccountBookings(\"" . $user['username'] . "\")' 
                        id='bookings-button'>Bookings</button></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="../js/adminAccountsScript.js"></script>
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