<?php
//class for ticket search
class Ticket{
    public $bookingID;
    public $username;
    public $flightID;
    public $flightIDR;
    public $customerID;
    public $passengerName;
    public $passengerSurname;
    public $passengerTitle;
    public $passengerSeat;
    public $insurance;
    public $message;
    public $passengerNameList=array();
    public $passengerSurnameList=array();
    public $passengerTitleList=array();
    public $passengerSeatList=array();
    public $passengerInsuranceList=array();
    public $depAirportR;
    public $destAirportR;
    public $depDateR;
    public $depTimeR;
    public $arrTimeR;
    public $durationTimeMinR;
    public $flightCodeR;
    public $depAirport;
    public $destAirport;
    public $depDate;
    public $depTime;
    public $arrTime;
    public $durationTimeMin;
    public $flightCode;



    function register_passengers($x)
    {
        require "config.php";

        $this->flightID=$_SESSION['flightID'];
        $this->bookingID=$_SESSION['bookingID'];
        $this->username=$_SESSION['username'];
        $this->passengerName=$_SESSION['passengerName'.$x];
        $this->passengerSurname=$_SESSION['passengerSurname'.$x];
        $this->passengerTitle=$_SESSION['passengerTitle'.$x];
        $this->passengerSeat=$_SESSION['passengerSeat'.$x];
        $this->insurance=$_SESSION['insurance'.$x];
        
        $registerquery = "INSERT INTO passengers (flight_id, booking_id, name, surname, title, seat, insurance,trip_type,isChecked)
        VALUES ('$this->flightID','$this->bookingID','$this->passengerName', '$this->passengerSurname','$this->passengerTitle','$this->passengerSeat','$this->insurance','go','false')";
        
        if ($conn->query($registerquery)) 
        {
        
            
            $this->message = "Success!";
            
            
        }
    }
    function register_passengersR($x)
    {
        require "config.php";

        $this->flightID=$_SESSION['flightIDR'];
        $this->bookingID=$_SESSION['bookingID'];
        $this->username=$_SESSION['username'];
        $this->passengerName=$_SESSION['passengerName'.$x];
        $this->passengerSurname=$_SESSION['passengerSurname'.$x];
        $this->passengerTitle=$_SESSION['passengerTitle'.$x];
        $this->passengerSeat=$_SESSION['passengerSeat'.$x];
        $this->insurance=$_SESSION['insurance'.$x];
        
        $registerquery = "INSERT INTO passengers (flight_id, booking_id, name, surname, title, seat, insurance,trip_type,isChecked)
        VALUES ('$this->flightID','$this->bookingID','$this->passengerName', '$this->passengerSurname','$this->passengerTitle','$this->passengerSeat','$this->insurance','return','false')";
        
        if ($conn->query($registerquery)) 
        {
        
            
            $this->message = "Success!";
            
            
        }
    }

    function register_booking()
    {
        require "config.php";
    
        $this->username = $_SESSION['username'];
    
        $date=date('Y-m-d');
        $time=date('h:i:sa');
        ///////////////////////////////////////////////
        $registerquery = "INSERT INTO bookings (username, date, time) VALUES ('$this->username','$date','$time')";
        $result = $conn->query($registerquery);
        if ($result) {
            $this->bookingID = $conn->insert_id;
            $_SESSION['bookingID'] = $this->bookingID;
        } else {
            $this->message = "Something went wrong";
        }
    
        $conn->close();
    }
 function show_booking()
    {
        $this->bookingID=$_SESSION["bookingID"];
        $this->flightID=$_SESSION["flightID"];
        $this->flightIDR=$_SESSION["flightIDR"];
        require "config.php";


        $bookingquery = "SELECT * FROM flights WHERE flight_id='$this->flightID'";
        $result =$conn->query($bookingquery);
        if ($result->num_rows > 0) 
        {   
            $x=0;
        while ($row = $result->fetch_assoc()) {
        

            $this->depAirport=$row['dep_airport'];
            $this->destAirport=$row['dest_airport'];
            $this->depDate=$row['dep_date'];
            $this->depTime=$row['dep_time'];
            $this->arrTime=$row['arr_time'];
            $this->durationTimeMin=$row['duration_min'];
            $this->flightCode=$row['flight_id'];
        
        }
        
    } 
        else
        {
            
            $this->message = "Something went Wrong";
        }

        if($_SESSION['flightType']=="return"){
        $bookingquery = "SELECT * FROM flights WHERE flight_id='$this->flightIDR'";
        $result =$conn->query($bookingquery);
        if ($result->num_rows > 0) 
        {   
            $x=0;
        while ($row = $result->fetch_assoc()) {
        
      
        
        $this->depAirportR=$row['dep_airport'];
        $this->destAirportR=$row['dest_airport'];
        $this->depDateR=$row['dep_date'];
        $this->depTimeR=$row['dep_time'];
        $this->arrTimeR=$row['arr_time'];
        $this->durationTimeMinR=$row['duration_min'];
        $this->flightCodeR=$row['flight_id'];


        
        }
        
            
    }
        else
        {
            
            $this->message = "Something went Wrong";
        }
    }

        
        $bookingquery = "SELECT * FROM passengers WHERE booking_id='$this->bookingID' AND flight_id='$this->flightID'";
        $result =$conn->query($bookingquery);
        if ($result->num_rows > 0) 
        {   
            $x=0;
        while ($row = $result->fetch_assoc()) {
        
            
        
        $this->passengerNameList[$x]=$row['name'];
        $this->passengerSurnameList[$x]=$row['surname'];
        $this->passengerTitleList[$x]=$row['title'];
        $this->passengerSeatList[$x]=$row['seat'];
        $this->passengerInsuranceList[$x]=$row['insurance'];

            $x++;
        }
        
            
    }
        else
        {
            
            $this->message = "Something went Wrong";
        }
    }

    
}