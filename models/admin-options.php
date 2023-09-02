<?php
class AdminOptions
{
    // Gets the list of active flights
    public function getFlightList()
    {
        require "config.php";
        $sql = "SELECT flight_id, dep_airport, dest_airport, dep_date, dep_time, arr_time, duration_min, price FROM flights WHERE status = 'active'";
        $result = $conn->query($sql);

        $flightList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $flightList[] = $row;
        }

        return $flightList;
    }
    // Gets the list of completed flights
    public function getCompletedFlightList()
    {
        require "config.php";
        $sql = "SELECT flight_id, dep_airport, dest_airport, dep_date, dep_time, arr_time, duration_min, price FROM flights WHERE status = 'completed'";
        $result = $conn->query($sql);

        $flightList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $flightList[] = $row;
        }

        return $flightList;
    }

    // Adds a new flight with optional repeated flights
    public function addFlight($departureAirport, $destinationAirport, $date, $departureTime, $arrivalTime, $duration, $price, $repeatWeeks)
    {
        require "config.php";

        $sql = "INSERT INTO flights (dep_airport, dest_airport, dep_date, dep_time, arr_time, duration_min, price) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $departureAirport, $destinationAirport, $date, $departureTime, $arrivalTime, $duration, $price);
        $result = $stmt->execute();
        if ($result) {
            echo "Flight added successfully!";
        } else {
            echo "Failed to add the flight. Please try again.";
        }

        $flightID = $stmt->insert_id;

        // Repeats the flight for the specified number of weeks
        for ($week = 1; $week < $repeatWeeks; $week++) {
            $departureDate = date('Y-m-d', strtotime($date . ' + ' . ($week * 7) . ' days'));
            //$arrivalDate = date('Y-m-d', strtotime($departureDate . ' + ' . $duration . ' minutes'));

            $sql = "INSERT INTO flights (dep_airport, dest_airport, dep_date, dep_time, arr_time, duration_min, price) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $departureAirport, $destinationAirport, $departureDate, $departureTime, $arrivalTime, $duration, $price);
            $result = $stmt->execute();
            if (!$result) {
                echo "Failed to add the repeated flight for week $week. Please try again.";
            }
        }
        $stmt->close();
    }

    // Updates flight details based on flight ID
    public function updateFlight($flightID, $departureAirport, $destinationAirport, $date, $departureTime, $arrivalTime, $duration, $price)
    {
        require "config.php";

        // Updates the flight using prepared statements with bind parameters
        $sql = "UPDATE flights SET dep_airport=?, dest_airport=?, dep_date=?, dep_time=?, arr_time=?, duration_min=?, price=? 
                WHERE flight_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $departureAirport, $destinationAirport, $date, $departureTime, $arrivalTime, $duration, $price, $flightID);
        $result = $stmt->execute();

        if ($result) {
            echo "Flight with ID:" . $flightID . " updated successfully!";
        } else {
            echo "Failed to update the flight. Please try again.";
        }

        $stmt->close();
    }

    // A flight becomes cancelled
    public static function moveCancelledFlights($flightID)
    {
        require "config.php";

        require "config.php";
        $sql = "SELECT * FROM flights WHERE flight_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $flightID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Updates status of the flight to 'completed'
                $update_flights_query = "UPDATE flights SET status = 'cancelled' WHERE flight_id = ?";
                $stmt = $conn->prepare($update_flights_query);
                $stmt->bind_param("i", $row['flight_id']);
                $stmt->execute();

                // Updates status of the passengers to 'completed'
                $update_passengers_query = "UPDATE passengers SET status = 'cancelled' WHERE flight_id = ?";
                $stmt = $conn->prepare($update_passengers_query);
                $stmt->bind_param("i", $row['flight_id']);
                $stmt->execute();

                return true;
            }
        } else {
            return false;
        }
    }



    // Gets the list of passengers for a specific flight
    public function getPassengersList($flightID)
    {
        require "config.php";
        $sql = "SELECT * FROM passengers WHERE flight_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $flightID);
        $stmt->execute();
        $result = $stmt->get_result();

        $passengersList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $passengersList[] = $row;
        }

        return $passengersList;
    }

    // Function to fetch passenger document info based on the passengerID
    public function getPassengerDocumentInfo($passengerID)
    {
        require "config.php";

        //$passengerID = mysqli_real_escape_string($conn, $passengerID);

        $sql = "SELECT * FROM passenger_info WHERE passenger_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $passengerID);
        $stmt->execute();
        $result = $stmt->get_result();

        $passengerDocumentInfo = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $passengerDocumentInfo[] = $row;
        }

        return $passengerDocumentInfo;
    }

    // Gets the list of cancelled flights
    public function getCancelledFlightsList()
    {
        require "config.php";
        $sql = "SELECT flight_id, dep_airport, dest_airport, dep_date, dep_time, arr_time, duration_min, price FROM flights WHERE status='cancelled';";
        $result = $conn->query($sql);

        $flightList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $flightList[] = $row;
        }

        return $flightList;
    }


    // Adds a new airport if it doesn't already exist
    public function addAirport($airportID, $airportCity, $airportName, $airportCountry)
    {
        require "config.php";

        $sql = "SELECT * FROM airports WHERE airport_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $airportID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Airport already exists.";
            $stmt->close();
            $conn->close();
        } else {

            $sql = "INSERT INTO airports (airport_ID, airport_city, airport_name, country) 
        VALUES (?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param("ssss", $airportID, $airportCity, $airportName, $airportCountry);


            $result = $stmt->execute();

            if ($result) {
                echo "Airport added successfully!";
            } else {
                echo "Failed to add the airport. Please try again.";
            }


            $stmt->close();
        }
    }

    // Checks if an airport is used in any existing flights
    public function checkAirportInFlights($airportID)
    {
        require "config.php";

        $sql = "SELECT * FROM flights WHERE dep_airport = ? OR dest_airport = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $airportID, $airportID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Returns true if the airport is in flights table
            return true;
        } else {
            return false;
        }
    }


    // Gets the list of users
    public function getUserList()
    {
        require "config.php";
        $sql = "SELECT username, surname, type FROM user";
        $result = $conn->query($sql);

        $userList = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $userList[] = $row;
        }

        return $userList;
    }

    // Gets the list of bookings for a user
    public function getAccountBookings($username)
    {
        require "config.php";

        $bookingQuery = "SELECT * FROM bookings WHERE username=?";
        $stmtBooking = $conn->prepare($bookingQuery);
        $stmtBooking->bind_param("s", $username);
        $stmtBooking->execute();
        $bookingResult = $stmtBooking->get_result();

        $bookings = array();

        while ($bookingRow = mysqli_fetch_assoc($bookingResult)) {
            $bookingID = $bookingRow['booking_id'];

            // Retrieves 'go' flights based on booking ID
            $flightQueryGo = "SELECT * FROM flights 
                            WHERE flight_id IN (
                                SELECT flight_id FROM passengers WHERE booking_id=? AND trip_type='go'
                            )";
            $stmtFlightGo = $conn->prepare($flightQueryGo);
            $stmtFlightGo->bind_param("i", $bookingID);
            $stmtFlightGo->execute();
            $flightResultGo = $stmtFlightGo->get_result();


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
                $booking['status'] = $flightRowGo['status'];

                // Retrieves passenger information for 'go' flight
                $passengerQueryGo = "SELECT * FROM passengers 
                                    WHERE booking_id=? 
                                    AND flight_id=?
                                    AND trip_type='go'";
                $stmtPassengerGo = $conn->prepare($passengerQueryGo);
                $stmtPassengerGo->bind_param("ii", $bookingID, $flightRowGo['flight_id']);
                $stmtPassengerGo->execute();
                $passengerResultGo = $stmtPassengerGo->get_result();

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
                $booking['isReturn'] = false;
                $bookings[] = $booking;
            }

            // Retrieves 'return' flights based on booking ID
            $flightQueryReturn = "SELECT * FROM flights 
                                WHERE flight_id IN (
                                    SELECT flight_id FROM passengers WHERE booking_id=? AND trip_type='return'
                                )";
            $stmtFlightReturn = $conn->prepare($flightQueryReturn);
            $stmtFlightReturn->bind_param("i", $bookingID);
            $stmtFlightReturn->execute();
            $flightResultReturn = $stmtFlightReturn->get_result();

            // If there are any 'return' flights
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
                    $booking['statusR'] = $flightRowReturn['status'];


                    $booking['passengersR'] = array();
                    $booking['isReturn'] = true;
                    $bookings[] = $booking;
                }
            } else {
                $booking['isReturn'] = false;
            }
        }

        return $bookings;
    }
}
