<?php
session_start();
include "header6.html";

$numErr="";
$nameErr="";
$CVVErr="";

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
echo "<script>window.location.href='index.php'</script>";
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
    echo "<script>window.location.href='index.php'</script>";
}

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    require "Pay.php";
    $pay1 = new Pay();

    

        $pay1->cardName= $_POST['card-name'];
        $pay1->cardNumber=$_POST['card-number'];
        $pay1->cardCVV=$_POST['card-cvv'];


    $pay1->validateCard();
    if($pay1->err==false){
        require "Ticket.php";
        $ticket1= new Ticket();
        $ticket1->register_booking();
        for($x=1;$x<=$srch1->whosGoing;$x++)
        {
        $ticket1->register_passengers($x);
        }
        echo "<script>window.location.href='success.php'</script>";
        
    }
    else{

    
    $nameErr=$pay1->nameErr;
    $numErr=$pay1->numErr;
    $CVVErr=$pay1->CVVErr;
    }
}
?>

<div class="layout">
    <div class="forms">
        <h1>Checkout</h1>
        <h2>Pay for your booking</h2>
    <div class="form-box">
        
        <div class="card-payment">
        <div class="card-payment-header">
            <h2>Pay by card</h2>
        </div>
        <div class="card-payment-main">
            <form method="post">

            <div class="single-form">
                <label for="card-number">Number on Card</label>
                <input type="text" class="form-control-card-number" id="card-number" placeholder="1111-2222-3333-4444" name="card-number">
                
            </div>
            

            <div class="single-form">
                <label for="card-name">Name on Card</label>
                <input type="text" class="form-control-card-name" id="card-name" placeholder="MR POTATOMAN" name="card-name">
                
            </div>
           
            <div class="single-form">
            <label>Expiry Date</label>
            <div class="card-date">
            
                <div class="card-month">
                    <select name="card-month" id="card-month">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>

                </div>
                <div class="card-year">
                    <select name="card-year" id="card-year">
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                        <option value="2033">2033</option>
                        <option value="2034">2034</option>
                    </select>            
                </div>
            </div>
        </div>
            <div class="single-form-cvv">
                <label for="card-cvv">CVV</label>
                <input type="text" class="form-control-card-cvv" id="card-cvv" placeholder="123" name="card-cvv">
                
            </div>
            
</div>

        </div>
        <div class="card-errors">
        <?php echo $numErr;?><br>
<?php echo $nameErr;?><br>
<?php echo $CVVErr;?>
</div>
    </div>

<h2>Pay for your booking</h2>
<div class="form-box">
        <h2 style="margin-left:20px;">Payment Option</h2>
        </div>
</div>
</div>

<div class="overall-results">
    <div class="synopsis-layout">
        <div class="synopsis">
            <div class="synopsis-header">
                <h2>Please accept our Terms & Conditions</h2>
            </div>
            <div class="synopsis-main">
            <p>Please tick the box to confirm you’ve read the information above and accept our Terms & Conditions, 
                including the Dangerous Goods Policy and Summary of Key Terms. 
                Please also make sure that everyone who’s travelling is aware of them too.</p>

                <input type="checkbox" id="termsconditions" name="termsconditions" value="accepted">
                <label for="termsconditions"><b> I've read the information above and accept the terms and conditions<b></label><br>
            </div>

        </div>
    </div>

    <div class="price-synopsis">
        <h2 class="h2m6">Total so far:</h2>
        <h1 class="h1m">&euro; <?php echo $srch1->pricePerPerson*$srch1->whosGoing+$pass1->checkInCost;?></h1>
        <button type="submit"  class="button-continue"><span><b>Pay Securely &rarr;</b></span></button><br><br>
        <div class="very-small-letters">By clicking continue, I agree to the website Terms of Use. Fares INCLUDE ALL taxes and charges, excluding optional extras.</div>
    </div>
    </form>
</div>

<?php
            include "footer.html";
        ?>