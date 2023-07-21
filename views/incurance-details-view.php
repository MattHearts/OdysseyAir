<div class="layout">
    <div class="forms">
        <h1>Travel Incurance</h1>
        <p>For even better value, our policies now include cover for over 200 common pre-existing medical conditions at no extra cost. Plus COVID-19 cancellation and medical cover.</p>
        <form method="post" id="insuranceForm">
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
                        <select name="insurance<?php echo $x;?>" id="insurance<?php echo $x;?>" onchange="updateTotalPrice()">
                        <option value="noInsurance">No Thanks</option>
                        <option value="goInsurance">Go Insurance - 8&euro;</option>
                        <?php
                        if($_SESSION['flightType']=="return"){
                        ?>
                        <option value="returnInsurance">Return Insurance - 8&euro;</option>
                        <option value="bothInsurance">All Trip Insurance - 13&euro;</option>
                        <?php
                        }
                        ?>
            
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


    <input type="hidden" name="total-price" id="hidden-total-price" value="0">
    <h1 class="h1m">&euro; <span id="total-price">0</span></h1>

    <button type="submit"  class="button-continue"><span><b>Continue</b></span></button><br><br>
    <div class="very-small-letters">By clicking continue, I agree to the website Terms of Use. Fares INCLUDE ALL taxes and charges, excluding optional extras.</div>
    </div>
    </form>
</div>

<script>
function updateTotalPrice() {
  var selectedOptions = document.querySelectorAll("select[id^='insurance']");
  var previousPrice = <?php echo $_SESSION['overallPriceV2'];?>;
  var overallPrice = previousPrice; 

  selectedOptions.forEach(function(option) {
    if (option.value === 'goInsurance') {
      overallPrice += 8; 
    } else if (option.value === 'returnInsurance') {
      overallPrice += 8; 
    } else if (option.value === 'bothInsurance') {
      overallPrice += 13; 
    }

  });

  document.getElementById("total-price").innerHTML =  overallPrice;
  document.getElementById("hidden-total-price").value = overallPrice;
}

updateTotalPrice();


</script>