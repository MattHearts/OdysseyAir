
<link rel="stylesheet" href="../css/pick-seats.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="layout">
  
  <div class="forms">
  <h1>Add seats</h1>
  <h3>Departure Flight</h3>
  <form method="post">
    
	
	<?php
    for($x=1;$x<=$srch1->whosGoing;$x++){
    ?>
    
	<div class="form-box">
        <div class="form-label">
      <label for="seat<?php echo $x;?>"><h2><?php echo $pass1->passengerName[$x]." ".$pass1->passengerSurname[$x]; ?></h2></label>
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
  if($_SESSION['flightType']=="return"){
    ?>
    <h3>Return Flight</h3>
    <?php
    for($x=1;$x<=$srch1->whosGoing;$x++){
    ?>
    	<div class="form-box">
        <div class="form-label">
      <label for="seat<?php echo $x;?>"><h2><?php echo $pass1->passengerName[$x]." ".$pass1->passengerSurname[$x]; ?></h2></label>
        </div>
        <div class="form-select">
     <select name="seatR<?php echo $x;?>" id="seatR">
	 <?php


	foreach ($seats1->free_seats_r as $valueR) {
		//echo "<option value=".$value['showid'].">".$value['showtime']."</option>";
		echo '<option value='.$valueR.'>'.$valueR.'</option>';
	}
	 
	 ?>
		
  </select> </div> </div> 
<?php }}?>
  <?php echo $seatErr;
  ?>

    </div>
</div>
<div class="overall-results">
    <div class="synopsis">
        

            
        
        </div>
    <div class="price-synopsis">
    <h2 class="h2m6">Total so far:</h2>
    <h1 class="h1m">&euro; <?php echo $_SESSION['overallPriceV2'];?></h1>
    <button type="submit"  class="button-continue"><span><b>Continue</b></span></button><br><br>
    <div class="very-small-letters">By clicking continue, I agree to the website Terms of Use. Fares INCLUDE ALL taxes and charges, excluding optional extras.</div>
    </div>
    </form>
</div>
