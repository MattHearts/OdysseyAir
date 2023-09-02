<link rel="stylesheet" href="../css/checkin.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="layout2">
  <div class="flight-forms-intro">
    <h2 style="color:#12bbc7;">Flights</h2>
    Select your flight to check-in or view your boarding passes
  </div>
  <div class="flight-forms">


    <?php echo $check1->flightError; ?>

    <?php if ($check1->isReturn == true) {
      for ($x = 0; $x < 2; $x++) { ?>
        <div class="clan">
          <form method="post">
            <input type="hidden" name="flightCode" value="<?php echo $check1->flightCode[$x]; ?>">
            <input type="hidden" name="flightType" value="<?php echo $check1->tripType[$x]; ?>">
            <button type="submit" class="flight-box">
              <h2><?php echo $check1->depAirport[$x] . " &#9992; " . $check1->destAirport[$x]; ?></h2>
              <h3>Date: <?php echo $check1->depDate[$x]; ?></h3>
              <b>Flight Times: </b><?php echo substr($check1->depTime[$x], 0, 5) . " -> " . substr($check1->arrTime[$x], 0, 5); ?><br>
              <b>Duration in minutes: </b><?php echo $check1->durationTimeMin[$x]; ?><br>
              <b>Flight ID:</b><?php echo $check1->flightCode[$x]; ?><br>
            </button>
          </form>
        </div>
    <?php
      }
    } ?>

    <?php echo $check1->flightError; ?>

    <?php if ($check1->isReturn == false) {
      $x = 0; ?>
      <div class="clan2">
        <form method="post">
          <input type="hidden" name="flightCode" value="<?php echo $check1->flightCode[$x]; ?>">
          <input type="hidden" name="flightType" value="<?php echo $check1->tripType[$x]; ?>">

          <button type="submit" class="flight-box">
            <h2><?php echo $check1->depAirport[$x] . " &#9992; " . $check1->destAirport[$x]; ?></h2>
            <h3>Date: <?php echo $check1->depDate[$x]; ?></h3>
            <b>Flight Times: </b><?php echo substr($check1->depTime[$x], 0, 5) . " -> " . substr($check1->arrTime[$x], 0, 5); ?><br>
            <b>Duration in minutes: </b><?php echo $check1->durationTimeMin[$x]; ?><br>
            <b>Flight ID:</b><?php echo $check1->flightCode[$x]; ?><br>
          </button>
        </form>
      </div>
    <?php } ?>

    <?php
    for ($x = 0; $x < $check1->passengerNum; $x++) { ?>
      <div class="passengers-box">
        <div class="label">
          <p class="name-label">Name:</p>
          <p class="seat-label">Seat:</p>
          <p class="baggage-label">Baggage Number:</p>
          <p class="insurance-label">Insurance:</p>
        </div>
        <div class="passenger-info">
          <div class="passenger-name">
            <b>
              <?php
              echo $check1->passengerTitleList[$x] . " ";
              echo $check1->passengerNameList[$x] . " ";
              echo $check1->passengerSurnameList[$x];
              ?>
            </b>
          </div>
          <div class="passenger-seat">
            <b>
              <?php
              echo $check1->passengerSeatList[$x] . " ";
              ?>
            </b>
          </div>
          <div class="passenger-baggage">
            <b>
              <?php
              echo $check1->passengerBaggageList[$x];
              ?>
            </b>
          </div>
          <div class="passenger-insurance">
            <b>
              <?php
              echo $check1->passengerInsuranceList[$x];
              ?>
            </b>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>