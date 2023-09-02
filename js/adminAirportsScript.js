var selectedCountry = '';

$(document).ready(function () {
  // Fetches countries and populate the dropdown
  $.ajax({
    url: '../controllers/get-countries.php',
    type: 'GET',
    dataType: 'json',
    success: function (response) {
      var countryDropdown = $('#countryDropdown');
      countryDropdown.empty();

      if (response.length > 0) {
        $.each(response, function (index, country) {
          countryDropdown.append($('<option></option>').text(country));
        });
      } else {
        countryDropdown.append($('<option></option>').text('No countries available'));
      }

      selectedCountry = countryDropdown.val(); 


      countryDropdown.trigger('change');
    },
    error: function () {
      alert('Error occurred while fetching countries.');
    }
  });

  // Updates airport list when a country is selected
  $('#countryDropdown').on('change', function () {
    selectedCountry = $(this).val();
    updateAirportList(selectedCountry);
  });

});

$(document).ready(function () {
  $('#add-airport-button').click(function () {
    $('#add-airports-popup').css('display', 'block');
  });
});

$('.close, .popup').click(function () {
  $('.popup').css('display', 'none');
});

$('.popup-content').click(function (e) {
  e.stopPropagation();
});

$.ajax({
  url: '../controllers/get-countries.php',
  type: 'GET',
  dataType: 'json',
  success: function (response) {
    var airportCountryDropdown = $('#airport-country');
    airportCountryDropdown.empty();

    if (response.length > 0) {
      $.each(response, function (index, country) {
        airportCountryDropdown.append($('<option></option>').text(country));
      });
    } else {
      airportCountryDropdown.append($('<option></option>').text('No countries available'));
    }
  },
  error: function () {
    alert('Error occurred while fetching countries.');
  }
});

// Handles form submission
$('#airport-form').submit(function (e) {
  e.preventDefault();

  // Gets form data
  var formData = $(this).serialize();

  // Sends AJAX request to update the database
  $.ajax({
    url: '../controllers/add-airport.php',
    type: 'POST',
    data: formData,
    success: function (response) {

      alert(response);


      closeAddFlightsPopup();

      updateAirportList(selectedCountry);
    },
    error: function () {
      alert('Failed to add the flight. Please try again.');
    }
  });
});

function closeAddFlightsPopup() {
  $('#add-airports-popup').css('display', 'none');
  $('#edit-airports-popup').css('display', 'none');
}

// Function to update airport list based on the selected country
function updateAirportList(selectedCountry) {
  var airportListContainer = $('#airportList');

  // Sends AJAX request to fetch airports based on the selected country
  $.ajax({
    url: '../controllers/get-airports.php',
    type: 'GET',
    dataType: 'json',
    data: { country: selectedCountry },
    success: function (response) {
      airportListContainer.empty();

      if (response.length > 0) {
        $.each(response, function (index, airport) {
          var airportRow = '<tr>' +
            '<td>' + airport.airport_ID + '</td>' +
            '<td>' + airport.airport_city + '</td>' +
            '<td>' + airport.airport_name + '</td>' +
            '<td><button class="delete-button" data-airport-id="' + airport.airport_ID + '">Delete</button></td>' +
            '</tr>';
          airportListContainer.append(airportRow);
        });
      } else {
        airportListContainer.append('<tr><td colspan="3">No airports available for the selected country</td></tr>');
      }
    },
    error: function () {
      alert('Error occurred while fetching airports.');
    }
  });

}

$(document).on('click', '.delete-button', function () {
  var airportID = $(this).data('airport-id');

  // Performs the check if the airport is associated with flights
  checkIfAirportInFlights(airportID);
});


// Function to delete the airport
function deleteAirport(airportID) {
  // Performs the AJAX request to delete the airport
  $.ajax({
    url: '../controllers/delete-airport.php',
    type: 'POST',
    data: { airportID: airportID },
    success: function (response) {
      
      updateAirportList(selectedCountry);
    },
    error: function () {
      alert('Error occurred while deleting the airport.');
    }
  });
}

// Function to check if airport is in flights
function checkIfAirportInFlights(airportID) {
  // Sends AJAX request to the server
  $.ajax({
    url: '../controllers/check-airport-in-flights.php',
    type: 'GET',
    dataType: 'json',
    data: { airportID: airportID },
    success: function (response) {
      if (response.inFlights) {

        alert('Airport is associated with flights and cannot be deleted.');
      } else {

        var confirmDelete = confirm('Are you sure you want to delete this airport?');

        if (confirmDelete) {
          // Performs delete airports
          deleteAirport(airportID);
        }
      }
    },
    error: function () {
      alert('Error occurred while checking if airport is in flights.');
    }
  });
}
