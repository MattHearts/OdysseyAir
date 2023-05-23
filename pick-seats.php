<?php
session_start();
include "header4.html";
require "Seats.php";
$seatErr="";
$seats1= new Seats();
$seats1->find_free_seats();


if (isset($_SESSION['depAirport'])) {
    require "Search.php";
    $srch1 = new Search();
    $srch1->depAirport = $_SESSION['depAirport'];
    $srch1->destAirport = $_SESSION['destAirport'];
    $srch1->depDate = $_SESSION['depDate'];
    $srch1->depTime = $_SESSION['depTime'];
    $srch1->arrTime = $_SESSION['arrTime'];
    $srch1->durationMin = $_SESSION['durationMin'];
    $srch1->pricePerPerson = $_SESSION['pricePerPerson'];
    $srch1->whosGoing = $_SESSION['whosGoing'];
}
else
{
echo "something went wrong";
}

if (isset($_SESSION['checkIn'])) {
    require "Passengers.php";
    $pass1=new Passengers();
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {

        $pass1->passengerName[$x]= $_SESSION['passengerName'.$x];
        $pass1->passengerSurname[$x]=$_SESSION['passengerSurname'.$x];
        $pass1->passengerTitle[$x]=$_SESSION['passengerTitle'.$x];


    }
    $pass1->checkIn=$_SESSION['checkIn'];
    $pass1->checkInCost=$_SESSION['checkInCost'];
}
else{
    echo "something went wrong";
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {
        
        
        $pass1->passengerSeat[$x]= $_POST['seat'.$x];

    }
    $arr_unique = array_unique($pass1->passengerSeat);
    $check = count($pass1->passengerSeat) !== count($arr_unique);
    $seatErr ="";
    $arr_duplicates = [];
    if($check == 1) {
        $seatErr ="Please select different seats for each passenger";
        $arr_duplicates = array_diff_assoc($pass1->passengerSeat, $arr_unique);
    }
    else{
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {
    $_SESSION['passengerSeat'.$x]= $_POST['seat'.$x];
    }

    echo "<script>window.location.href='incurance-details.php'</script>";
    }
}
?>



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
<?php
            include "footer.html";
        ?>





