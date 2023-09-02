
const addFlightsButton = document.getElementById('add-flights-button');
const editFlightsButton = document.getElementById('edit-flights-button');

const addFlightsPopup = document.getElementById('add-flights-popup');
const editFlightsPopup = document.getElementById('edit-flights-popup');

// Event listener for "Add Flights" button click
addFlightsButton.addEventListener('click', function () {
    addFlightsPopup.style.display = 'block';

    // Fetches airport data using AJAX request to retrieve the airport names from the database
    $.ajax({
        url: '../controllers/fetch-airports.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (Array.isArray(response)) {
                updateAirportDropdowns(response);
            } else {
                alert('Invalid response format. Expected an array.');
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
            alert('Failed to fetch airports. Please check the console for more details.');
        }
    });
});

// Updates Airport Dropdowns with fetched data
function updateAirportDropdowns(airports) {
    var departureAirportSelect = $('#departure-airport');
    var destinationAirportSelect = $('#destination-airport');

    departureAirportSelect.empty();
    destinationAirportSelect.empty();

    $.each(airports, function (index, airport) {
        departureAirportSelect.append($('<option></option>').text(airport));
        destinationAirportSelect.append($('<option></option>').text(airport));
    });
}

// Close button
const closeButton = document.querySelector('.close');
closeButton.addEventListener('click', function () {
    addFlightsPopup.style.display = 'none';
    editFlightsPopup.style.display = 'none';
});

// Flight Details Form Submission
$('#flight-form').on('submit', function (event) {
    event.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
        url: '../controllers/add-flight.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            alert(response);
            closeAddFlightsPopup();
            fetchFlightList();
        },
        error: function () {
            alert('Failed to add the flight. Please try again.');
        }
    });
});

// Function to delete a flight
function deleteFlight(flightId) {
    if (confirm('Are you sure you want to delete this flight?')) {
        $.ajax({
            url: '../controllers/cancel-flight.php',
            type: 'POST',
            data: { flightId: flightId },
            success: function (response) {
                alert(response);
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
    $.ajax({
        url: '../controllers/fetch-flight-list.php',
        type: 'GET',
        dataType: 'html',
        success: function (response) {
            $('.flight-list-container').html(response);
        },
        error: function () {
            alert('Failed to fetch the flight list. Please check your network connection.');
        }
    });
}

// Event listener for the "Edit" button
$(document).on('click', '.edit-button', function () {
    var flightId = $(this).data('flight-id');
    $('#edit-flights-popup').css('display', 'block');

    // Fetches flight details using AJAX request to retrieve the data from the database
    $.ajax({
        url: '../controllers/fetch-flight-details.php',
        type: 'POST',
        data: { flightId: flightId },
        dataType: 'json',
        success: function (response) {
            if (response) {
                fillEditFlightsForm(flightId, response);
            } else {
                alert('Failed to fetch flight details. Please check the console for more details.');
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
            alert('Failed to fetch flight details. Please check the console for more details.');
        }
    });
});

// Function to fill the fields in the edit flights form
function fillEditFlightsForm(flightId, flightDetails) {
    // Fills the departure airport dropdown
    $.ajax({
        url: '../controllers/fetch-airports.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (Array.isArray(response)) {
                var departureAirportDropdown = $('#e-departure-airport');
                departureAirportDropdown.empty();

                for (var i = 0; i < response.length; i++) {
                    var airport = response[i];
                    var option = $('<option>').val(airport).text(airport);
                    departureAirportDropdown.append(option);
                }

                departureAirportDropdown.val(flightDetails.dep_airport);
            } else {
                alert('Invalid response format. Expected an array for airports.');
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
            alert('Failed to fetch airports. Please check the console for more details.');
        }
    });

    // Fills the destination airport dropdown
    $.ajax({
        url: '../controllers/fetch-airports.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (Array.isArray(response)) {
                var destinationAirportDropdown = $('#e-destination-airport');
                destinationAirportDropdown.empty();

                for (var i = 0; i < response.length; i++) {
                    var airport = response[i];
                    var option = $('<option>').val(airport).text(airport);
                    destinationAirportDropdown.append(option);
                }

                destinationAirportDropdown.val(flightDetails.dest_airport);
            } else {
                alert('Invalid response format. Expected an array for airports.');
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
            alert('Failed to fetch airports. Please check the console for more details.');
        }
    });

    // Fills other flight details fields
    $('#e-flight-id').val(flightId);
    $('#e-flight-date').val(flightDetails.dep_date);
    $('#e-departure-time').val(flightDetails.dep_time);
    $('#e-arrival-time').val(flightDetails.arr_time);
    $('#e-flight-duration').val(flightDetails.duration_min);
    $('#e-price').val(flightDetails.price);
}

// Submits the flight details form
$('#e-flight-form').submit(function (event) {
    event.preventDefault();
    var formData = $(this).serialize();

    var flightId = $(this).data('flight-id');
    formData += '&flightId=' + flightId;

    $.ajax({
        url: '../controllers/update-flight-details.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            alert(response);
            closeAddFlightsPopup();
            fetchFlightList();
        },
        error: function () {
            alert('Failed to update flight details. Please check the console for more details.');
        }
    });
});

// Closes the pop-up prompt
function closeAddFlightsPopup() {
    $('#add-flights-popup').css('display', 'none');
    $('#edit-flights-popup').css('display', 'none');
}

// Function to view passengers for a specific flight
function viewPassengers(flightID) {
    window.location.href = 'manage-passengers.php?flightID=' + flightID;
}

// Function to view passenger documents for a specific passenger
function viewPassengerDoc(passengerID) {
    window.location.href = 'manage-document.php?passengerID=' + passengerID;
}

// Function to navigate to the cancelled flights page
function gotoCancelledFlights() {
    window.location.href = 'cancelled-flights.php';
}
// Function to navigate to the cancelled flights page
function gotoCompletedFlights() {
    window.location.href = 'completed-flights.php';
}
