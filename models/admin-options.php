<?php

class AdminOptions {




    public function getFlightList() {
        require "config.php";
        $sql = "SELECT flight_id, dep_airport, dest_airport, dep_date, dep_time, arr_time, duration_min, price FROM flights";
        $result = $conn->query($sql);

        $flightList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $flightList[] = $row;
        }

        return $flightList;
    }

    public function addFlight($departureAirport, $destinationAirport, $date, $departureTime, $arrivalTime, $duration, $price, $repeatWeeks) {
        require "config.php";
    
        // Insert the initial flight
        $sql = "INSERT INTO flights (dep_airport, dest_airport, dep_date, dep_time, arr_time, duration_min, price) 
                VALUES ('$departureAirport', '$destinationAirport', '$date', '$departureTime', '$arrivalTime', '$duration', '$price')";
    
        // Execute the SQL query
        $result = $conn->query($sql);
    
        // Check if the insertion was successful
        if ($result) {
            echo "Flight added successfully!";
        } else {
            echo "Failed to add the flight. Please try again.";
        }
    
        // Get the last inserted flight ID
        $flightID = $conn->insert_id;
    
        // Repeat the flight for the specified number of weeks
        for ($week = 1; $week < $repeatWeeks; $week++) {
            $departureDate = date('Y-m-d', strtotime($date . ' + ' . ($week * 7) . ' days'));
            $arrivalDate = date('Y-m-d', strtotime($departureDate . ' + ' . $duration . ' minutes'));
    
            // Insert the repeated flight
            $sql = "INSERT INTO flights (dep_airport, dest_airport, dep_date, dep_time, arr_time, duration_min, price) 
                    VALUES ('$departureAirport', '$destinationAirport', '$departureDate', '$departureTime', '$arrivalTime', '$duration', '$price')";
    
            // Execute the SQL query
            $result = $conn->query($sql);
    
            // Check if the insertion was successful
            if (!$result) {
                echo "Failed to add the repeated flight for week $week. Please try again.";
            }
        }
    }

    public function updateFlight($flightID, $departureAirport, $destinationAirport, $date, $departureTime, $arrivalTime, $duration, $price) {
        require "config.php";
    
        // Insert the initial flight
        $sql = "UPDATE flights SET dep_airport='$departureAirport', dest_airport='$destinationAirport', dep_date='$date', dep_time='$departureTime', arr_time='$arrivalTime', duration_min='$duration', price='$price' 
                WHERE flight_id = $flightID";
    
        // Execute the SQL query
        $result = $conn->query($sql);
    
        // Check if the insertion was successful
        if ($result) {
            echo "Flight with ID:".$flightID." updated successfully!";
        } else {
            echo "Failed to update the flight. Please try again.";
        }
    
    }
    
    
    

    public function moveFlightToCancelledTable($flightID) {
        require "config.php";
        $sql = "SELECT * FROM flights WHERE flight_id = $flightID";
        $result = $conn->query($sql);

            // Check if the flight exists
    if ($result->num_rows > 0) {
        $flight = $result->fetch_assoc();

        $flightID=$flight['flight_id'];
        $departureAirport=$flight['dep_airport'];
        $destinationAirport=$flight['dest_airport'];
        $date=$flight['dep_date'];
        $departureTime=$flight['dep_time'];
        $arrivalTime=$flight['arr_time'];
        $duration=$flight['duration_min'];
        $price=$flight['price'];

         // Move the flight to the cancelled-flights table
         $sql = "INSERT INTO cancelled_flights (flight_id, dep_airport, dest_airport, dep_date, dep_time, arr_time, duration_min, price) 
         VALUES ('$flightID', '$departureAirport', '$destinationAirport', '$date', '$departureTime', '$arrivalTime', '$duration', '$price')";
            $result = $conn->query($sql);

            // Check if the insertion was successful
            if ($result) {
                // Delete the flight from the flights table
                $sql = "DELETE FROM flights WHERE flight_id = $flightID";
                $result = $conn->query($sql);
    
                if ($result) {
                    return true;
                }
            }
        }
    
        return false;
    }

    public function movePassengersToCancelledTable($flightID) {
        require "config.php";

        
        $sql = "SELECT * FROM passengers WHERE flight_id='$flightID'";
        $result = $conn->query($sql);

            // Check if the flight exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        

        $passengerID=$row['passenger_id'];
        $bookingID=$row['booking_id'];
        $passengerName=$row['name'];
        $passengerSurname=$row['surname'];
        $passengerTitle=$row['title'];
        $passengerSeat=$row['seat'];

         // Move the flight to the cancelled-flights table
         $sql = "INSERT INTO cancelled_flights_passengers (passenger_id, flight_id, booking_id, name, surname, title, seat) 
         VALUES ('$flightID', '$passengerID', '$bookingID', '$passengerName', '$passengerSurname', '$passengerTitle', '$passengerSeat')";
            $result = $conn->query($sql);

            // Check if the insertion was successful
            if ($result) {
                // Delete the flight from the flights table
                $sql = "DELETE FROM passengers WHERE flight_id = $flightID";
                $result = $conn->query($sql);
    
                if ($result) {
                    return true;
                }
            }
        }
    
        return true;
    }


    public function getPassengersList($flightID) {
        require "config.php";
        $sql = "SELECT * FROM passengers WHERE flight_id='$flightID'";
        $result = $conn->query($sql);

        $passengersList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $passengersList[] = $row;
        }

        return $passengersList;
    }

        // Function to fetch passenger document info based on the passengerID
        public function getPassengerDocumentInfo($passengerID) {
            require "config.php";
    
            // Escape the input to prevent SQL injection
            $passengerID = mysqli_real_escape_string($conn, $passengerID);
    
            $sql = "SELECT * FROM passenger_info WHERE passenger_id='$passengerID'";
            $result = $conn->query($sql);
    
    
            // Fetch the document info from the result set
            $passengerDocumentInfo = array();
    

            while ($row = mysqli_fetch_assoc($result)) {
                $passengerDocumentInfo[] = $row;
            }
    
    
            return $passengerDocumentInfo;
        }
    
    // Add other methods for managing flights, such as updating flight details, etc.
    public function getCancelledFlightsList() {
        require "config.php";
        $sql = "SELECT flight_id, dep_airport, dest_airport, dep_date, dep_time, arr_time, duration_min, price FROM cancelled_flights";
        $result = $conn->query($sql);

        $flightList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $flightList[] = $row;
        }

        return $flightList;
    }

    
    public function getCancelledPassengersList($flightID) {
        require "config.php";
        $sql = "SELECT passenger_id, booking_id, name, surname, title, seat FROM cancelled_flights_passengers WHERE flight_id='$flightID'";
        $result = $conn->query($sql);
        

        $passengersList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $passengersList[] = $row;
        }

        return $passengersList;
    }

   /* public function addAirport($airportID, $airportCity, $airportName, $airportCountry) {
        require "config.php";
    
        // Insert the initial flight
        $sql = "INSERT INTO airports (airport_ID , airport_city, airport_name, country) 
                VALUES ('$airportID', '$airportCity', '$airportName', '$airportCountry')";
        // Execute the SQL query
        $result = $conn->query($sql);
    
        // Check if the insertion was successful
        if ($result) {
            echo "Airport added successfully!";
        } else {
            echo "Failed to add the airport. Please try again.";
        }
    
    }*/
    public function addAirport($airportID, $airportCity, $airportName, $airportCountry) {
    require "config.php";

    $sql = "SELECT * FROM airports WHERE airport_ID='$airportID'";
        $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Airport already exists.";
    $conn->close();}
    else
    {
    // Prepare the SQL statement
    $sql = "INSERT INTO airports (airport_ID, airport_city, airport_name, country) 
            VALUES (?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bind_param("ssss", $airportID, $airportCity, $airportName, $airportCountry);

    // Execute the statement
    $result = $stmt->execute();

    // Check if the insertion was successful
    if ($result) {
        echo "Airport added successfully!";
    } else {
        echo "Failed to add the airport. Please try again.";
    }
        // Close the statement and database connection
        $stmt->close();
    }

    }


    public function checkAirportInFlights($airportID) {
        require "config.php";
        
        // Check if the airport is present in the flights table
        $sql = "SELECT * FROM flights WHERE dep_airport = '$airportID' OR dest_airport = '$airportID'";
        $result = $conn->query($sql);
        
        if ($result->num_rows>0) {
            // Return true if the airport is present in flights table
            return true;
        } else {
            return false;
        }
    }
    public function getUserList() {
        require "config.php";
        $sql = "SELECT username, surname, type FROM user";
        $result = $conn->query($sql);

        $flightList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $userList[] = $row;
        }

        return $userList;
    }
    public function getAccountBookings($username) {
        require "config.php";
    
        $bookingQuery = "SELECT * FROM bookings WHERE username = '$username'";
        $bookingResult = $conn->query($bookingQuery);
    
        $bookings = array();
        $booking = array(); 
    
        while ($bookingRow = mysqli_fetch_assoc($bookingResult)) {
            $bookingID = $bookingRow['booking_id'];
    
            // Retrieve 'go' flights based on booking ID
            $flightQueryGo = "SELECT * FROM flights 
                              WHERE flight_id IN (
                                  SELECT flight_id FROM passengers WHERE booking_id = $bookingID AND trip_type = 'go'
                              )";
            $flightResultGo = $conn->query($flightQueryGo);
    
            // Process 'go' flights for this booking
            while ($flightRowGo = mysqli_fetch_assoc($flightResultGo)) {
               
                $booking['booking_id'] = $bookingRow['booking_id'];
                $booking['book_date'] = $bookingRow['date'];
                $booking['book_time'] = $bookingRow['time'];
                $booking['book_price'] = $bookingRow['price'];
    
                $booking['flight_id'] = $flightRowGo['flight_id'];
                $booking['dep_airport'] = $flightRowGo['dep_airport'];
                $booking['dest_airport'] = $flightRowGo['dest_airport'];
                $booking['dep_date'] = $flightRowGo['dep_date'];
                $booking['dep_time'] = $flightRowGo['dep_time'];
                $booking['arr_time'] = $flightRowGo['arr_time'];
                $booking['duration_min'] = $flightRowGo['duration_min'];
                $booking['price'] = $flightRowGo['price'];
    
                // Retrieve passenger information for 'go' flight
                $passengerQueryGo = "SELECT * FROM passengers 
                                     WHERE booking_id = $bookingID 
                                     AND flight_id = " . $flightRowGo['flight_id'] . "
                                     AND trip_type = 'go'";
                $passengerResultGo = $conn->query($passengerQueryGo);
    
                $passengersGo = array();
                while ($passengerRowGo = mysqli_fetch_assoc($passengerResultGo)) {
                    $passenger = array();
                    $passenger['passenger_id'] = $passengerRowGo['passenger_id'];
                    $passenger['title'] = $passengerRowGo['title'];
                    $passenger['name'] = $passengerRowGo['name'];
                    $passenger['surname'] = $passengerRowGo['surname'];
                    $passenger['seat'] = $passengerRowGo['seat'];
                    $passenger['trip_type'] = $passengerRowGo['trip_type'];
                    $passengersGo[] = $passenger;
                }
    
                $booking['passengers'] = $passengersGo;
                $booking['isReturn'] = false; // Set 'isReturn' flag to false for 'go' flights
                $bookings[] = $booking;
            }
    
            // Retrieve 'return' flights based on booking ID
            $flightQueryReturn = "SELECT * FROM flights 
                                  WHERE flight_id IN (
                                      SELECT flight_id FROM passengers WHERE booking_id = $bookingID AND trip_type = 'return'
                                  )";
            $flightResultReturn = $conn->query($flightQueryReturn);
    
            // If there are any 'return' flights, process them for this booking
            if (mysqli_num_rows($flightResultReturn) > 0) {
                while ($flightRowReturn = mysqli_fetch_assoc($flightResultReturn)) {
                    $booking['flight_idR'] = $flightRowReturn['flight_id'];
                    $booking['dep_airportR'] = $flightRowReturn['dep_airport'];
                    $booking['dest_airportR'] = $flightRowReturn['dest_airport'];
                    $booking['dep_dateR'] = $flightRowReturn['dep_date'];
                    $booking['dep_timeR'] = $flightRowReturn['dep_time'];
                    $booking['arr_timeR'] = $flightRowReturn['arr_time'];
                    $booking['duration_minR'] = $flightRowReturn['duration_min'];
                    $booking['priceR'] = $flightRowReturn['price'];
    
                    // No passengers for 'return' flight, so set passengers as an empty array
                    $booking['passengersR'] = array();
                    $booking['isReturn'] = true; // Set 'isReturn' flag to true for 'return' flights
                    $bookings[] = $booking;
                }
            } else {
                $booking['isReturn'] = false; // Set 'isReturn' flag to false when there are no 'return' flights
            }
        }
    
        return $bookings;
    }
    
}


