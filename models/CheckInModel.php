<?php
    
require_once('../libraries/fpdf/fpdf.php');
//class for ticket search
class CheckIn{

  public  $bookingID;
  public $message;
  public $x;
  public $formErr;
  public $passengerIDList=array();
  public $passengerNameList=array();
  public $passengerSurnameList=array();
  public $passengerTitleList=array();
  public $passengerSeatList=array();
  public $passengerInsuranceList=array();

  public $documentType=array();
  public $documentNum=array();
  public $countryOfIssue=array();
  public $nationality=array();
  public $dateBirth=array();

  public $bookingIDList=array();
  public $bookingDateList=array();
  public $bookingTimeList=array();

  public $bookingMessage;
  public $bookingNum;

  public $flightIDList;
  public $tripTypeList;
  public $flightNum;
  public $randomflightID;
  public $passengerNum;
  public $isReturn;
  public $flightError;

  public $depAirport=array();
    public $destAirport=array();
    public $depDate=array();
    public $depTime=array();
    public $arrTime=array();
    public $durationTimeMin=array();
    public $flightCode=array();
    public $tripType=array();

public $bookingIDCheck;
public $flightTypeCheck;
public $flightIDCheck;

public function getFlightInfoFromDatabase($flightID) {
    require "config.php"; // Include your database connection configuration

    // Escape the flight ID to prevent SQL injection (assuming $conn is your MySQLi connection)
    $flightID = $conn->real_escape_string($flightID);

    // Prepare the query to fetch flight information based on the flight ID
    $query = "SELECT * FROM flights WHERE flight_id = '$flightID'";

    // Execute the query
    $result = $conn->query($query);

    // Check if the query was successful and if there is a matching flight
    if ($result && $result->num_rows > 0) {
        $flightInfo = $result->fetch_assoc(); // Fetch the flight information as an associative array
        $result->close(); // Close the result set

        return $flightInfo;
    } else {
        // Handle the case where the flight information was not found (e.g., return an empty array)
        return array();
    }
}

// Inside the CheckInModel class
public function getPassengerInfoFromDatabase($bookingID, $flightType) {
    require "config.php"; // Include your database connection configuration

    // Escape the booking ID and flight type to prevent SQL injection (assuming $conn is your MySQLi connection)
    $bookingID = $conn->real_escape_string($bookingID);
    $flightType = $conn->real_escape_string($flightType);

    // Prepare the query to fetch passenger information based on the booking ID and flight type
    $query = "SELECT * FROM passengers WHERE booking_id = '$bookingID' AND trip_type = '$flightType'";

    // Execute the query
    $result = $conn->query($query);

    // Check if the query was successful and if there are matching passengers
    if ($result && $result->num_rows > 0) {
        // Fetch all passenger information as an array of associative arrays
        $passengerInfo = array();
        while ($row = $result->fetch_assoc()) {
            $passengerInfo[] = $row;
        }

        $result->close(); // Close the result set

        return $passengerInfo;
    } else {
        // Handle the case where no passengers were found (e.g., return an empty array)
        return array();
    }
}
// Inside the CheckIn class
function getPassengerInfoFromDatabaseByID($passengerID) {
    require "config.php"; // Include your database connection configuration

    // Escape the passenger ID to prevent SQL injection (assuming $conn is your MySQLi connection)
    $passengerID = $conn->real_escape_string($passengerID);

    // Prepare the query to fetch passenger information based on the passenger ID
    $query = "SELECT * FROM passengers WHERE passenger_id = '$passengerID'";

    // Execute the query
    $result = $conn->query($query);

    // Check if the query was successful and if there is a matching passenger
    if ($result && $result->num_rows > 0) {
        // Fetch the passenger information as an associative array
        $passengerInfo = $result->fetch_assoc();
        $result->close(); // Close the result set

        return $passengerInfo;
    } else {
        // Handle the case where no passenger was found (e.g., return false)
        return false;
    }
}






function bookingCheck($bookingIDCheck,$flightTypeCheck){
    require "config.php";
    $bookingquery = "SELECT * FROM passengers WHERE booking_id='$bookingIDCheck' AND trip_type='$flightTypeCheck'";
    $result =$conn->query($bookingquery);
    if ($result->num_rows > 0) 
    {   
        $x=0;
    while ($row = $result->fetch_assoc()) {
    
        
    $this->passengerIDList[$x]=$row['passenger_id'];
    $this->passengerNameList[$x]=$row['name'];
    $this->passengerSurnameList[$x]=$row['surname'];
    $this->passengerTitleList[$x]=$row['title'];
    $this->passengerSeatList[$x]=$row['seat'];
    $this->passengerInsuranceList[$x]=$row['insurance'];

        $x++;
    }
    $this->x=$x;
    $_SESSION['passengerNumCheckin']=$x;

        
}
    else
    {
        
        echo  "Something went Wrong";
    }
}

function upload_info(){

    require "config.php";
        $err=false;

        for($x=0;$x<$this->x;$x++)
    {

        $documentType = $this->documentType[$x]; // Access the specific element from the array
        $documentNum = $this->documentNum[$x];
        $countryOfIssue = $this->countryOfIssue[$x];
        $nationality = $this->nationality[$x];
        $dateBirth = $this->dateBirth[$x];
        $passengerID =$this->passengerIDList[$x];
        $registerquery = "INSERT INTO passenger_info (document_type, document_num, country_of_issue, nationality, passenger_id, date_birth)
		VALUES ('$documentType', '$documentNum','$countryOfIssue','$nationality','$passengerID','$dateBirth')";
        		if ($conn->query($registerquery)) 
                {
                    
                }
                
                else
                {
                    $err=true;
                    
                    
                }

                $registerquery = "UPDATE passengers
                SET isChecked = 'true'
                WHERE passenger_id = '$passengerID'";
        		if ($conn->query($registerquery)) 
                {
                    
                }
                
                else
                {
                    $err=true;
                    
                    
                }
    }

    if($err==true)   {
        echo "Something went wrong";
        $conn->close();
        
    } 
    else{
        $_SESSION['checkInInfo']="done";
        echo "<script>window.location.href='../controllers/checkInSuccess.php'</script>";
    }
}

function isChecked() {
    require "config.php";
    $flag = true; // Initialize a flag variable to true

    // Get the flight code and booking code from the session
    $flightCode = $_SESSION['flightIDCheckin'];
    $bookingID = $_SESSION['bookingIDCheckin'];

    $query = "SELECT * FROM passengers WHERE flight_id='$flightCode' AND booking_id='$bookingID'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $x=0;
        while ($row = $result->fetch_assoc()) {
            // Check if the isChecked column is false for any passenger
            if ($row['isChecked'] === 'false') {
                $flag = false; // Set the flag to false if any passenger has isChecked set to false
                break; // Exit the loop, as we have found a passenger with isChecked false
            }
            $x++;
        }
        $_SESSION['PassengersNum']=$x;
        
    } else {
        $flag = false; // Set the flag to false if no passengers found for the given flight and booking
    }

