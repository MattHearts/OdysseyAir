<link rel="stylesheet" href="../css/checkin.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<div class="layout">
<div class="forms">
    <h2>Your Bookings</h2>
    <p>Manage your bookings here, check-in or download your boarding passes</p>
    <?php for($x=0;$x<$check1->bookingNum;$x++){?>
    <form  method="post" class="booking-form">
                <!-- Hidden input field to store the booking ID -->
    <input type="hidden" name="booking_id" value="<?php echo $check1->bookingIDList[$x]; ?>">
    <button type="submit" class="booking-box">
    <h2><?php echo $check1->bookingDateList[$x];?></h2>
    <h3><?php echo $check1->bookingTimeList[$x];?></h3>
    </button>
    </form>
<?php } ?>
</div>
</div>

