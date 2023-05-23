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
    
    
    

    public function removeFlight($flightID) {
        // Assuming you have the necessary logic to remove a flight from the database
        // Implement the code here to delete the flight with the specified ID from the database
        // Example: DELETE FROM flights WHERE ID = $flightID
    }

    // Add other methods for managing flights, such as updating flight details, etc.
}
