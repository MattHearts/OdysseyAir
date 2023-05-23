<?php
session_start();
include "header.html";
?>



<?php
$loginErr=" ";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	require "user.php";
	$usr1= new User();
	$usr1->username= $_POST['username'];
	$usr1->password=$_POST['password'];
	$usr1->loginUser();
    $loginErr=$usr1->loginErr;
	
}
?>
    <link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="login-register.css?v=<?php echo time(); ?>">
<div class="page">
    <div class="title-center">

        <div class="title-sign-up-in">
            <h1>Sign-In</h1>
            <p><a href="index.php">Home Page</a> / Sign-in</p>
        </div>

    </div>

    <div class="center">

        <div class="box">

            <div class="comments">
                <h2>Sign in to:</h2>
                <h3>&#10003; Stay in the loop</h3>
                <p1x>Find out as soon as our flights go on sale</p1x>

                <h3>&#10003; Look forward to next winter now</h3>
                <p1x>Get ready for a great winter getaway in 2023/24!</p1x>

                <h3>&#10003; Discover travel essentials</h3>
                <p1x>Find out great ways to enhance your flight and trip</p1x>

                <h3>&#10003; Find out special offers</h3>
                <p1x>Look out for discounts and promo codes</p1x>
            </div>

            <div class="container">
                <form method= "post">
                    <div class="username-form">
                        <input type="text" class="form-control-username" id="username" placeholder="Enter Email" name="username">
                    </div> 
                    <div class="password-form">
                        <input type="password" class="form-control-password" id="password" placeholder="Enter password" name="password">
                    </div>
                    <div class="sign-error">
                        <p>
                        <?php echo $loginErr;?>
                        </p>
                    </div>
            </div>

            <div class="sign-in-up-info">
                <div class ="sign-in-up-button">
                    <div>
                        <button type="submit" class="button">Sign In
                        </button>
                </div>
                </div>

                    <div class="sign-in-up-user-agr1">
                        <p2>By submitting this form, you're agreeing to receive marketing emails from Jet2.com. 
                        You can unsubscribe at any time. We process your data in accordance to our privacy policy (https://www.jet2.com/privacy).</p2>
                    </div>
                
                </form>
            </div>

        </div>
    </div>
</div>
<?php
            include "footer.html";
            



        ?>