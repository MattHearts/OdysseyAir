<?php
session_start();
include "header2.html";
?>

</div>
<div class="result-boxes">
    <div class="result-departure">
    <h3>Select flight out:</h3>
    <h2 class="h2m"><?php echo $srch1->searchDepAirport;?> &#9992; <?php echo $srch1->searchDestAirport;?></h2>
    <div class="calendar">

    </div>
    <br>
    <br>
    <h2 class="h2m" style="text-align:center;">Flight Time - <?php echo $srch1->searchDepDate;?></h2>
    
    <?php
        if (isset($_SESSION['depAirport'])) {

            $srch1->depAirport = $_SESSION['depAirport'];
            $srch1->destAirport = $_SESSION['destAirport'];
            $srch1->depDate = $_SESSION['depDate'];
            $srch1->depTime = $_SESSION['depTime'];
            $srch1->arrTime = $_SESSION['arrTime'];
            $srch1->pricePerPerson = $_SESSION['pricePerPerson'];
         
    ?>
    <div class="timeAndPriceBox">
        <div class="timeBox">
            <div class="depTime">
        <h3 class="h3m">Departs</h2>
        <h2 class="h2m2"><?php echo $srch1->depTime;?></h2>
        </div>
        <div class="arrTime">
        <h3 class="h3m">Arrives</h3>
        <h2 class="h2m2"><?php echo $srch1->arrTime;?></h2>
        </div>
        </div>
        <div class="priceBox">
            <div class="price">
            <h2 class="h2m3">&euro;<?php echo $srch1->pricePerPerson;?></h2>
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

<?php
            include "footer.html";
            ?>

