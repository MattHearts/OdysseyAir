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
        $sql = "SELECT passenger_id, booking_id, name, surname, title, seat FROM passengers WHERE flight_id='$flightID'";
        $result = $conn->query($sql);

        $passengersList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $passengersList[] = $row;
        }

        return $passengersList;
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

    // Retrieve the bookings for the specified username
    $bookingQuery = "SELECT * FROM bookings WHERE username = '$username'";
    $bookingResult = $conn->query($bookingQuery);

    $bookings = array();

    // Process each booking
    while ($bookingRow = mysqli_fetch_assoc($bookingResult)) {
        $bookingID = $bookingRow['booking_id'];

        // Retrieve flight information based on the booking ID
        $flightQuery = "SELECT * FROM flights WHERE flight_id = (SELECT flight_id FROM passengers WHERE booking_id = $bookingID LIMIT 1)";
        $flightResult = $conn->query($flightQuery);
        $flightRow = mysqli_fetch_assoc($flightResult);

        $booking = array();
        $booking['booking_id'] = $bookingRow['booking_id'];

        if ($flightRow) {
            // Flight found
            $booking['flight_id'] = $flightRow['flight_id'];
            $booking['dep_airport'] = $flightRow['dep_airport'];
            $booking['dest_airport'] = $flightRow['dest_airport'];
            $booking['dep_date'] = $flightRow['dep_date'];
            $booking['dep_time'] = $flightRow['dep_time'];
            $booking['arr_time'] = $flightRow['arr_time'];
            $booking['duration_min'] = $flightRow['duration_min'];
            $booking['price'] = $flightRow['price'];

            // Retrieve passenger information based on the booking ID and flight ID
            $passengerQuery = "SELECT * FROM passengers WHERE booking_id = $bookingID AND flight_id = " . $flightRow['flight_id'];
            $passengerResult = $conn->query($passengerQuery);

            $passengers = array();
            while ($passengerRow = mysqli_fetch_assoc($passengerResult)) {
                $passenger = array();
                $passenger['passenger_id'] = $passengerRow['passenger_id'];
                $passenger['title'] = $passengerRow['title'];
                $passenger['name'] = $passengerRow['name'];
                $passenger['surname'] = $passengerRow['surname'];
                $passenger['seat'] = $passengerRow['seat'];
                $passengers[] = $passenger;
            }

            $booking['passengers'] = $passengers;
        } else {
            // No flight found
            $booking['flight_id'] = 'N/A';
            $booking['dep_airport'] = 'N/A';
            $booking['dest_airport'] = 'N/A';
            $booking['dep_date'] = 'N/A';
            $booking['dep_time'] = 'N/A';
            $booking['arr_time'] = 'N/A';
            $booking['duration_min'] = 'N/A';
            $booking['price'] = 'N/A';
            $booking['passengers'] = array();
        }

        $bookings[] = $booking;
    }

    return $bookings;
}

    
}


