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


    
    // Add other methods for managing flights, such as updating flight details, etc.
}
