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
        <button class="checkin-button" id="checkin-button" onclick="gotoCheckIn(<?php echo $ticket1->bookingID;?>); ">Check In</button>
      </div>
</div>

<h2>Passengers:</h2>
    
            
           <?php 
           for($x=0;$x<$srch1->whosGoing;$x++)
           { ?>
           <div class="passengers-box">
            <div class="label">
            <p class="name-label">Name:</p>
            <p class="seat-label">Seat:</p>
            <p class="incurance-label">Insurance:</p>
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
           <div class="passenger-insurance">
            <b>
           <?php
            echo $ticket1->passengerInsuranceList[$x];
           ?>
           </b>
           </div>
           </div>

           
    </div>
    <?php } ?>
    </div>
</div>
