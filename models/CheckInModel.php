<?php

require_once('../libraries/fpdf/fpdf.php');

class CheckIn
{

    public  $bookingID;
    public $message;
    public $x;
    public $formErr;
    public $passengerIDList = array();
    public $passengerNameList = array();
    public $passengerSurnameList = array();
    public $passengerTitleList = array();
    public $passengerSeatList = array();
    public $passengerInsuranceList = array();
    public $passengerBaggageList = array();

    public $documentType = array();
    public $documentNum = array();
    public $countryOfIssue = array();
    public $nationality = array();
    public $dateBirth = array();

    public $bookingIDList = array();
    public $bookingDateList = array();
    public $bookingTimeList = array();

    public $bookingMessage;
    public $bookingNum;

    public $flightIDList;
    public $tripTypeList;
    public $flightNum;
    public $randomflightID;
    public $passengerNum;
    public $isReturn;
    public $flightError;

    public $depAirport = array();
    public $destAirport = array();
    public $depDate = array();
    public $depTime = array();
    public $arrTime = array();
    public $durationTimeMin = array();
    public $flightCode = array();
    public $tripType = array();

    public $bookingIDCheck;
    public $flightTypeCheck;
    public $flightIDCheck;

    // Fetches flight information
    public function getFlightInfoFromDatabase($flightID)
    {
        require "config.php";

        $query = "SELECT * FROM flights WHERE flight_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $flightID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $flightInfo = $result->fetch_assoc();
            $stmt->close();

            return $flightInfo;
        } else {
            return array();
        }
    }

    // Fetches passengers information
    public function getPassengerInfoFromDatabase($bookingID, $flightType)
    {
        require "config.php";

        $query = "SELECT * FROM passengers WHERE booking_id = ? AND trip_type = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $bookingID, $flightType);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $passengerInfo = array();
            while ($row = $result->fetch_assoc()) {
                $passengerInfo[] = $row;
            }

            $stmt->close();

            return $passengerInfo;
        } else {
            return array();
        }
    }
    // Fetches passenger information by ID
    public function getPassengerInfoFromDatabaseByID($passengerID)
    {
        require "config.php";

        $query = "SELECT * FROM passengers WHERE passenger_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $passengerID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {

            $passengerInfo = $result->fetch_assoc();
            $stmt->close();

            return $passengerInfo;
        } else {
            return false;
        }
    }





    // Fetches info of booking on passengers
    function bookingCheck($bookingIDCheck, $flightTypeCheck)
    {
        require "config.php";
        $bookingquery = "SELECT * FROM passengers WHERE booking_id='$bookingIDCheck' AND trip_type='$flightTypeCheck'";
        $result = $conn->query($bookingquery);
        if ($result->num_rows > 0) {
            $x = 0;
            while ($row = $result->fetch_assoc()) {


                $this->passengerIDList[$x] = $row['passenger_id'];
                $this->passengerNameList[$x] = $row['name'];
                $this->passengerSurnameList[$x] = $row['surname'];
                $this->passengerTitleList[$x] = $row['title'];
                $this->passengerSeatList[$x] = $row['seat'];
                $this->passengerInsuranceList[$x] = $row['insurance'];

                $x++;
            }
            $this->x = $x;
            $_SESSION['passengerNumCheckin'] = $x;
        } else {

            echo  "Something went Wrong";
        }
    }

    // Uploads Check in data into the database
    function upload_info()
    {
        require "config.php";
        $err = false;

        for ($x = 0; $x < $this->x; $x++) {

            $documentType = $this->documentType[$x];
            $documentNum = $this->documentNum[$x];
            $countryOfIssue = $this->countryOfIssue[$x];
            $nationality = $this->nationality[$x];
            $dateBirth = $this->dateBirth[$x];
            $passengerID = $this->passengerIDList[$x];
            $registerquery = "INSERT INTO passenger_info (document_type, document_num, country_of_issue, nationality, passenger_id, date_birth)
		VALUES ('$documentType', '$documentNum','$countryOfIssue','$nationality','$passengerID','$dateBirth')";
            if ($conn->query($registerquery)) {
            } else {
                $err = true;
            }
            $registerquery = "UPDATE passengers
                SET isChecked = 'true'
                WHERE passenger_id = '$passengerID'";
            if ($conn->query($registerquery)) {
            } else {
                $err = true;
            }
        }
        if ($err == true) {
            echo "Something went wrong";
            $conn->close();
        } else {
            $_SESSION['checkInInfo'] = "done";
            echo "<script>window.location.href='../controllers/checkInSuccess.php'</script>";
        }
    }
    // Checks if Check In is online
    function isCheckinOnline()
    {
        require "config.php";
        $flag = true;

        $flightCode = $_SESSION['flightIDCheckin'];
        $bookingID = $_SESSION['bookingIDCheckin'];

        $query = "SELECT * FROM passengers WHERE flight_id='$flightCode' AND booking_id='$bookingID'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $x = 0;
            while ($row = $result->fetch_assoc()) {

                if ($row['checkin_type'] === 'airport') {
                    $flag = false;
                    break;
                }
                $x++;
            }
        } else {
            $flag = false;
        }

        return $flag;
    }

    // Checks if user has already checked in
    function isChecked()
    {
        require "config.php";
        $flag = true;


        $flightCode = $_SESSION['flightIDCheckin'];
        $bookingID = $_SESSION['bookingIDCheckin'];

        $query = "SELECT * FROM passengers WHERE flight_id='$flightCode' AND booking_id='$bookingID'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $x = 0;
            while ($row = $result->fetch_assoc()) {

                if ($row['isChecked'] === 'false') {
                    $flag = false;
                    break;
                }
                $x++;
            }
            $_SESSION['PassengersNum'] = $x;
        } else {
            $flag = false;
        }

        return $flag;
    }

    // Fetches Bookings
    function find_bookings($username)
    {

        require "config.php";
        $bookingquery = "SELECT * FROM bookings WHERE username='$username' ORDER BY booking_id DESC";
        $result = $conn->query($bookingquery);
        if ($result->num_rows > 0) {
            $x = 0;
            while ($row = $result->fetch_assoc()) {

                $this->bookingIDList[$x] = $row['booking_id'];
                $this->bookingDateList[$x] = $row['date'];
                $this->bookingTimeList[$x] = $row['time'];
                $x++;
            }
            $this->bookingNum = $x;
        } else {
            $this->bookingMessage =  "No bookings were found";
        }
    }

    // Fetches flights of that booking
    function find_flights($selectedBookingId)
    {
        require "config.php";
        $this->isReturn = false;

        $bookingquery = "SELECT p.flight_id, p.trip_type, f.* FROM passengers p
                         JOIN flights f ON p.flight_id = f.flight_id
                         WHERE p.booking_id = '$selectedBookingId'";

        $result = $conn->query($bookingquery);

        if ($result->num_rows > 0) {
            $x = 0;
            while ($row = $result->fetch_assoc()) {
                $this->flightIDList[$x] = $row['flight_id'];
                $this->tripTypeList[$x] = $row['trip_type'];
                $this->depAirport[$x] = $row['dep_airport'];
                $this->destAirport[$x] = $row['dest_airport'];
                $this->depDate[$x] = $row['dep_date'];
                $this->depTime[$x] = $row['dep_time'];
                $this->arrTime[$x] = $row['arr_time'];
                $this->durationTimeMin[$x] = $row['duration_min'];
                $this->flightCode[$x] = $row['flight_id'];
                $this->tripType[$x] = ($this->tripTypeList[$x] === "go") ? "go" : "return";

                $x++;
            }

            $this->flightNum = $x;
            if ($this->flightNum > 1) {
                $this->isReturn = true;
            }
            $this->flightError = "";
        } else {
            $this->flightError = "No flights were found";
        }

        // Fetches passenger information for the first flight
        $this->passengerNameList = array();
        $this->passengerSurnameList = array();
        $this->passengerTitleList = array();
        $this->passengerSeatList = array();
        $this->passengerInsuranceList = array();
        $this->passengerBaggageList = array();

        $firstFlightID = $this->flightIDList[0];

        $bookingquery = "SELECT * FROM passengers WHERE booking_id='$selectedBookingId' AND flight_id='$firstFlightID'";
        $result = $conn->query($bookingquery);

        if ($result->num_rows > 0) {
            $x = 0;
            while ($row = $result->fetch_assoc()) {
                $this->passengerNameList[$x] = $row['name'];
                $this->passengerSurnameList[$x] = $row['surname'];
                $this->passengerTitleList[$x] = $row['title'];
                $this->passengerSeatList[$x] = $row['seat'];
                $this->passengerInsuranceList[$x] = $row['insurance'];
                $this->passengerBaggageList[$x] = $row['baggage_num'];

                $x++;
            }
            $this->passengerNum = $x;
            $this->flightError = "";
        } else {
            $this->flightError = "No passengers were found for the first flight";
        }
    }

    // Checks if flight is not active
    function isFlightGone()
    {
        require "config.php";
        $flag = true;

        $flightCode = $_SESSION['flightIDCheckin'];

        $bookingquery = "SELECT * FROM flights WHERE flight_id='$flightCode'";
        $result = $conn->query($bookingquery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['status'] == "active") {
                $flag = false;
            } else {
                $flag = true;
            }
        } else {
            $flag = true;
        }

        return $flag;
    }
}
