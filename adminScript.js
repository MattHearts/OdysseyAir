

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


    function viewPassengers(flightID) {
      // Code to handle viewing passengers
      // Redirect to the passengers page for the selected flight
      window.location.href = 'manage-passengers.php?flightID=' + flightID;
    }

    function viewCancelledPassengers(flightID) {
        // Code to handle viewing passengers
        // Redirect to the passengers page for the selected flight
        window.location.href = 'view-cancelled-passengers.php?flightID=' + flightID;
      }

    function gotoCancelledFlights(){
        window.location.href = 'cancelled-flights.php';
    }


  