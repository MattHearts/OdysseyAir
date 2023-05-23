<?php
session_start();
include "header-admin.html";
include "admin-options.php";
//include "db_connection.php";

$options = new AdminOptions();
$flightList = $options->getFlightList();
?>



<div class="layout2">
    <div class="flight-list">
        <h2 style="text-align: center;">Flight List</h2>
        <button class="add-flights-button" id="add-flights-button">Add Flights</button>
        <div class="flight-list-container">
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
                            <th>Duration (minutes)</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($flightList as $flight) {
                            echo "<tr>";
                            echo "<td>" . $flight['flight_id'] . "</td>";
                            echo "<td>" ." HOLDER" . "</td>";
                            echo "<td>" . $flight['dep_airport'] . "</td>";
                            echo "<td>" . $flight['dest_airport'] . "</td>";
                            echo "<td>" . $flight['dep_date'] . "</td>";
                            echo "<td>" . $flight['dep_time'] . "</td>";
                            echo "<td>" . $flight['arr_time'] . "</td>";
                            echo "<td>" . $flight['duration_min'] . "</td>";
                            echo "<td>" . $flight['price'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- Pop-up Prompt -->
<div id="add-flights-popup" class="popup">
    <div class="popup-content">
        <span class="close">&times;</span>
        <!-- Flight details form -->
        <form id="flight-form">
            <!-- Departure Airport -->
            <label for="departure-airport">Departure Airport:</label>
            <select id="departure-airport" name="departure_airport">
                <!-- Options will be populated dynamically using AJAX -->
            </select>

            <!-- Destination Airport -->
            <label for="destination-airport">Destination Airport:</label>
            <select id="destination-airport" name="destination_airport">
                <!-- Options will be populated dynamically using AJAX -->
            </select>

            <!-- Date of Flight -->
            <label for="flight-date">Date of Flight:</label>
            <input type="text" id="flight-date" name="flight_date" placeholder="Select date from calendar">

            <!-- Departure Time -->
            <label for="departure-time">Departure Time:</label>
            <input type="text" id="departure-time" name="departure_time" placeholder="Enter departure time">

            <!-- Arrival Time -->
            <label for="arrival-time">Arrival Time:</label>
            <input type="text" id="arrival-time" name="arrival_time" placeholder="Enter arrival time">

            <!-- Duration of Flight -->
            <label for="flight-duration">Duration of Flight (minutes):</label>
            <input type="number" id="flight-duration" name="flight_duration">

            <label for="flight_price">Price:</label>
            <input type="number" id="price" name="flight_price">

            <label for="repeat-weeks">Repeat for how many weeks:</label>
<input type="number" id="repeat-weeks" name="repeat-weeks" min="1" required>

            <!-- Submit Button -->
            <button type="submit">Add Flight</button>
        </form>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // Get the button element
    const addFlightsButton = document.getElementById('add-flights-button');

    // Get the pop-up prompt element
    const addFlightsPopup = document.getElementById('add-flights-popup');

    // Event listener for button click
    addFlightsButton.addEventListener('click', function () {
        // Show the pop-up prompt
        addFlightsPopup.style.display = 'block';

        // Fetch airport data using AJAX request to retrieve the airport names from the database
        $.ajax({
            url: 'fetch-airports.php',
            type: 'GET',
            dataType: 'json', // Set the expected response data type as JSON
            success: function(response) {
                console.log(response); // Log the response to the console for debugging

                // Check if the response is an array
                if (Array.isArray(response)) {
                    // Update the departure and destination airport dropdowns in the pop-up prompt
                    updateAirportDropdowns(response);
                } else {
                    alert('Invalid response format. Expected an array.');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr); // Log the XMLHttpRequest object to the console for debugging
                console.log(status); // Log the status for debugging
                console.log(error); // Log the error for debugging
                alert('Failed to fetch airports. Please check the console for more details.');
            }
        });
    });

    // Update Airport Dropdowns with fetched data
    function updateAirportDropdowns(airports) {
        var departureAirportSelect = $('#departure-airport');
        var destinationAirportSelect = $('#destination-airport');

        // Clear existing options
        departureAirportSelect.empty();
        destinationAirportSelect.empty();

        // Add new options
        $.each(airports, function(index, airport) {
            departureAirportSelect.append($('<option></option>').text(airport));
            destinationAirportSelect.append($('<option></option>').text(airport));
        });
    }

    // Close button functionality
    const closeButton = document.querySelector('.close');
    closeButton.addEventListener('click', function () {
        addFlightsPopup.style.display = 'none';
    });

    // Flight Details Form Submission
    $('#flight-form').on('submit', function(event) {
        event.preventDefault();

        // Get the form data
        var formData = $(this).serialize();

        // Perform validation on the form data
        // Ensure all required fields are filled

        // Submit the form via AJAX request
        $.ajax({
            url: 'add-flight.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Display success message
                alert(response);
                
                // Close the pop-up prompt
                closeAddFlightsPopup();
            },
            error: function() {
                alert('Failed to add the flight. Please try again.');
            }
        });
    });

    // Close Add Flights Popup
    function closeAddFlightsPopup() {
        $('#add-flights-popup').css('display', 'none');
    }
</script>



<?php
include "footer.html";
?>