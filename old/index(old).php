<!DOCTYPE html>
<html>
<?php
session_start();
session_destroy();
session_start();
$searchErr = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	require "Search.php";
	$srch1= new Search();
	$srch1->searchDepAirport= $_POST['departure-airport'];
	$srch1->searchDestAirport=$_POST['destination-airport'];
    $srch1->searchDepDate=$_POST['date1'];
    $srch1->whosGoing =$_POST['how-many'];
	$srch1->search_flights();
    $searchErr=$srch1->searchErr;
    
}

    include "header.html";



$howmany=1;
?> 
<link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">
        <div class="big-image-index">
            <form method= "post" class="search-flights-form">
            
                <div class="search-form-dep-air">
                    <label for="departure-airport">From</label>
                    <br>
                    <input type="text" class="form-control" id="departure-airport" placeholder="Type departure airport" name="departure-airport">
                </div>
                <div class="search-form-dest-air">
                    <label for="destination-airport">To</label>
                    <br>
                    <input type="text" class="form-control" id="destination-airport" placeholder="Type destination airport" name="destination-airport">
                </div>
                <div class="search-form-pass">
                    <label for="how-many">Who</label>

                  <select name="how-many" id="how-many">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>

                </div>
                <div class="search-form-dep-date">
                    <label for="date">Departure</label>
                    <br>
                    <input type="date" class="form-control" id="date1" placeholder="date" name="date1">

                </div>
                <div class="search-form-ret-date">
                    <label for="date">Return</label>
                    <br>
                    <input type="date" class="form-control" id="date2" placeholder="date" name="date2">

                </div>
                <div class="find-flights">
                <label for="button"><?php echo $searchErr;?></label>
                <br>
                <button type="submit" class="button"><span>Find Flights</span>
                </div>
            
</form>
        </div>
        

        <?php
            include "footer.html";
            



        ?>
        
