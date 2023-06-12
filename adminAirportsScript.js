var selectedCountry = ''; // Declare selectedCountry variable outside document.ready

$(document).ready(function() {
  // Fetch countries and populate the dropdown
  $.ajax({
    url: 'get-countries.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      var countryDropdown = $('#countryDropdown');
      countryDropdown.empty(); // Clear existing options

      if (response.length > 0) {
        $.each(response, function(index, country) {
          countryDropdown.append($('<option></option>').text(country));
        });
      } else {
        countryDropdown.append($('<option></option>').text('No countries available'));
      }
      
      selectedCountry = countryDropdown.val(); // Set selectedCountry initially
      
      // Trigger the change event to initially populate the airport list
      countryDropdown.trigger('change');
    },
    error: function() {
      alert('Error occurred while fetching countries.');
    }
  });
  
  // Update airport list when a country is selected
  $('#countryDropdown').on('change', function() {
    selectedCountry = $(this).val();
    updateAirportList(selectedCountry);
  });
    
});

$(document).ready(function() {
    // Add Airport Button click event
    $('#add-airport-button').click(function() {
      // Open add-airports-popup
      $('#add-airports-popup').css('display', 'block');
    });
  });

  // Close popup when close button or outside area is clicked
$('.close, .popup').click(function() {
    $('.popup').css('display', 'none');
  });
  
  // Prevent closing the popup when the content area is clicked
  $('.popup-content').click(function(e) {
    e.stopPropagation();
  });

  $.ajax({
    url: 'get-countries.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      var airportCountryDropdown = $('#airport-country');
      airportCountryDropdown.empty(); // Clear existing options

      if (response.length > 0) {
        $.each(response, function(index, country) {
          airportCountryDropdown.append($('<option></option>').text(country));
        });
      } else {
        airportCountryDropdown.append($('<option></option>').text('No countries available'));
      }
    },
    error: function() {
      alert('Error occurred while fetching countries.');
    }
  });

    // Handle form submission
    $('#airport-form').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
    
        // Get form data
        var formData = $(this).serialize();
    
        // Send AJAX request to update the database
        $.ajax({
          url: 'add-airport.php',
          type: 'POST',
          data: formData,
          success: function (response) {
            // Display success message
            alert(response);

            // Close the pop-up prompt
            closeAddFlightsPopup();
             // Update the airport list
      updateAirportList(selectedCountry);
        },
        error: function () {
            alert('Failed to add the flight. Please try again.');
        }
        });
      });

        // Close Add Flights Popup
        function closeAddFlightsPopup() {
            $('#add-airports-popup').css('display', 'none');
            $('#edit-airports-popup').css('display', 'none');
        }

        // Function to update airport list based on the selected country
function updateAirportList(selectedCountry) {
    var airportListContainer = $('#airportList');

    // Send AJAX request to fetch airports based on the selected country
    $.ajax({
        url: 'get-airports.php',
        type: 'GET',
        dataType: 'json',
        data: { country: selectedCountry },
        success: function(response) {
            airportListContainer.empty(); // Clear existing airport list

            if (response.length > 0) {
                $.each(response, function(index, airport) {
                    var airportRow = '<tr>' +
                        '<td>' + airport.airport_ID + '</td>' +
                        '<td>' + airport.airport_city + '</td>' +
                        '<td>' + airport.airport_name + '</td>' +
                        '<td><button class="delete-button" data-airport-id="' + airport.airport_ID + '">Delete</button></td>' + //delete button
                        '</tr>';
                    airportListContainer.append(airportRow);
                });
            } else {
                airportListContainer.append('<tr><td colspan="3">No airports available for the selected country</td></tr>');
            }
        },
        error: function() {
            alert('Error occurred while fetching airports.');
        }
    });
    
}

$(document).on('click', '.delete-button', function() {
    var airportID = $(this).data('airport-id');
  
    // Perform the check if the airport is associated with flights
    checkIfAirportInFlights(airportID);
  });


// Function to delete the airport
function deleteAirport(airportID) {
  // Perform the AJAX request to delete the airport
  $.ajax({
    url: 'delete-airport.php',
    type: 'POST',
    data: { airportID: airportID },
    success: function(response) {
      // Refresh the airport list after successful deletion
      updateAirportList(selectedCountry);
    },
    error: function() {
      alert('Error occurred while deleting the airport.');
    }
  });
}

// Function to check if airport is in flights
function checkIfAirportInFlights(airportID) {
    // Send AJAX request to the server
    $.ajax({
      url: 'check-airport-in-flights.php',
      type: 'GET',
      dataType: 'json',
      data: { airportID: airportID },
      success: function(response) {
        if (response.inFlights) {
          // Airport is in flights, show error message or take appropriate action
          alert('Airport is associated with flights and cannot be deleted.');
        } else {
          // Airport is not in flights, prompt for confirmation before deleting
          var confirmDelete = confirm('Are you sure you want to delete this airport?');
  
          if (confirmDelete) {
            // Perform the deletion operation
            deleteAirport(airportID);
          }
        }
      },
      error: function() {
        alert('Error occurred while checking if airport is in flights.');
      }
    });
  }
