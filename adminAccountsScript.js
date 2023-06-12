function viewAccountBookings(username) {
  // Log the selected username
  console.log("Selected username: " + username);

  // Redirect to the manage-bookings page with the username parameter
  window.location.href = 'manage-bookings.php?username=' + encodeURIComponent(username);
}
