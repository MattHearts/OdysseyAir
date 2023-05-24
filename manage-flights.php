<?php
session_start();
include "header-admin.html";
include "admin-options.php";
//include "db_connection.php";

$options = new AdminOptions();
$flightList = $options->getFlightList();



?>

<link rel="stylesheet" href="admin.css?v=<?php echo time(); ?>">

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
                            echo "<td>" . " HOLDER" . "</td>";
                            echo "<td>" . $flight['dep_airport'] . "</td>";
                            echo "<td>" . $flight['dest_airport'] . "</td>";
                            echo "<td>" . $flight['dep_date'] . "</td>";
                            echo "<td>" . $flight['dep_time'] . "</td>";
                            echo "<td>" . $flight['arr_time'] . "</td>";
                            echo "<td>" . $flight['duration_min'] . " minutes</td>";
                            echo "<td>" . $flight['price'] . "</td>";
                            echo "<td><button class='edit-button' data-flight-id='" . $flight['flight_id'] . "' id='edit-flights-button'>Edit</button></td>";

                            echo "<td><button class='delete-button' onclick='deleteFlight(" . $flight['flight_id'] . ")'>Delete</button></td>";
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
            <input type="date" id="flight-date" name="flight_date" placeholder="Select date from calendar">


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


<!-- Pop-up Prompt -->
<div id="edit-flights-popup" class="popup">
    <div class="popup-content">
        <span class="close">&times;</span>
        <!-- Flight details form -->
        <form id="e-flight-form">

        <label for="e-flight-id">ID:</label>
            <input type="number" id="e-flight-id" name="e-flight-id" placeholder="Enter departure time"readonly>
            <!-- Departure Airport -->
            <label for="e-departure-airport">Departure Airport:</label>
            <select id="e-departure-airport" name="e-departure_airport">
                <!-- Options will be populated dynamically using AJAX -->
            </select>

            <!-- Destination Airport -->
            <label for="e-destination-airport">Destination Airport:</label>
            <select id="e-destination-airport" name="e-destination_airport">
                <!-- Options will be populated dynamically using AJAX -->
            </select>

            <!-- Date of Flight -->
            <label for="e-flight-date">Date of Flight:</label>
            <input type="date" id="e-flight-date" name="e-flight_date" placeholder="Select date from calendar">


            <!-- Departure Time -->
            <label for="e-departure-time">Departure Time:</label>
            <input type="text" id="e-departure-time" name="e-departure_time" placeholder="Enter departure time">

            <!-- Arrival Time -->
            <label for="e-arrival-time">Arrival Time:</label>
            <input type="text" id="e-arrival-time" name="e-arrival_time" placeholder="Enter arrival time">

            <!-- Duration of Flight -->
            <label for="e-flight-duration">Duration of Flight (minutes):</label>
            <input type="number" id="e-flight-duration" name="e-flight_duration">

            <label for="e-flight_price">Price:</label>
            <input type="number" id="e-price" name="e-flight_price">


            <!-- Submit Button -->
            <button type="submit" data-flight-id="<?php echo $flightId; ?>">Add Flight</button>

        </form>
    </div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>


    // Get the button element
    const addFlightsButton = document.getElementById('add-flights-button');
    const editFlightsButton = document.getElementById('edit-flights-button');

    // Get the pop-up prompt element
    const addFlightsPopup = document.getElementById('add-flights-popup');

    const editFlightsPopup = document.getElementById('edit-flights-popup');

    // Event listener for button click
    addFlightsButton.addEventListener('click', function () {
        // Show the pop-up prompt
        addFlightsPopup.style.display = 'block';

        // Fetch airport data using AJAX request to retrieve the airport names from the database
        $.ajax({
            url: 'fetch-airports.php',
            type: 'GET',
            dataType: 'json', // Set the expected response data type as JSON
            success: function (response) {
                console.log(response); // Log the response to the console for debugging

                // Check if the response is an array
                if (Array.isArray(response)) {
                    // Update the departure and destination airport dropdowns in the pop-up prompt
                    updateAirportDropdowns(response);
                } else {
                    alert('Invalid response format. Expected an array.');
                }
            },
            error: function (xhr, status, error) {
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
        $.each(airports, function (index, airport) {
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
    $('#flight-form').on('submit', function (event) {
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
            success: function (response) {
                // Display success message
                alert(response);

                // Close the pop-up prompt
                closeAddFlightsPopup();
                fetchFlightList();
            },
            error: function () {
                alert('Failed to add the flight. Please try again.');
            }
        });
    });


    // Add event listener for the delete button
    function deleteFlight(flightId) {
        // Confirm the deletion
        if (confirm('Are you sure you want to delete this flight?')) {
            // Send an AJAX request to move the flight to the cancelled-flights table
            $.ajax({
                url: 'cancel-flight.php',
                type: 'POST',
                data: { flightId: flightId },
                success: function (response) {
                    alert(response); // Display success message

                    // Refresh the flight list
                    fetchFlightList();
                },
                error: function () {
                    alert('Failed to move the flight to the cancelled-flights table. Please try again.');
                }
            });
        }
    }


    // Function to fetch the flight list
    function fetchFlightList() {
        // Send an AJAX request to fetch the updated flight list
        $.ajax({
            url: 'fetch-flight-list.php',
            type: 'GET',
            dataType: 'html',
            success: function (response) {
                // Update the flight list container with the updated flight list
                $('.flight-list-container').html(response);
            },
            error: function () {
                alert('Failed to fetch the flight list. Please check your network connection.');
            }
        });
    }
    // Add event listener for the edit button
    $(document).on('click', '.edit-button', function () {
        // Get the flight ID
        var flightId = $(this).data('flight-id');

        // Show the pop-up prompt
        $('#edit-flights-popup').css('display', 'block');

        // Fetch flight details using AJAX request to retrieve the data from the database
        $.ajax({
            url: 'fetch-flight-details.php',
            type: 'POST',
            data: { flightId: flightId },
            dataType: 'json',
            success: function (response) {
                console.log(response); // Log the response to the console for debugging

                // Check if the response is valid
                if (response) {
                    // Fill the fields in the edit flights pop-up with the retrieved data
                    fillEditFlightsForm(flightId,response);
                } else {
                    alert('Failed to fetch flight details. Please check the console for more details.');
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr); // Log the XMLHttpRequest object to the console for debugging
                console.log(status); // Log the status for debugging
                console.log(error); // Log the error for debugging
                alert('Failed to fetch flight details. Please check the console for more details.');
            }
        });
    });

    // Function to fill the fields in the edit flights form
    function fillEditFlightsForm(flightId,flightDetails) {
        // Fill the departure airport dropdown
        $.ajax({
            url: 'fetch-airports.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response); // Log the response to the console for debugging

                // Check if the response is an array
                if (Array.isArray(response)) {
                    var departureAirportDropdown = $('#e-departure-airport');
                    departureAirportDropdown.empty(); // Clear existing options

                    // Populate the departure airport dropdown with options
                    for (var i = 0; i < response.length; i++) {
                        var airport = response[i];
                        var option = $('<option>').val(airport).text(airport);
                        departureAirportDropdown.append(option);
                    }

                    // Set the selected value based on flight details
                    departureAirportDropdown.val(flightDetails.dep_airport);
                } else {
                    alert('Invalid response format. Expected an array for airports.');
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr); // Log the XMLHttpRequest object to the console for debugging
                console.log(status); // Log the status for debugging
                console.log(error); // Log the error for debugging
                alert('Failed to fetch airports. Please check the console for more details.');
            }
        });

        // Fill the destination airport dropdown
        $.ajax({
            url: 'fetch-airports.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response); // Log the response to the console for debugging

                // Check if the response is an array
                if (Array.isArray(response)) {
                    var destinationAirportDropdown = $('#e-destination-airport');
                    destinationAirportDropdown.empty(); // Clear existing options

                    // Populate the destination airport dropdown with options
                    for (var i = 0; i < response.length; i++) {
                        var airport = response[i];
                        var option = $('<option>').val(airport).text(airport);
                        destinationAirportDropdown.append(option);
                    }

                    // Set the selected value based on flight details
                    destinationAirportDropdown.val(flightDetails.dest_airport);
                } else {
                    alert('Invalid response format. Expected an array for airports.');
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr); // Log the XMLHttpRequest object to the console for debugging
                console.log(status); // Log the status for debugging
                console.log(error); // Log the error for debugging
                alert('Failed to fetch airports. Please check the console for more details.');
            }
        });

        // Fill other flight details fields
        $('#e-flight-id').val(flightId);
        $('#e-flight-date').val(flightDetails.dep_date);
        $('#e-departure-time').val(flightDetails.dep_time);
        $('#e-arrival-time').val(flightDetails.arr_time);
        $('#e-flight-duration').val(flightDetails.duration_min);
        $('#e-price').val(flightDetails.price);
    }

    // Close the pop-up prompt
    $('.close').on('click', function () {
        $('#edit-flights-popup').css('display', 'none');
    });

    // Submit the flight details form
    $('#e-flight-form').submit(function (event) {
        event.preventDefault();

        // Retrieve the form data
        var formData = $(this).serialize();

            // Add the flight_id to the form data
    var flightId = $(this).data('flight-id');
    formData += '&flightId=' + flightId;

        // Submit the form using AJAX request
        $.ajax({
            url: 'update-flight-details.php',
            type: 'POST',
            data: formData,



            success: function (response) {
                // Display success message
                alert(response);

                // Close the pop-up prompt
                closeAddFlightsPopup();
                fetchFlightList();
            },
            error: function () {
                alert('Failed to update flight details. Please check the console for more details..');
            }

        });
    });

        // Close Add Flights Popup
        function closeAddFlightsPopup() {
        $('#add-flights-popup').css('display', 'none');
        $('#edit-flights-popup').css('display', 'none');
    }


</script>



<?php
include "footer.html";
?>