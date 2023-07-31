<?php
  require_once('../libraries/fpdf/fpdf.php');
//class for ticket search

// Inner class for PDF generation
class ReceiptPDFGenerator extends FPDF
{
    function Header()
    {
        // Background color
        $this->SetTextColor(0, 0, 0);
        // Logo
        $this->Image('../images/odysseyair3.png', 10, 6, 60);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(0, 10, 'Booking Receipt', 1, 1, 'C');
        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}


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
        public $passengerBaggageList=array();
        public $passengerCheckInTypeList=array();

        public $passengerNameListR=array();
        public $passengerSurnameListR=array();
        public $passengerTitleListR=array();
        public $passengerSeatListR=array();
        public $passengerInsuranceListR=array();
            public $passengerBaggageListR=array();
            public $passengerCheckInTypeListR=array();

    public $depAirportR;
    public $destAirportR;
    public $depDateR;
    public $depTimeR;
    public $arrTimeR;
    public $durationTimeMinR;
    public $flightCodeR;
    public $flightPriceR;
    public $depAirport;
    public $destAirport;
    public $depDate;
    public $depTime;
    public $arrTime;
    public $durationTimeMin;
    public $flightCode;
    public $flightPrice;
    public $checkinType;
    public $baggageNum;

    public $bookingDate;
    public $bookingTime;
    public $bookingPrice;

