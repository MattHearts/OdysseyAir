<!DOCTYPE html>
<html>
<head>
    <title>Flight Search</title>
<link rel="stylesheet" href="../css/search-results.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="page">
  <div <?php if ($_SESSION['flightType']=="return") {echo "class='flight-results-display'";} else {echo "class='flight-results-display-only-dep'";}?>>
        <div class="flight-results-recap">
            <div class=flight-results-where>
                <h2>Where</h2>
                <p><?php echo $srch1->searchDepAirport;?> to <?php echo $srch1->searchDestAirport;?></p>
                <?php if ($_SESSION['flightType']=="return") {echo "<p>". $srch1->searchDepAirportR ." to ". $srch1->searchDestAirportR."</p>";}?>
            </div>
            <div class=flight-results-when>
                <h2>When</h2>
                <p><?php echo $srch1->searchDepDate;?></p>
                <?php if ($_SESSION['flightType']=="return") {echo "<p>". $srch1->searchDepDateR ."</p>";}?>
            </div>
            <div class=flight-results-who>
                <h2>Who's going</h2>
                <p><?php echo $srch1->whosGoing;?> Passengers</p>
            </div>
            <div class=change-results-search>
                <button type="button" onclick="location.href='../index.php';" class="btn-white-to-blue"><span>Edit Search</span>
            </div>


</div>
<div <?php if ($_SESSION['flightType']=="return") {echo "class='flight-result-boxes'";} else {echo "class='flight-result-boxes-only-dep'";}?> >
    <div <?php if ($_SESSION['flightType']=="return") {echo "class='result-departure'";} else {echo "class='result-departure-only'";}?>>
    <h3>Select departure flight:</h3>
    
    <h2 class="h2m"><?php echo $srch1->searchDepAirport;?> &#9992; <?php echo $srch1->searchDestAirport;?></h2>
    <form id="myForm">
    <div class="calendar" id="calendar-container">
    <button type="button" class="day-3"  name="dayMinus3"  <?php if ($srch1->depDateMinus3 < date('Y-m-d')) { echo 'disabled'; } ?>>
            <div class="calendar-date">
                <?php echo $srch1->depDateMinus3;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonMinus3;?>
            </div>
</button>
        <button type="button" class="day-2" name="dayMinus2"  <?php if ($srch1->depDateMinus2 < date('Y-m-d')) { echo 'disabled'; } ?>>
            <div class="calendar-date">
                <?php echo $srch1->depDateMinus2;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonMinus2;?>
            </div>
</button>
        <button type="button" class="day-1"  name="dayMinus1"  <?php if ($srch1->depDateMinus1 < date('Y-m-d')) { echo 'disabled'; } ?>>
        <div class="calendar-date">
                <?php echo $srch1->depDateMinus1;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonMinus1;?>
            </div>
</button>
        <button type="button" class="day0" name="day0" <?php if ($srch1->searchDepDate < date('Y-m-d')) { echo 'disabled'; } ?>>
        <div class="calendar-date">
        <?php echo $srch1->searchDepDate;?>
            </div>
            <div class="calendar-price">
            &euro;
            <?php echo $srch1->pricePerPerson;?>
            </div>
</button>
        <button type="button" class="day1" name="dayPlus1"   <?php if ($srch1->depDatePlus1 < date('Y-m-d')) { echo 'disabled'; } ?>>
        <div class="calendar-date">
        <?php echo $srch1->depDatePlus1;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonPlus1;?>
            </div>
</button>
        <button type="button" class="day2" name="dayPlus2"  <?php if ($srch1->depDatePlus2 < date('Y-m-d')) { echo 'disabled'; } ?>>
        <div class="calendar-date">
        <?php echo $srch1->depDatePlus2;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonPlus2;?>
            </div>
</button>
<button type="button" class="day3" name="dayPlus3"  <?php if ($srch1->depDatePlus3 < date('Y-m-d')) { echo 'disabled'; } ?>>
        <div class="calendar-date">
        <?php echo $srch1->depDatePlus3;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonPlus3;?>
            </div>
