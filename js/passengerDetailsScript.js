$(document).ready(function() {
    $(".plus-button").click(function(event) {
      event.preventDefault();
      var passenger = $(this).data("passenger");
      var numberElement = $("#passenger-number" + passenger);
      var currentValue = parseInt(numberElement.text());
      if (currentValue < 5) {
        $.ajax({
          url: "../controllers/update_value.php",
          type: "POST",
          data: { action: "increment", passenger: passenger },
          success: function(response) {
            numberElement.text(response);
          }
        });
      }
    });
  
    $(".minus-button").click(function(event) {
      event.preventDefault();
      var passenger = $(this).data("passenger");
      var numberElement = $("#passenger-number" + passenger);
      var currentValue = parseInt(numberElement.text());
      if (currentValue > 0) {
        $.ajax({
          url: "../controllers/update_value.php",
          type: "POST",
          data: { action: "decrement", passenger: passenger },
          success: function(response) {
            numberElement.text(response);
          }
        });
      }
    });
  });