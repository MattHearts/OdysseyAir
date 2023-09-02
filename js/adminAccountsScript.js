function viewAccountBookings(username) {
  // Redirects to the manage-bookings page with the username parameter
  window.location.href = 'manage-bookings.php?username=' + encodeURIComponent(username);
}
