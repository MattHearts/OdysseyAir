
<!DOCTYPE html>
<html>
    <head>
        <title>OdysseyAir</title>

    </head>
    <body style="margin:0;">
      <div class="grida">
    <header style="margin:0;">
        <div class="header">
            <div class="title">
                <a href="index.php"><img class="resize" src="../images/odysseyair2.png" alt="Italian Trulli"></a>
            </div>
            <button class="manage-box" onclick="window.location.href='../controllers/manage-booking-user.php';">
                <p>Manage my Booking</p>
            </button>
            <div class="info">
                Welcome <?php echo $username;?> | 
                <a onclick="confirmLogout()">Log out</a>
            </div>
        </div>
        
        <div class="nav-bar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="../controllers/about-us.php">About us</a></li>
                <li><a href="../controllers/travel-essentials.php">Travel Essentials</a></li>
                <li style="float:right"><a class="active" href="../controllers/contact-us.php">Contact us</a></li>
              </ul>
        </div>
    </header>
    <script>
        function confirmLogout() {
            var confirmed = window.confirm("Are you sure you want to logout?");
            if (confirmed) {
                window.location.href = "../controllers/logout.php";
            }
        }
    </script>