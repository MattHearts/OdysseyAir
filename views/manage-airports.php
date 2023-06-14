<?php
session_start();
include "../views/header-admin.html";
include "../models/admin-options.php";


$options = new AdminOptions();
//$airportList = $options->getAiportList();

?>
<link rel="stylesheet" href="../css/admin.css?v=<?php echo time(); ?>">


<div class="layout2">
    <div class="flight-list">
        <h2 style="text-align: center;">Airport List</h2>
        <button class="add-flights-button" id="add-airport-button">Add Airports</button><br><br>
        <label for="countryDropdown">Select Country:</label>
            <select id="countryDropdown" name="countryDropdown">
                <!-- Options will be populated dynamically using AJAX -->
            </select>
        <div class="flight-list-container">
            
                <table>
                    <thead>
                        <tr>
                            <th>Airport ID</th>
                            <th>Airport City</th>
                            <th>Airport Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="airportList">
<!-- Airport list will be populated dynamically using AJAX -->
                    </tbody>
                </table>
            
        </div>
    </div>
</div>

<!-- Pop-up Prompt -->
<div id="add-airports-popup" class="popup">
    <div class="popup-content">
        <span class="close">&times;</span>
        <!-- Flight details form -->
        <form id="airport-form">

        <label for="airport-id">ID:</label>
            <input type="text" id="airport-id" name="airport-id"  required>
            <!-- Airport City -->
            <label for="airport-city">Airport City:</label>
            <input type="text" id="airport-city" name="airport-city" required>


            <!-- Airport Name -->
            <label for="airport-name">Airport Name:</label>
            <input type="text" id="airport-name" name="airport-name"required>

                        <!-- Airport Name -->
            <label for="airport-country">Airport Country:</label>
            <select id="airport-country" name="airport-country"required>
                <!-- Options will be populated dynamically using AJAX -->
            </select>


            <!-- Submit Button -->
            <button type="submit" data-airport-id="<?php echo $airportID; ?>">Add Flight</button>

        </form>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../js/adminAirportsScript.js"></script>
