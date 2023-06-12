<?php
session_start();
include "header5.html";

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
    for($x=1;$x<=$srch1->whosGoing;$x++)
    {
    $_SESSION['insurance'.$x]= $_POST['insurance'.$x];
    if($_POST['insurance'.$x]=="noInsurance"){
        $_SESSION['insuranceCost'.$x]=0;
        $_SESSION['insurance'.$x]="no_insurance";
    }
    else{
        $_SESSION['insuranceCost'.$x]=8;
        $_SESSION['insurance'.$x]="go_insurance";
    }
    
    }
    echo "<script>window.location.href='checkout.php'</script>";

}

?>

<div class="layout">
    <div class="forms">
        <h1>Travel Incurance</h1>
        <p>For even better value, our policies now include cover for over 200 common pre-existing medical conditions at no extra cost. Plus COVID-19 cancellation and medical cover.</p>
        <form method="post">
            <div class="form-box">
                <div class="form-box-info">
                    Cover includes: &check; COVID-19    &check; £10m medical cover   &check; £5,000 cancellation
                </div>
                
                    <?php
                        for($x=1;$x<=$_SESSION['whosGoing'];$x++){
                    ?>
                    <div class="form-row">
                    <div class="form-label">
                        <label for="insurance<?php echo $x;?>"><h2><?php echo $_SESSION['passengerName'.$x]." ".$_SESSION['passengerSurname'.$x]; ?></h2></label>
                    </div>
                    <div class="form-select">
                        <select name="insurance<?php echo $x;?>" id="insurance">

                        <option value="noInsurance">No Thanks</option>
                        <option value="goInsurance">Add Go Insurance - 8&euro;</option>
            
                        </select>
                    </div>
                    
                    </div>
                    <?php }
                    ?>
                

                <div class="terms">
                    <h3>Terms and conditions</h3>
                    <b>To be covered by this policy we assume:</b>
                    <br>
                    1. You are a UK resident and registered with a doctor in the UK.<br>
                    2. You are travelling from and returning to the United Kingdom, Channel Islands, or Isle of Man.<br>
                    3. You are not already travelling.<br>
                    4.You do not have any symptom or condition for which you have not had a diagnosis.<br>
                    5. You are not travelling with the intention of obtaining medical treatment.<br>
                    6. No-one travelling aged over 75 years old.<br>
                </div>
            </div>
        
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
