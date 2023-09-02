<link rel="stylesheet" href="../css/checkin.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<div class="layout">

    <div class="forms">
        <h1 style="color:#12bbc7;">You have checked in!</h1>
        Download your boarding passes:<br>
        <?php foreach ($passengerInfo as $passenger) { ?>
            <a href="../controllers/generateBoardingPass.php?bookingID=<?php echo $check1->bookingIDCheck; ?>
            &flightID=<?php echo $check1->flightIDCheck; ?>&passengerID=<?php echo $passenger['passenger_id']; ?>">
                &#9992; <?php echo $passenger['name'] . " " . $passenger['surname']; ?><br>

            <?php } ?>
    </div>
</div>