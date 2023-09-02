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
                    <input type="text" class="form-control" autocomplete="off" id="departure-airport" placeholder="Type departure airport" name="departure-airport">
                    <div id="departure-airport-list" class="suggestion-box"></div>
                </div>


                <div class="search-form-dest-air">
                    <label for="destination-airport">To</label>
                    <br>
                    <input type="text" class="form-control" autocomplete="off" id="destination-airport" placeholder="Type destination airport" name="destination-airport">
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
                    <label for="button"><?php echo $searchErr; ?></label>
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
        <h1 style="text-align:center; color:#12bbc7; margin-top:50px; border-bottom :#12bbc7 2px solid;">Travel like Odysseus to...</h1>
        <div class="countries-container">

            <div class="country-column">
                <img src="../images/greece-image.jpg" alt="Country 1">
                <h2 style="color:#12bbc7;">Greece</h2>
                <p>Discover Greece like Odysseus did, with OdysseyAir as your guide. 
                    Sail through the Ionian Sea, and explore the ancient ruins of Knossos in Crete. 
                    Feel the history at Olympia, where the first Olympics happened. Reach Ithaca's shores after a sea voyage and 
                    see the cliffs and olive gardens. Walk the paths of Athens, Delphi, and Santorini, following the hero's journey. 
                    Let OdysseyAir take you on an adventure to experience Greece's wonders.</p>
            </div>

            <div class="country-column">
                <img src="../images/italy-image.jpg" alt="Country 2">
                <h2 style="color:#12bbc7;">Italy</h2>
                <p>Embark on a dual adventure with OdysseyAir as we blend the timeless allure of Italy's treasures 
                    with the legendary journey of Odysseus. Trace the steps of the hero himself, to the enchanting lands of 
                    the Cyclops, the mesmerizing isle of Circe and navigate the treacherous waters of Scylla and Charybdis. 
                    Then, seamlessly transition to the captivating charm of Italy, where you can wander 
                    through the ancient streets of Rome, marvel at the artistry of Florence, and embrace the romance 
                    of Venice's canals.</p>
            </div>

            <div class="country-column">
                <img src="../images/spain-image.jpg" alt="Country 3">
                <h2 style="color:#12bbc7;">Turkey</h2>
                <p> Go on Turkish journey with OdysseyAir.
                    travel Istanbul, a mix of old and new like places Odysseus saw. 
                    Find Troy's ancient ruins, where Trojan War stories live. 
                    Go to Hierapolis-Pamukkale, maybe like Hades' Gates, with odd terraces and hot springs. 
                    Feel adventure along the coast, like Odysseus did. Let OdysseyAir show you Anatolia's history and myth, 
                    making your journey like hero's epic voyage.
                     </p>
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
                data: {
                    keyword: keyword
                },
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
                data: {
                    keyword: keyword
                },
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

        $(document).on('click', '.suggestion', function() {
            var selectedValue = $(this).text();
            var inputFieldId = '#' + $(this).parent().attr('id').replace('-list', '');

            // Extracts the airport ID from the selectedValue
            var airportID = selectedValue.split(' - ')[0].trim();

            $(inputFieldId).val(airportID); // Sets the airportID in the input field
            $(inputFieldId + '-list').empty();
        });

    });
</script>

</html>