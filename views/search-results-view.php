<!DOCTYPE html>
<html>
<head>
    <title>Flight Search</title>
<link rel="stylesheet" href="../css/search-results.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="page">
  <div class="flight-results-display">
        <div class="flight-results-recap">
            <div class=flight-results-where>
                <h2>Where</h2>
                <p><?php echo $srch1->searchDepAirport;?> to <?php echo $srch1->searchDestAirport;?></p>
            </div>
            <div class=flight-results-when>
                <h2>When</h2>
                <p><?php echo $srch1->searchDepDate;?></p>
            </div>
            <div class=flight-results-who>
                <h2>Who's going</h2>
                <p><?php echo $srch1->whosGoing;?> Passengers</p>
            </div>
            <div class=change-results-search>
                <button type="submit" class="btn-white-to-blue"><span>Edit Search</span>
            </div>


</div>
<div class="flight-result-boxes">
    <div class="result-departure">
    <h3>Select flight out:</h3>
    
    <h2 class="h2m"><?php echo $srch1->searchDepAirport;?> &#9992; <?php echo $srch1->searchDestAirport;?></h2>
    <form method="post">
    <div class="calendar">
    <button type="submit" class="day-3" name="dayMinus3">
            <div class="calendar-date">
                <?php echo $srch1->depDateMinus3;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonMinus3;?>
            </div>
</button>
        <button type="submit" class="day-2" name="dayMinus2">
            <div class="calendar-date">
                <?php echo $srch1->depDateMinus2;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonMinus2;?>
            </div>
</button>
        <button class="day-1" class="day-1" name="dayMinus1">
        <div class="calendar-date">
                <?php echo $srch1->depDateMinus1;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonMinus1;?>
            </div>
</button>
        <button  class="day0" class="day0" name="day0">
        <div class="calendar-date">
        <?php echo $srch1->searchDepDate;?>
            </div>
            <div class="calendar-price">
            &euro;
            <?php echo $srch1->pricePerPerson;?>
            </div>
</button>
        <button class="day1" class="day1" name="dayPlus1">
        <div class="calendar-date">
        <?php echo $srch1->depDatePlus1;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonPlus1;?>
            </div>
</button>
        <button class="day2" class="day2" name="dayPlus2">
        <div class="calendar-date">
        <?php echo $srch1->depDatePlus2;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonPlus2;?>
            </div>
</button>
<button class="day3" class="day3" name="dayPlus3">
        <div class="calendar-date">
        <?php echo $srch1->depDatePlus3;?>
            </div>
            <div class="calendar-price2">
            &euro;
            <?php echo $srch1->pricePerPersonPlus3;?>
            </div>
</button>
</form>
    </div>
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
    <div class="result-return">
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
            <div class="small-letters">One way flight</div>
            
            </div>
        </div>
    </div>
    <div class="price-synopsis">
    <h2 class="h2m6">Total so far:</h2>
    <h1 class="h1m">&euro; <?php echo $srch1->pricePerPersonNum*$srch1->whosGoing;?></h1>
    <button onclick="window.location.href='../models/isLogged.php'" <?php if ($srch1->isFlight==true){echo "class='button-continue'";} else{echo "class='button-not-continue'";} ?>><span><b>Continue</b></span></button><br><br>
    <div class="very-small-letters">By clicking continue, I agree to the website Terms of Use. Fares INCLUDE ALL taxes and charges, excluding optional extras.</div>
    </div>
</div>
    </div>
    <body>
        <html>