</button>
</div>
</form>
<br>
    <br>
    <h2 class="h2-blue" style="text-align:center;">Flight Time - <?php echo $srch1->searchDepDate;?></h2>
    
<?php 
    if($srch1->isFlight==true){?>
    <div class="timeAndPriceBox">
        <div class="timeBox">
            <div class="depTime">
        <h3 class="h3-blue-mrg5">Departs</h2>
        <h2 class="h2-black28-mb5"><?php echo $srch1->depTime;?></h2>
        </div>
        <div class="arrTime">
        <h3 class="h3-blue-mrg5">Arrives</h3>
        <h2 class="h2-black28-mb5"><?php echo $srch1->arrTime;?></h2>
        </div>
        </div>
        <div class="price-box-per-person">
            <div class="price-per-person">
            <h2 class="h2-black28">&euro;<?php echo $srch1->pricePerPerson;?></h2>
            <div style="font-size:small; text-align: center; margin-top:0 ; padding:0; ">per person</div>
            </div>
            <div class="tick">
            &check;
            </div>
    </div>
    </div>
    <?php 
    }
    else
    {?>
    <div class="noFlightsBox">
        
            <h2 class="noFlightsText">There are no flights during this day</h2>
    
    
    <div class="x">
    &#10005;
            </div>
    
    
    </div>

    <?php }?>
    </div>
    
    <?php 
    if ($_SESSION['flightType']=="return")
    {?>
    <div class="result-return">
    <h3>Select return flight:</h3>
        
    <h2 class="h2m"><?php echo $srch1->searchDepAirportR;?> &#9992; <?php echo $srch1->searchDestAirportR;?></h2>
    <form id="myForm2">
    <div class="calendar_r">
    <button type="button" class="day-3" name="dayMinus3R"  <?php if ($srch1->depDateMinus3R < date('Y-m-d')) { echo 'disabled'; } ?>>
            <div class="calendar-date">
                <?php echo $srch1->depDateMinus3R;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonMinus3R;?>
            </div>
</button>
        <button type="button" class="day-2" name="dayMinus2R"  <?php if ($srch1->depDateMinus2R < date('Y-m-d')) { echo 'disabled'; } ?>>
            <div class="calendar-date">
                <?php echo $srch1->depDateMinus2R;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonMinus2R;?>
            </div>
</button>
        <button type="button" class="day-1"  name="dayMinus1R"  <?php if ($srch1->depDateMinus1R < date('Y-m-d')) { echo 'disabled'; } ?>>
        <div class="calendar-date">
                <?php echo $srch1->depDateMinus1R;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonMinus1R;?>
            </div>
</button>
        <button type="button" class="day0"  name="day0R" <?php if ($srch1->searchDepDateR < date('Y-m-d')) { echo 'disabled'; } ?>>
        <div class="calendar-date">
        <?php echo $srch1->searchDepDateR;?>
            </div>
            <div class="calendar-price">
            &euro;
            <?php echo $srch1->pricePerPersonR;?>
            </div>
</button>
        <button  type="button" class="day1"  name="dayPlus1R"  <?php if ($srch1->depDatePlus1R < date('Y-m-d')) { echo 'disabled'; } ?>>
        <div class="calendar-date">
        <?php echo $srch1->depDatePlus1R;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonPlus1R;?>
            </div>
</button>
        <button type="button" class="day2"  name="dayPlus2R"  <?php if ($srch1->depDatePlus2R < date('Y-m-d')) { echo 'disabled'; } ?>>
        <div class="calendar-date">
        <?php echo $srch1->depDatePlus2R;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonPlus2R;?>
            </div>
</button>
<button  type="button" class="day3"  name="dayPlus3R"  <?php if ($srch1->depDatePlus3R < date('Y-m-d')) { echo 'disabled'; } ?>>
        <div class="calendar-date">
        <?php echo $srch1->depDatePlus3R;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonPlus3R;?>
            </div>
</button>
</div>
</form>
<br>
    <br>
    <h2 class="h2-blue" style="text-align:center;">Flight Time - <?php echo $srch1->searchDepDate;?></h2>
    
<?php 
    if($srch1->isFlightR==true){?>
    <div class="timeAndPriceBox">
        <div class="timeBox">
            <div class="depTime">
        <h3 class="h3-blue-mrg5">Departs</h2>
        <h2 class="h2-black28-mb5"><?php echo $srch1->depTimeR;?></h2>
        </div>
        <div class="arrTime">
        <h3 class="h3-blue-mrg5">Arrives</h3>
        <h2 class="h2-black28-mb5"><?php echo $srch1->arrTimeR;?></h2>
        </div>
        </div>
        <div class="price-box-per-person">
            <div class="price-per-person">
            <h2 class="h2-black28">&euro;<?php echo $srch1->pricePerPersonR;?></h2>
            <div style="font-size:small; text-align: center; margin-top:0 ; padding:0; ">per person</div>
            </div>
            <div class="tick">
            &check;
            </div>
    </div>
    </div>
    <?php 
    }
    else
    {?>
    <div class="noFlightsBox">
        
            <h2 class="noFlightsText">There are no flights during this day</h2>
    
    
    <div class="x">
    &#10005;
            </div>
    
    
    </div>

    <?php }?>
        </div>
    <?php }?>
    </div>


