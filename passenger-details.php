<?php
session_start();
include "header3.html";

$passengersErr="";
$checkInErr="";
$suitcaseNum=0;

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

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    require "Passengers.php";
    $pass1 = new Passengers();
    if (!isset($_POST['check-in'])) 
    {
        $pass1->checkInRadio=false;
    }
    else{
        $pass1->checkInRadio=true;
        $pass1->checkIn=$_POST['check-in'];
    }

    $pass1->howMany=$srch1->whosGoing;
    
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {

        $pass1->passengerName[$x]= $_POST['passenger-name'.$x];
        $pass1->passengerSurname[$x]=$_POST['passenger-surname'.$x];
        $pass1->passengerTitle[$x]=$_POST['passenger-title'.$x];


    }
    $pass1->validate_passengers();
    $passengersErr=$pass1->passengersErr;
    $checkInErr=$pass1->checkInErr;

}

?>
<link rel="stylesheet" href="passenger-details.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  $(".plus-button").click(function(event) {
    event.preventDefault();
    var passenger = $(this).data("passenger");
    var numberElement = $("#passenger-number" + passenger);
    var currentValue = parseInt(numberElement.text());
    if (currentValue < 5) {
      $.ajax({
        url: "update_value.php",
        type: "POST",
        data: { action: "increment", passenger: passenger },
        success: function(response) {
          numberElement.text(response);
        }
      });
    }
  });

  $(".minus-button").click(function(event) {
    event.preventDefault();
    var passenger = $(this).data("passenger");
    var numberElement = $("#passenger-number" + passenger);
    var currentValue = parseInt(numberElement.text());
    if (currentValue > 0) {
      $.ajax({
        url: "update_value.php",
        type: "POST",
        data: { action: "decrement", passenger: passenger },
        success: function(response) {
          numberElement.text(response);
        }
      });
    }
  });
});
</script>

<div class="layout">

        <div class="forms">
            <h1>Who's Going</h1>
            Please fill in your passenger names, choose what luggage you need and select how you want to check in.<br>
            <div class="passenger-error">
                        <p>
                        <?php echo $passengersErr;?>
                        </p>
                    </div>

            <?php
            for($x=1;$x<=$srch1->whosGoing;$x++)
            {
                ?>
            
                <h2>Passenger <?php echo $x;?></h2>
                <div class="passenger-form">
                    <div class="form">
                    <form method= "post" >
                    <div class="single-form">

                        <select name="passenger-title<?php echo $x;?>" id="passenger-title">
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Miss">Miss</option>
                        <option value="Mstr">Mstr</option>
                        <option value="Ms">Ms</option>
                        </select>

                    </div>
                    <div class="single-form">
                        <input type="text" class="form-control-name" id="passenger-name" placeholder="First Name" name="passenger-name<?php echo $x;?>">
                    </div>
                    <div class="single-form">
                        <input type="text" class="form-control-surname" id="passenger-surname" placeholder="Last Name" name="passenger-surname<?php echo $x;?>">
                    </div>
                

                    </div>
                    
                    <div class="carriage-box">
                    <button class="minus-button" data-passenger="<?php echo $x;?>">-</button>
                    <div class="carriage-icon">
                  <span class="fa fa-suitcase" style="font-size: 48px; color: #12c779;"></span>
                    </div>
                    <div class="number" id="passenger-number<?php echo $x;?>">0</div>
                    <button class="plus-button" data-passenger="<?php echo $x;?>">+</button>
                        
                    </div>
                
            </div>
                <?php
            }
            ?>
            <h1>Check in options</h1>
            Please choose how you want to check in.<br>
            <p>
                        <?php echo $checkInErr;?>
                        </p>
            <div class="check-in">
                <div class="online">
                <div class="radio">
                <input type="radio" id="online" name="check-in" value="online">
                </div>
                <div class="radio-text">
                    <h3>Online check-in</h3>
                   <label for="online">Enter your passport details online then print your own boarding pass or send it to your smartphone.FREE</label>
                </div>
                </div>

                <div class="airport">
                    <div class="radio">
                <input type="radio" id="airport" name="check-in" value="airport">
                    </div>
                    <div class="radio-text">
                <h3>Airport check-in</h3>
                   <label for="airport">Check-in and receive your boarding pass at the airport desk.Charges apply</label>
                    </div>
                </div>
            </div>

        </div>

        <div class="cart">
            
        </div>
        </div>
        <div class="overall-results">
    <div class="synopsis">
        

            
        
        </div>
    <div class="price-synopsis">
    <h2 class="h2m6">Total so far:</h2>
    <h1 class="h1m">&euro; <?php echo $srch1->pricePerPerson*$srch1->whosGoing;?></h1>
    <button type="submit" class="button-continue"><span><b>Continue</b></span></button><br><br>
    <div class="very-small-letters">By clicking continue, I agree to the website Terms of Use. Fares INCLUDE ALL taxes and charges, excluding optional extras.</div>
    </div>
    </form>
</div>
<?php
            include "footer.html";
        ?>