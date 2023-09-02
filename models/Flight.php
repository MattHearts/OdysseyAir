<?php

class Flight {
    public static function moveCompletedFlights() {
        require "config.php";

        // Selects flights that have already departed
        $query = "SELECT * FROM flights WHERE CONCAT(dep_date, ' ', dep_time) < NOW()";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Updates status of the flight to 'completed'
                $update_flights_query = "UPDATE flights SET status = 'completed' WHERE flight_id = ?";
                $stmt = $conn->prepare($update_flights_query);
                $stmt->bind_param("i", $row['flight_id']);
                $stmt->execute();

                // Updates status of the passengers to 'completed'
                $update_passengers_query = "UPDATE passengers SET status = 'completed' WHERE flight_id = ?";
                $stmt = $conn->prepare($update_passengers_query);
                $stmt->bind_param("i", $row['flight_id']);
                $stmt->execute();
            }
        }
    }
}
?>
