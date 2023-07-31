<link rel="stylesheet" href="../css/success.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="../js/adminSuccessScript.js"></script>
<div class="layout">
    <div class="content">
        <div class="success-box">
    <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1 class="h1s">Success</h1> 
        <p class="ps">Your holiday is booked;<br/> Check in now!</p>
        <form id="checkin-form" method="post">
        <input type="hidden" name="bookingID" value="<?php echo $ticket1->bookingID; ?>">
        <?php
        if($_SESSION['checkIn']=='online'){?>
        <button class="check-in-button" id="checkin-button" onclick="submitForm()">Check In</button>
        <?php }?>

</form>
<form action="../controllers/success.php" method="GET">
  <input type="hidden" name="generatePDF" value="true">
  <button type="submit">Download PDF Receipt</button>
</form>
      </div>
      </div>

      <h2>Flights:</h2>
    
            
           <?php 
           if($_SESSION['flightType']=="return")
           { ?>
           <div class="flights-box">
           <div class="flight-box">
            <h2><?php  echo $ticket1->depAirport." to ".$ticket1->destAirport;?></h2>
            <div class="smaller-letters"><b>Departs:</b> <?php echo $ticket1->depDate." at ".substr($ticket1->depTime, 0, 5);?><br>
            <b>Arrives:</b> <?php echo $ticket1->depDate." at ".substr($ticket1->arrTime, 0, 5);?><br>
            <b>Flight duration:</b> <?php echo $ticket1->durationTimeMin;?> mins direct<br></div>
           </div>
           <div class="airplane">
           &
           </div>
           <div class="return-flight-box">
            <h2><?php  echo $ticket1->depAirportR." to ".$ticket1->destAirportR;?></h2>
            <div class="smaller-letters"><b>Departs:</b> <?php echo $ticket1->depDateR." at ". substr($ticket1->depTimeR, 0, 5);?><br>
            <b>Arrives:</b> <?php echo $ticket1->depDateR." at ".substr($ticket1->arrTimeR, 0, 5);?><br>
            <b>Flight duration:</b> <?php echo $ticket1->durationTimeMinR;?> mins direct<br></div>
           </div>
           </div>

        
    <?php } 
    
    else
    { ?>
           <div class="flight-one-box">
           <div class="flight-box">
            <h2><?php  echo $ticket1->depAirport." to ".$ticket1->destAirport;?></h2>
            <div class="smaller-letters"><b>Departs:</b> <?php echo $ticket1->depDate." at ".substr($ticket1->depTime, 0, 5);?><br>
            <b>Arrives:</b> <?php echo $ticket1->depDate." at ".substr($ticket1->arrTime, 0, 5);?><br>
            <b>Flight duration:</b> <?php echo $ticket1->durationTimeMin;?> mins direct<br></div>
           </div>
    </div>
      <?php } ?>

<h2>Passengers:</h2>
    
            
           <?php 
           for($x=0;$x<$srch1->whosGoing;$x++)
           { ?>
           <div class="passengers-box">
            <div class="label">
            <p class="name-label">Name:</p>
            <p class="seat-label">Seat:</p>
            <p class="baggage-label">Baggage Number:</p>
            <p class="insurance-label">Insurance:</p>
           </div>
           <div class="passenger-info">
           <div class="passenger-name">
            <b>
            <?php
            echo $ticket1->passengerTitleList[$x]." ";
            
             echo $ticket1->passengerNameList[$x]." ";
            
             echo $ticket1->passengerSurnameList[$x];
           ?>
           </b>
           </div>
           <div class="passenger-seat">
           <b>
           <?php
            echo $ticket1->passengerSeatList[$x]." ";
           ?>
           </b>
           </div>
           <div class="passenger-baggage">
            <b>
           <?php
            echo $ticket1->passengerBaggageList[$x];
           ?>
      
           </div>
           <div class="passenger-insurance">
            <b>
           <?php
            echo $ticket1->passengerInsuranceList[$x];
           ?>
      
           </div>
           </div>

           
    </div>
    <?php } ?>
    </div>
</div>
