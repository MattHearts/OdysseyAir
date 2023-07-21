
  $(document).ready(function() {
    $(".calendar button[name]").click(function() {
      var action = $(this).attr("name");
      $.ajax({
        url: "../controllers/search-results.php",
        type: "POST",
        data: { action: action },
        success: function(response) {
          // Reload the page
          window.location.reload();
        }
      });
    });


  

    $(".calendar_r button[name]").click(function() {
      var action = $(this).attr("name");
      $.ajax({
        url: "../controllers/search-results.php",
        type: "POST",
        data: { action: action },
        success: function(response) {
          // Reload the page
          window.location.reload();
        }
      });
    });
  });