    // Method to generate the receipt in PDF
    public function generateReceiptPDF()
    {
        define('EURO',chr(128));
        // Fetch flight and passenger information...

        // If passenger information is found, proceed to create and serve the PDF
        
            // Generate the PDF using FPDF
            $pdf = new ReceiptPDFGenerator();
            $pdf->AddPage();


           // Add content to the PDF (customize as needed based on your data)
           $pdf->SetFont('Arial', '', 18);
           $pdf->Cell(0, 10, 'Booking Information ', 0, 1);
           $pdf->SetFont('Arial', '', 12);
           $pdf->Cell(0, 5, 'Booking ID: ' . $this->bookingID, 0, 1);
           $pdf->Cell(0, 5, 'Date Booked: ' . $this->bookingDate, 0, 1);
           $pdf->Cell(0, 5, 'Time Booked: ' . $this->bookingTime, 0, 1);
           $pdf->Cell(0, 5, 'Email: ' . $this->username, 0, 1);
           $pdf->Cell(0, 5, "________________________________________________________________", 0, 1);
           $pdf->Ln(7);

           $pdf->SetFont('Arial', '', 16);
           $pdf->Cell(0, 10, 'Going ', 0, 1);
           $pdf->SetFont('Arial', '', 12);
           $pdf->Cell(0, 5, 'Flight ID: ' . $this->flightCode, 0, 1);
           $pdf->Cell(0, 5, 'From: ' . $this->depAirport.' to '.$this->destAirport , 0, 1);
           $pdf->Cell(0, 5, 'Date: ' . $this->depDate, 0, 1);
           $pdf->Cell(0, 5, 'Departure Time: ' . substr($this->depTime, 0, 5) . " - Arrival Time: " . substr($this->arrTime, 0, 5), 0, 1);
           $pdf->Cell(0, 5, 'Duration: ' .$this->durationTimeMin . " minutes", 0, 1);
           $pdf->Cell(0, 5, 'Price: ' . $this->flightPrice.' '.EURO, 0, 1);
           $pdf->Cell(0, 5, "________________________________________________________________", 0, 1);
           $pdf->Ln(2);
           for ($x=0;$x<$_SESSION['whosGoing'];$x++){
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(0, 5, 'Passenger ' . $x+1, 0, 1);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 5, 'Title:' . $this->passengerTitleList[$x], 0, 1);
            $pdf->Cell(0, 5, 'Name:' . $this->passengerSurnameList[$x], 0, 1);
            $pdf->Cell(0, 5, 'Surname:' . $this->passengerNameList[$x], 0, 1);
            $pdf->Cell(0, 5, 'Seat:' . $this->passengerSeatList[$x], 0, 1);
            $pdf->Cell(0, 5, 'Baggage:' . $this->passengerBaggageList[$x].' x 20 '.EURO.' = '.$this->passengerBaggageList[$x]*20 . ' '.EURO, 0, 1);
             // Passenger Insurance Information based on the passengerInsuranceList
             switch ($this->passengerInsuranceList[$x]) {
                case 'go_insurance':
                    $pdf->Cell(0, 5, 'Insurance: ' . $this->passengerInsuranceList[$x].' = 8 '.EURO, 0, 1);

                    break;

                case 'no_insurance':
                    $pdf->Cell(0, 5, 'Insurance: ' . $this->passengerInsuranceList[$x], 0, 1);
                    break;

                case 'all_trip_insurance':
                    $pdf->Cell(0, 5, 'Insurance: ' . $this->passengerInsuranceList[$x].' = 13 '.EURO, 0, 1);
                    break;

                case 'return_insurance':
                    $pdf->Cell(0, 5, 'Insurance: ' . $this->passengerInsuranceList[$x].' = 8 '.EURO, 0, 1);
                    break;

                default:
                $pdf->Cell(0, 5, 'Insurance: ' . $this->passengerInsuranceList[$x], 0, 1);
                    break;
            
           }
           $pdf->Ln(4);
        }
        if ($_SESSION['flightType']=="return"){
        $pdf->Cell(0, 5, "________________________________________________________________", 0, 1);
        $pdf->Cell(0, 5, "________________________________________________________________", 0, 1);
        $pdf->Ln(4);
        $pdf->SetFont('Arial', '', 16);
        $pdf->Cell(0, 10, 'Returning ', 0, 1);
        $pdf->SetFont('Arial', '', 12);
           $pdf->Cell(0, 5, 'Flight ID: ' . $this->flightCodeR, 0, 1);
           $pdf->Cell(0, 5, 'From: ' . $this->depAirportR.' to '.$this->destAirportR , 0, 1);
           $pdf->Cell(0, 5, 'Date: ' . $this->depDateR, 0, 1);
           $pdf->Cell(0, 5, 'Departure Time: ' . substr($this->depTimeR, 0, 5) . " - Arrival Time: " . substr($this->arrTimeR, 0, 5), 0, 1);
           $pdf->Cell(0, 5, 'Duration: ' .$this->durationTimeMinR . " minutes", 0, 1);
           $pdf->Cell(0, 5, 'Price: ' . $this->flightPriceR.' '.EURO, 0, 1);
           $pdf->Cell(0, 5, "________________________________________________________________", 0, 1);
           $pdf->Ln(2);
           for ($x=0;$x<$_SESSION['whosGoing'];$x++){
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(0, 5, 'Passenger ' . $x+1, 0, 1);
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 5,  $this->passengerTitleListR[$x], 0, 1);
            $pdf->Cell(0, 5,  $this->passengerSurnameListR[$x], 0, 1);
            $pdf->Cell(0, 5,  $this->passengerNameListR[$x], 0, 1);
            $pdf->Cell(0, 5, 'Seat:' . $this->passengerSeatListR[$x], 0, 1);
            $pdf->Cell(0, 5, 'Baggage:' . $this->passengerBaggageListR[$x].' x 20 '.EURO.' = '.$this->passengerBaggageListR[$x]*20 . ' '.EURO, 0, 1);
             // Passenger Insurance Information based on the passengerInsuranceList
             switch ($this->passengerInsuranceList[$x]) {
                case 'go_insurance':
                    $pdf->Cell(0, 5, 'Insurance: ' . $this->passengerInsuranceListR[$x].'= 8 '.EURO, 0, 1);

                    break;

                case 'no_insurance':
                    $pdf->Cell(0, 5, 'Insurance: ' . $this->passengerInsuranceListR[$x], 0, 1);
                    break;

                case 'all_trip_insurance':
                    $pdf->Cell(0, 5, 'Insurance: ' . $this->passengerInsuranceListR[$x].'= 13 '.EURO, 0, 1);
                    break;

                case 'return_insurance':
                    $pdf->Cell(0, 5, 'Insurance: ' . $this->passengerInsuranceListR[$x].'= 8 '.EURO, 0, 1);
                    break;

                default:
                $pdf->Cell(0, 5, 'Insurance: ' . $this->passengerInsuranceListR[$x], 0, 1);
                    break;
            
           }
           $pdf->Ln(4);
        } 
    }
    if($this->passengerCheckInTypeList[0]=='airport'){
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(0, 5,'Check In: in Airport = 22 '.EURO, 0, 1);
    }
    else{
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(0, 5,'Check In: Online', 0, 1);
    }

    $pdf->SetFont('Arial', '', 20);
    $pdf->Cell(0, 30, 'Total Price: ' . $this->bookingPrice . ' '.EURO, 0, 1);
    
    

    
            // Output the PDF as a downloadable file
            $pdf->Output('booking_receipt.pdf', 'D');

            // After sending the PDF, exit the script to prevent any further output
            exit();
 
    }


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
        $this->checkinType=$_SESSION['checkIn'];
        $this->baggageNum=$_SESSION['suitcaseNumber'.$x];
        
        $registerquery = "INSERT INTO passengers (flight_id, booking_id, name, surname, title, seat, insurance,trip_type, isChecked, checkin_type, baggage_num)
        VALUES ('$this->flightID','$this->bookingID','$this->passengerName', '$this->passengerSurname','$this->passengerTitle','$this->passengerSeat','$this->insurance','go','false','$this->checkinType','$this->baggageNum')";
        
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
        $this->checkinType=$_SESSION['checkin'];
        $this->baggageNum=$_SESSION['suitcaseNumber'.$x];
        
        $registerquery = "INSERT INTO passengers (flight_id, booking_id, name, surname, title, seat, insurance,trip_type, isChecked, checkin_type, baggage_num)
        VALUES ('$this->flightID','$this->bookingID','$this->passengerName', '$this->passengerSurname','$this->passengerTitle','$this->passengerSeat','$this->insurance','return','false','$this->checkinType','$this->baggageNum')";
        
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
        $price=$_SESSION['overallPriceV3'];
        ///////////////////////////////////////////////
        $registerquery = "INSERT INTO bookings (username, date, time,price) VALUES ('$this->username','$date','$time','$price')";
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
        
        require "config.php";

        $bookingquery = "SELECT * FROM bookings WHERE booking_id='$this->bookingID'";
        $result =$conn->query($bookingquery);
        
        if ($result->num_rows > 0) 
        {   
            
        while ($row = $result->fetch_assoc()) {
        

            $this->username=$row['username'];
            $this->bookingDate=$row['date'];
            $this->bookingTime=$row['time'];
            $this->bookingPrice=$row['price'];

        
        }
        
    } 
        else
        {
            
            $this->message = "Something went Wrong";
        }


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
            $this->flightPrice=$row['price'];
        
        }
        
    } 
        else
        {
            
            $this->message = "Something went Wrong";
        }

        if($_SESSION['flightType']=="return"){
        $this->flightIDR=$_SESSION["flightIDR"];
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
        $this->flightPriceR=$row['price'];


        
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
        $this->passengerBaggageList[$x]=$row['baggage_num'];
        $this->passengerInsuranceList[$x]=$row['insurance'];
        $this->passengerCheckInTypeList[$x]=$row['checkin_type'];

            $x++;
        }
        
            
    }
        else
        {
            
            $this->message = "Something went Wrong";
        }

        if($_SESSION['flightType']=="return"){
        $bookingquery = "SELECT * FROM passengers WHERE booking_id='$this->bookingID' AND flight_id='$this->flightIDR'";
        $result =$conn->query($bookingquery);
        if ($result->num_rows > 0) 
        {   
            $x=0;
        while ($row = $result->fetch_assoc()) {
        
            
        
        $this->passengerNameListR[$x]=$row['name'];
        $this->passengerSurnameListR[$x]=$row['surname'];
        $this->passengerTitleListR[$x]=$row['title'];
        $this->passengerSeatListR[$x]=$row['seat'];
        $this->passengerBaggageListR[$x]=$row['baggage_num'];
        $this->passengerInsuranceListR[$x]=$row['insurance'];
        $this->passengerCheckInTypeListR[$x]=$row['checkin_type'];

            $x++;
        }
        
            
    }
        else
        {
            
            $this->message = "Something went Wrong";
        }
    }
    
    }
}



    