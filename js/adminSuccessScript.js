function gotoCheckIn(bookingID) {

  
    // Redirect to the manage-bookings page with the username parameter
    window.location.href = 'checkin.php?username=' + encodeURIComponent(bookingID);
  }
  