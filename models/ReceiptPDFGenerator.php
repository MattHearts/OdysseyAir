<?php
  require_once('../libraries/fpdf/fpdf.php');
  require_once ('../libraries/fpdf/barcode/barcode.php');

  ob_start();
  // Class for PDF generation
  class ReceiptPDFGenarator extends FPDF
  {
      function Header()
      {
          // Background color
          $this->SetTextColor(0, 0, 0);
          // Logo
          $this->Image('../images/odysseyair2.png', 10, 6, 60);
          // Arial bold 15
          $this->SetFont('Arial', 'B', 15);
          // Move to the right
          $this->Cell(80);
          // Title
          $this->Cell(0, 10, 'Booking Receipt', 1, 1, 'C'); // The last parameter 'true' will fill the cell with the specified color
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
  
      // Inside the PDFGenarator class
      public function makeBoardingPass($bookingID, $flightID, $passengerID)
      {
          require "CheckInModel.php";
          $check1 = new CheckIn();
          


        
          // Fetch flight information from the database based on the flight ID
          // Replace this with your actual database query to fetch flight details
          $flightInfo = $check1->getFlightInfoFromDatabase($flightID);
  
          // Fetch passenger information from the database based on the passenger ID
          // Replace this with your actual database query to fetch passenger details
          $passengerInfo = $check1->getPassengerInfoFromDatabaseByID($passengerID);
  
          // If passenger information is found, proceed to create and serve the PDF
          if ($passengerInfo) {
              // Generate the PDF using FPDF
              $pdf = new PDFGenarator();
              $pdf->AddPage();
              
            // Generate the barcode value based on the provided data
            $barcodeValue = 'OdysseyAir-' . $bookingID . '-' . $flightID . '-' . $passengerID;

            // Generate the barcode image and add it to the PDF
            $barcodeImagePath = '../tmp/barcode.png'; // Provide a filename for the barcode image
            barcode($barcodeImagePath, $barcodeValue, 100, 'horizontal', 'code128', false, 1);
            //$pdf->Image($barcodeImagePath, $curX + 130, $curY - 10, 80, 20, 'png');
            $pdf->Image($barcodeImagePath, 100, 30, 100, 30, 'png');
            unlink($barcodeImagePath); // Delete the temporary barcode image

              // Add content to the PDF (customize as needed based on your data)
              $pdf->SetFont('Arial', '', 12);
              $pdf->Cell(0, 5, 'Flight Code: ' . $flightInfo['flight_id'], 0, 1);
              $pdf->Cell(0, 5, 'Departure: ' . $flightInfo['dep_airport'], 0, 1);
              $pdf->Cell(0, 5, 'Destination: ' . $flightInfo['dest_airport'], 0, 1);
              $pdf->Cell(0, 5, 'Date: ' . $flightInfo['dep_date'], 0, 1);
              $pdf->Cell(0, 5, 'Departure Time: ' . substr($flightInfo['dep_time'], 0, 5) . " - Arrival Time: " . substr($flightInfo['arr_time'], 0, 5), 0, 1);
              $pdf->Cell(0, 5, 'Duration: ' . $flightInfo['duration_min'] . " minutes", 0, 1);
              $pdf->Cell(0, 5, "_________________________________________________________________________________________", 0, 1);
  
              // Passenger Details on the Right Side
              $pdf->Ln(4);
              $pdf->Cell(0, 5, 'Passenger Name: ' . $passengerInfo['title'] . ' ' . $passengerInfo['name'] . ' ' . $passengerInfo['surname'], 0, 1);
              $pdf->Cell(0, 5, 'Seat: ' . $passengerInfo['seat'], 0, 1);
              $pdf->Cell(0, 5, 'Insurance: ' . $passengerInfo['insurance'], 0, 1);
              
  
              // Add more details here based on your data
  
              // Add a barcode to the boarding pass (you'll need a barcode library)
              // Replace the "generateBarcode()" function with your actual barcode generation code
              //$barcodeImage = generateBarcode($barcodeValue);
              //$pdf->Image($barcodeImage, 80, 60, 50, 10, 'png');
  
        // Output the PDF as a downloadable file
        $pdf->Output('boarding_pass.pdf', 'D');

        // After sending the PDF, exit the script to prevent any further output
        exit();
          } else {
              // Handle the case where no passenger information was found (e.g., show an error message)
              echo "Passenger not found.";
          }
      }
  }
?>  