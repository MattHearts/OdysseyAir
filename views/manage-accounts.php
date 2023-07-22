<?php
session_start();
include "../views/header-admin.html";
include "../models/admin-options.php";


$options = new AdminOptions();
$userList = $options->getUserList();

?>
<link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">

<div class="layout2">
    <div class="flight-list">
        <h2 style="text-align: center;">Accounts List</h2>
    

        <div class="flight-list-container">
        <div>
                <label for="search-input">Search:</label>
                <input type="text" id="search-input" oninput="performSearch()">
            </div>
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
                            echo "<td><button class='bookings-button' onclick='viewAccountBookings(\"" . $user['username'] . "\")' id='bookings-button'>Bookings</button></td>";
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