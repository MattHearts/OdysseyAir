<!DOCTYPE html>
<html>
<head>
    <title>Flight Search</title>
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
</head>
<body>
<div>
    <div class="big-image-index">
        <form method="get" class="search-flights-form">
            <div class="search-form-dep-air">
                <label for="departure-airport">From</label>
                <br>
                <input type="text" class="form-control" id="departure-airport" placeholder="Type departure airport" name="departure-airport">
                <div id="departure-airport-list" class="suggestion-box"></div>
            </div>


            <div class="search-form-dest-air">
                <label for="destination-airport">To</label>
                <br>
                <input type="text" class="form-control" id="destination-airport" placeholder="Type destination airport" name="destination-airport">
                <div id="destination-airport-list" class="suggestion-box"></div>
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
                <input type="date" class="form-control" id="date1" placeholder="date" name="date1" min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="search-form-ret-date">
                <label for="date">Return</label>
                <br>
                <input type="date" class="form-control" id="date2" placeholder="date" name="date2" min="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="find-flights">
                <label for="button"><?php echo $searchErr;?></label>
                <br>
                <button type="submit" class="button"><span>Find Flights</span>
            </div>   
            
            <div class="search-form-trip-type">
            <input type="radio" id="one-way" name="trip-type" value="one-way" checked>
            <label for="one-way">One Way</label>
            <input type="radio" id="return" name="trip-type" value="return">
            <label for="return">Return</label>
        </div>
        </form>
    

    
    </div>
    <h1 style="text-align:center; color:#12bbc7; margin-top:50px;">Travel like Odysseus to...</h1>
    <div class="countries-container">
        
    <div class="country-column">
        <img src="../images/greece-image.jpg" alt="Country 1">
        <h3>Country 1</h3>
        <p>Description of Country 1...</p>
    </div>

    <div class="country-column">
        <img src="../images/italy-image.jpg" alt="Country 2">
        <h3>Country 2</h3>
        <p>Description of Country 2...</p>
    </div>

    <div class="country-column">
        <img src="../images/spain-image.jpg" alt="Country 3">
        <h3>Country 3</h3>
        <p>Description of Country 3...</p>
    </div>
</div>
</div>


</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../js/indexScript.js"></script>   
<script>
 // AJAX call for autocomplete 
$(document).ready(function() {
    $("#departure-airport").keyup(function() {
        var keyword = $(this).val();
        $.ajax({
            type: "POST",
            url: "../controllers/get-airports-index.php",
            data: { keyword: keyword },
            dataType: "json",
            success: function(data) {
                updateSuggestions(data, '#departure-airport-list');
            }
        });
    });

    $("#destination-airport").keyup(function() {
        var keyword = $(this).val();
        $.ajax({
            type: "POST",
            url: "../controllers/get-airports-index.php",
            data: { keyword: keyword },
            dataType: "json",
            success: function(data) {
                updateSuggestions(data, '#destination-airport-list');
            }
        });
    });

    function updateSuggestions(data, suggestionsContainer) {
        var container = $(suggestionsContainer);
        container.empty();

        if (data.length > 0) {
            data.forEach(function(airport) {
                var optionText = airport.airport_ID + ' - ' + airport.airport_city;
                var listItem = $('<div class="suggestion"></div>').text(optionText);
                container.append(listItem);
            });
        } else {
            var listItem = $('<div class="suggestion">No suggestions available</div>');
            container.append(listItem);
        }
    }

// JavaScript
$(document).on('click', '.suggestion', function() {
    var selectedValue = $(this).text();
    var inputFieldId = '#' + $(this).parent().attr('id').replace('-list', '');
    
    // Extract the airport ID from the selectedValue
    var airportID = selectedValue.split(' - ')[0].trim();
    
    $(inputFieldId).val(airportID); // Set the airportID in the input field
    $(inputFieldId + '-list').empty();
});

});
</script>   
</html>