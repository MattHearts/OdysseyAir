<?php
require_once('../libraries/fpdf/fpdf.php');
require_once('../libraries/fpdf/barcode/barcode.php');

ob_start();
// Class for PDF generation
class PDFGenarator extends FPDF
{
    function Header()
    {
        
        $this->SetTextColor(0, 0, 0);
        // Logo
        $this->Image('../images/odysseyair3.png', 10, 6, 60);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        // Title
        $this->Cell(0, 10, 'Boarding Pass', 1, 1, 'C'); // The last parameter 'true' will fill the cell with the specified color

        $this->Ln(20);
    }

    function Footer()
    {

        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Generates Boarding Pass PDF based on the given data
    public function makeBoardingPass($bookingID, $flightID, $passengerID)
    {
        require "CheckInModel.php";
        $check1 = new CheckIn();


        $flightInfo = $check1->getFlightInfoFromDatabase($flightID);

        $passengerInfo = $check1->getPassengerInfoFromDatabaseByID($passengerID);

        if ($passengerInfo) {
            // Generates the PDF using FPDF
            $pdf = new PDFGenarator();
            $pdf->AddPage();

            // Generates the barcode value based on the provided data
            $barcodeValue = 'OdysseyAir-' . $bookingID . '-' . $flightID . '-' . $passengerID;

            // Generates the barcode image and add it to the PDF
            $barcodeImagePath = '../tmp/barcode.png'; // Provide a filename for the barcode image
            barcode($barcodeImagePath, $barcodeValue, 100, 'horizontal', 'code128', false, 1);
            $pdf->Image($barcodeImagePath, 100, 30, 100, 30, 'png');
            unlink($barcodeImagePath); // Deletes the temporary barcode image

            // Adds content to the PDF
            // Flight Details
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 5, 'Flight Code: ' . $flightInfo['flight_id'], 0, 1);
            $pdf->Cell(0, 5, 'Departure: ' . $flightInfo['dep_airport'], 0, 1);
            $pdf->Cell(0, 5, 'Destination: ' . $flightInfo['dest_airport'], 0, 1);
            $pdf->Cell(0, 5, 'Date: ' . $flightInfo['dep_date'], 0, 1);
            $pdf->Cell(0, 5, 'Departure Time: ' . substr($flightInfo['dep_time'], 0, 5) . " - Arrival Time: " . substr($flightInfo['arr_time'], 0, 5), 0, 1);
            $pdf->Cell(0, 5, 'Duration: ' . $flightInfo['duration_min'] . " minutes", 0, 1);
            $pdf->Cell(0, 5, "_________________________________________________________________________________________", 0, 1);

            // Passenger Details
            $pdf->Ln(4);
            $pdf->Cell(0, 5, 'Passenger Name: ' . $passengerInfo['title'] . ' ' . $passengerInfo['name'] . ' ' . $passengerInfo['surname'], 0, 1);
            $pdf->Cell(0, 5, 'Seat: ' . $passengerInfo['seat'], 0, 1);
            $pdf->Cell(0, 5, 'Insurance: ' . $passengerInfo['insurance'], 0, 1);
            $pdf->Cell(0, 5, 'Check In Bags: ' . $passengerInfo['baggage_num'], 0, 1);
            $pdf->Ln(10);
            $pdf->Image('../images/odyssey_airline-pass.png', 10, 105, 190);;

            // Outputs the PDF as a downloadable file
            $pdf->Output('boarding_pass.pdf', 'D');


            exit();
        } else {
            
            echo "Passenger not found.";
        }
    }
}
