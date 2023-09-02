<link rel="stylesheet" href="../css/passenger-details.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<div class="layout">

    <div class="forms">
        <h1 style="color:#12bbc7;">Who's Going</h1>
        Please fill in your passenger names, choose what luggage you need and select how you want to check in.<br>
        <div class="passenger-error">
            <p>
                <?php echo $passengersErr; ?>
            </p>
        </div>

        <?php
        for ($x = 1; $x <= $srch1->whosGoing; $x++) {
        ?>

            <h2 style="color:#12bbc7;">Passenger <?php echo $x; ?></h2>
            <div class="passenger-form">
                <div class="form">
                    <form method="post">
                        <div class="single-form">

                            <select name="passenger-title<?php echo $x; ?>" id="passenger-title" required>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Miss">Miss</option>
                                <option value="Mstr">Mstr</option>
                                <option value="Ms">Ms</option>
                            </select>

                        </div>
                        <div class="single-form">
                            <input type="text" required class="form-control-name" id="passenger-name" placeholder="First Name" name="passenger-name<?php echo $x; ?>">
                        </div>
                        <div class="single-form">
                            <input type="text" required class="form-control-surname" id="passenger-surname" placeholder="Last Name" name="passenger-surname<?php echo $x; ?>">
                        </div>


                </div>

                <div class="carriage-box">
                    <div class="carriage-info">
                        <div class="carriage-info-1">
                            <b>Add 22kg checked-in bags</b>
                        </div>
                        <div class="carriage-info-2">
                            <b style="text-align:right;">EUR 20.00</b>
                            <br>
                            (one way)
                        </div>
                    </div>
                    <div class="carriage-action">
                        <button class="minus-button" data-passenger="<?php echo $x; ?>">-</button>
                        <div class="carriage-icon">
                            <span class="fa fa-suitcase" style="font-size: 48px; color: #12c779;"></span>
                        </div>
                        <div class="number">
                            <input type="hidden" name="suitcase-number-input[]" <?php if (isset($_SESSION['suitcaseNum' . $x])) {
                                                                                    echo "value='" . $_SESSION['suitcaseNum' . $x] . "'";
                                                                                } else {
                                                                                    echo "value='0'";
                                                                                } ?> id="suitcase-number-input-<?php echo $x; ?>">
                            <span id="suitcase-number<?php echo $x; ?>"><?php if (isset($_SESSION['suitcaseNum' . $x])) {
                                                                            echo $_SESSION['suitcaseNum' . $x];
                                                                        } else {
                                                                            echo 0;
                                                                        } ?></span>
                        </div>
                        <button class="plus-button" data-passenger="<?php echo $x; ?>">+</button>
                    </div>
                </div>

            </div>
        <?php
        }
        ?>
        <h1 style="color:#12bbc7;">Check in options</h1>
        Please choose how you want to check in.<br>
        <p>
            <?php echo $checkInErr; ?>
        </p>
        <div class="check-in">
            <div class="online">
                <div class="radio">
                    <input required type="radio" id="online" name="check-in" value="online" onclick="updateTotalPrice(0)">
                </div>
                <div class="radio-text">
                    <h3 style="margin-bottom:10px; margin-top:10px;">Online check-in</h3>
                    <label for="online">Enter your passport details online then print your own boarding pass or send it to your smartphone. <b>FREE</b></label>
                </div>
            </div>

            <div class="airport">
                <div class="radio">
                    <input required type="radio" id="airport" name="check-in" value="airport" onclick="updateTotalPrice(22)">
                </div>
                <div class="radio-text">
                    <h3 style="margin-bottom:10px; margin-top:10px;">Airport check-in</h3>
                    <label for="airport">Check-in and receive your boarding pass at the airport desk.<b> Charges apply: 22 EUR</b></label>
                </div>
            </div>
        </div>

    </div>

    <div class="cart">

    </div>
</div>
<div class="overall-results">
    <div class="synopsis">
        <div class="synopsis-text">
            <h2 style="color:#12bbc7;">Awards</h2>
        </div>
        <div class="synopsis-image">
    <img src="../images/awards.png" alt="Awards" style=" width: 350px; justify-self: center;">
    </div>


    </div>
    <div class="price-synopsis">
        <h2 class="h2m6">Total so far:</h2>
        <input type="hidden" name="total-price" id="hidden-total-price" value="0">
        <h1 class="h1m">&euro; <span id="total-price">0</span></h1>
        <button type="submit" class="button-continue"><span><b>Continue</b></span></button><br><br>
        <div class="very-small-letters">By clicking continue, I agree to the website Terms of Use. Fares INCLUDE ALL taxes and charges, excluding optional extras.</div>
    </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/passengerDetailsScript.js"></script>
<script>
    var overallPrice = parseInt(<?php echo $_SESSION['overallPrice']; ?>);
    var tripTypeNum = parseInt(<?php echo $_SESSION['tripTypeNum']; ?>);

    function updateTotalPrice(checkInCharge) {
        var totalSuitcases = 0;
        $(".number span").each(function() {
            totalSuitcases += parseInt($(this).text());
        });

        var suitcasePrice = 20;
        var checkInPrice = checkInCharge || 0;

        if (isNaN(checkInPrice)) {
            checkInPrice = 0; 
        }

        var totalPrice = (totalSuitcases * suitcasePrice) * tripTypeNum + overallPrice + checkInPrice;

        $(".h1m span").text(totalPrice);
        $("#hidden-total-price").val(totalPrice);
    }

    // Calls the updateTotalPrice() function initially to set the total price
    updateTotalPrice();
</script>