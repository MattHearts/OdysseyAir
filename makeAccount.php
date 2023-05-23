<?php
session_start();
include "header2.html";
$_SESSION["loggedToBook"]=true;
?>
<link rel="stylesheet" href="search-results.css?v=<?php echo time(); ?>">
<div class="layout2">
    <div class="log-or-reg">
        
        <h1>To continue your booking please</h1>
        <button class='log-in-button' onclick="window.location.href='login.php'"><span><b>Log in</b></span></button>
        <p>or</p>
        <button class='sign-in-button' onclick="window.location.href='register.php'"><span><b>Sign in</b></span></button>
</div>
</div>

<?php
            include "footer.html";
        ?>