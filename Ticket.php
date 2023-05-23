<?php
//class for ticket search
class Ticket{
    public $depAirport;
    public $destAirport;
    public $flightID;
    public $customerID;
    public $passengerName;
    public $passengerSurname;
    public $passengerTitle;
    public $passengerSeat;
    public $incurance;
    public $message;
    public $passengerNameList=array();
    public $passengerSurnameList=array();
    public $passengerTitleList=array();
    public $passengerSeatList=array();



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
        $this->incurance=$_SESSION['incurance'.$x];
        
        $registerquery = "INSERT INTO passengers (flight_id, booking_id, name, surname, title, seat)
        VALUES ('$this->flightID','$this->bookingID','$this->passengerName', '$this->passengerSurname','$this->passengerTitle','$this->passengerSeat')";
        
        if ($conn->query($registerquery)) 
        {
        
            
           
            
            
        }
    }

    function register_booking()
    {
        require "config.php";


        $this->username=$_SESSION['username'];
        
        ///////////////////////////////////////////////
        $registerquery = "INSERT INTO bookings (username)
        VALUES ('$this->username')";
        $result =$conn->query($registerquery);
        if ($conn->query($registerquery)) 
        {
            $conn->close();

        }
        require "config.php";

        $loginquery = "SELECT * FROM bookings WHERE username='$this->username'";
        $result =$conn->query($loginquery);
        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            $this->bookingID= $row['booking_id'];

            
            $_SESSION['bookingID']=$this->bookingID;
            $conn->close();
        }
        else
        {
            $conn->close();
            $this->message = "Something went Wrong";
        }
    }

 function show_booking()
    {
        $this->bookingID=$_SESSION["bookingID"];
        require "config.php";

        $bookingquery = "SELECT * FROM passengers WHERE booking_id='$this->bookingID'";
        $result =$conn->query($bookingquery);
        if ($result->num_rows > 0) 
        {   
            $row = $result->fetch_assoc();
            $this->flightID= $row['flight_id'];
            // Loop through each row
            $x=0;
        while ($row = $result->fetch_assoc()) {
        // Access individual row data using $row['column_name']
        
            
        
        $this->passengerNameList[$x]=$row['name'];
        $this->passengerSurnameList[$x]=$row['surname'];
        $this->passengerTitleList[$x]=$row['title'];
        $this->passengerSeatList[$x]=$row['seat'];

            $x++;
        }
            $conn->close();
    }
        else
        {
            $conn->close();
            $this->message = "Something went Wrong";
        }
    }

    
}