    return $flag; // Return the flag value (true if all passengers have isChecked true, false otherwise)
}


function find_bookings($username){

    require "config.php";
    $bookingquery = "SELECT * FROM bookings WHERE username='$username' ORDER BY booking_id DESC";
    $result =$conn->query($bookingquery);
        if ($result->num_rows > 0) 
        {   
            $x=0;
        while ($row = $result->fetch_assoc()) {
        
            $this->bookingIDList[$x]=$row['booking_id'];
            $this->bookingDateList[$x]=$row['date'];
            $this->bookingTimeList[$x]=$row['time'];
            $x++;
        }
        $this->bookingNum= $x;
        }
        else
        {
            $this->bookingMessage=  "No bookings were found";
        }


    }
    function find_flights($selectedBookingId) {
        require "config.php";
        $this->isReturn = false;
    
        // Fetch flights and trip types for the specified booking
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
    
        // Fetch passenger information for the first flight
        $this->passengerNameList = array();
        $this->passengerSurnameList = array();
        $this->passengerTitleList = array();
        $this->passengerSeatList = array();
        $this->passengerInsuranceList = array();
    
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
    
                $x++;
            }
            $this->passengerNum = $x;
            $this->flightError = "";
        } else {
            $this->flightError = "No passengers were found for the first flight";
        }
    }
    
    
}

?>