$(document).ready(function() {

  $(".plus-button").click(function(event) {
    event.preventDefault();
    var passenger = $(this).data("passenger");
    var numberInputElement = $("#suitcase-number-input-" + passenger);
    var numberElement = $("#suitcase-number" + passenger);
    var currentValue = parseInt(numberElement.text());
    if (currentValue < 5) {
      $.ajax({
        url: "../controllers/update_value.php",
        type: "POST",
        data: { action: "increment", passenger: passenger },
        success: function(response) {
          numberInputElement.val(response);
          numberElement.text(response);
          updateTotalPrice();
        }
      });
    }
  });

  $(".minus-button").click(function(event) {
    event.preventDefault();
    var passenger = $(this).data("passenger");
    var numberInputElement = $("#suitcase-number-input-" + passenger);
    var numberElement = $("#suitcase-number" + passenger);
    var currentValue = parseInt(numberElement.text());
    if (currentValue > 0) {
      $.ajax({
        url: "../controllers/update_value.php",
        type: "POST",
        data: { action: "decrement", passenger: passenger },
        success: function(response) {
          numberInputElement.val(response);
          numberElement.text(response);
          updateTotalPrice();
        }
      });
    }
  });



  
});


