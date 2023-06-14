
<div class="layout">
  
  <div class="forms">
  <h1>Add seats</h1>
  <form method="post">
    
	
	<?php
    for($x=1;$x<=$_SESSION['whosGoing'];$x++){
    ?>
	<div class="form-box">
        <div class="form-label">
      <label for="seat<?php echo $x;?>"><h2><?php echo $_SESSION['passengerName'.$x]." ".$_SESSION['passengerSurname'.$x]; ?></h2></label>
        </div>
        <div class="form-select">
     <select name="seat<?php echo $x;?>" id="seat">
	 <?php


	foreach ($seats1->free_seats as $value) {
		//echo "<option value=".$value['showid'].">".$value['showtime']."</option>";
		echo '<option value='.$value.'>'.$value.'</option>';
	}
	 
	 ?>
		
  </select> </div> </div>   
  <?php }
  echo $seatErr;
  ?>

    </div>
</div>
<div class="overall-results">
    <div class="synopsis">
        

            
        
        </div>
    <div class="price-synopsis">
    <h2 class="h2m6">Total so far:</h2>
    <h1 class="h1m">&euro; <?php echo $srch1->pricePerPerson*$srch1->whosGoing+$pass1->checkInCost;?></h1>
    <button type="submit"  class="button-continue"><span><b>Continue</b></span></button><br><br>
    <div class="very-small-letters">By clicking continue, I agree to the website Terms of Use. Fares INCLUDE ALL taxes and charges, excluding optional extras.</div>
    </div>
    </form>
</div>
