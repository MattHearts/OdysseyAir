$(document).ready(function() {
    // Add Flights Button Click
    $('#add-flights-button').on('click', function() {
        // TODO: Fetch airport data using AJAX request to retrieve the airports from the database
        // Update the departure and destination airport dropdowns in the pop-up prompt

        // Placeholder code for demonstration
        var airports = [
            { id: 1, name: 'Airport 1' },
            { id: 2, name: 'Airport 2' },
            { id: 3, name: 'Airport 3' }
        ];
        updateAirportDropdowns(airports);

        // Display the pop-up prompt
        openAddFlightsPopup();
    });

    // Update Airport Dropdowns with fetched data
    function updateAirportDropdowns(airports) {
        var departureAirportSelect = $('#departure-airport');
        var destinationAirportSelect = $('#destination-airport');
        
        departureAirportSelect.empty();
        destinationAirportSelect.empty();

        $.each(airports, function(index, airport) {
            departureAirportSelect.append($('<option></option>').val(airport.id).text(airport.name));
            destinationAirportSelect.append($('<option></option>').val(airport.id).text(airport.name));
        });
    }

    // Open Add Flights Popup
    function openAddFlightsPopup() {
        $('#add-flights-popup').css('display', 'block');
    }

    // Flight Details Form Submission
    $('#flight-form').on('submit', function(event) {
        event.preventDefault();

        // Get the form data
        var formData = $(this).serialize();

        // TODO: Perform validation on the form data
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
});
