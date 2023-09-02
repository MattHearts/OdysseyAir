// Event listener for the calendar buttons for go flights
  $(document).ready(function() {
    $(".calendar button[name]").click(function() {
      var action = $(this).attr("name");
      $.ajax({
          // Sends AJAX request to the server
        url: "../controllers/search-results.php",
        type: "POST",
        data: { action: action },
        success: function(response) {
          // Reloads the page
          window.location.reload();
        }
      });
    });


  
// Event listener for the calendar buttons for return
    $(".calendar_r button[name]").click(function() {
      var action = $(this).attr("name");
      $.ajax({
          // Sends AJAX request to the server
        url: "../controllers/search-results.php",
        type: "POST",
        data: { action: action },
        success: function(response) {
          // Reloads the page
          window.location.reload();
        }
      });
    });
  });


