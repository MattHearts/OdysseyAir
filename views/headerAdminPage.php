
<!DOCTYPE html>
<html>
    <head>
        <title>Main Pagea</title>

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
                <a onclick="gotoAdminPage()">Admin Menu</a> | 
                <a onclick="confirmLogout()">Log out</a>
                
            </div>
        </div>
        
        <div class="nav-bar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="news.asp">Destinations</a></li>
                <li><a href="contact.asp">Travel Essentials</a></li>
                <li style="float:right"><a class="active" href="#about">Info</a></li>
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
        function gotoAdminPage() {

                window.location.href = "../controllers/admin-menu.php";
        }
    </script>