<link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../css/login-register.css?v=<?php echo time(); ?>">
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
                <h3>&#10003; Book a Ticket</h3>
                <p1x>Book your trip with ease in just few steps</p1x>

                <h3>&#10003; Manage your Bookings and Flights</h3>
                <p1x>See your trip information and when you start your own odyssey</p1x>

                <h3>&#10003; Check In Online</h3>
                <p1x>Be at ease by Checking in online fast</p1x>

            </div>

            <div class="container">
                <form method="post">
                    <div class="username-form">
                        <input type="text" class="form-control-username" id="username" placeholder="Enter Email" name="username">
                    </div>
                    <div class="password-form">
                        <input type="password" class="form-control-password" id="password" placeholder="Enter password" name="password">
                    </div>
                    <div class="sign-error">
                        <p>
                            <?php echo $loginErr; ?>
                        </p>
                    </div>
            </div>

            <div class="sign-in-up-info">
                <div class="sign-in-up-button">
                    <div>
                        <button type="submit" class="button">Sign In
                        </button>
                    </div>
                </div>

                <div class="sign-in-up-user-agr1">
                    <p2>By submitting this form, you're agreeing to receive marketing emails from Jet2.com.
                        You can unsubscribe at any time.</p2>
                </div>

                </form>
            </div>

        </div>
    </div>
</div>