</div>
</div>
<div class="overall-results">
    <div class="synopsis">
        <div class="synopsis-top">
            <h2><?php  echo $srch1->depAirport." to ".$srch1->destAirport;?></h2>
        </div>
        <div class="synopsis-bottom">
            <div class="synopsis-bottom-left">
                
            <h2 class="h2m4">Going out &#9992;</h2>
            <div class="small-letters"><b>Depart:</b> <?php echo $srch1->depDate." at ".$srch1->depTime;?><br>
            <b>Arrive:</b> <?php echo $srch1->depDate." at ".$srch1->arrTime;?><br>
            <b>Flight duration:</b> <?php echo $srch1->durationMin;?> mins direct<br></div>
            <h2 class="h2m5">&euro; <?php echo $srch1->pricePerPersonNum*$srch1->whosGoing;?></h2><div class="small-letters"> Passengers: <?php echo $srch1->whosGoing." x &euro;".$srch1->pricePerPersonNum;?></div>
            </div>
            <div class="synopsis-bottom-right">

            <h2 class="h2m4">&#9992; Coming back</h2>
            <?php if ($_SESSION['flightType']=="return"){?>
            <div class="small-letters"><b>Depart:</b> <?php echo $srch1->depDateR." at ".$srch1->depTimeR;?><br>
            <b>Arrive:</b> <?php echo $srch1->depDateR." at ".$srch1->arrTimeR;?><br>
            <b>Flight duration:</b> <?php echo $srch1->durationMinR;?> mins direct<br></div>
            <h2 class="h2m5">&euro; <?php echo $srch1->pricePerPersonNumR*$srch1->whosGoing;?></h2><div class="small-letters"> Passengers: <?php echo $srch1->whosGoing." x &euro;".$srch1->pricePerPersonNumR;?></div>
            </div>
            <div class="synopsis-bottom-right">
            <?php }
            else{?>
            <div class="small-letters">One way flight</div>
              <?php }?>
            
            </div>
        </div>
    </div>
    <div class="price-synopsis">
    <h2 class="h2m6">Total so far:</h2>
    <h1 class="h1m">&euro; <?php echo $overallPrice?></h1>
    <button onclick="addToSessionOverallPrice()" <?php if ($_SESSION['flightType']=="return" && $srch1->isFlight==true && $srch1->isFlightR==true){echo "class='button-continue'";}
    else if($_SESSION['flightType']=="one-way" && $srch1->isFlight==true){echo "class='button-continue'";}
     else{echo "class='button-not-continue'";} ?>
     ><span><b>Continue</b></span></button><br><br>
    <div class="very-small-letters">By clicking continue, I agree to the website Terms of Use. Fares INCLUDE ALL taxes and charges, excluding optional extras.</div>
    </div>
</div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../js/SearchResultsScript.js"></script>     
<script>
function addToSessionOverallPrice() {
  <?php
  $_SESSION['overallPrice'] = $overallPrice;
  ?>
  window.location.href = '../models/isLogged.php';
}
</script>