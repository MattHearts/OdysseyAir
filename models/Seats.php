<?php
class Seats
{
    public $booked_seats = array();
    public $free_seats = array();
    public $booked_seats_r = array();
    public $free_seats_r = array();
    public $theseats = 53;


    // Finds which seats are free if any
    function find_free_seats($flight_id)
    {
        require "config.php";

        $registerquery = "SELECT seat FROM passengers WHERE flight_id=?";
        $stmt = $conn->prepare($registerquery);
        $stmt->bind_param("i", $flight_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == $this->theseats) {
            echo "No available seats!";
            $conn->close();
        } else {
            while ($row = $result->fetch_assoc()) {
                array_push($this->booked_seats, $row['seat']);
            }
            $bookedSeatsStr = "'" . implode("','", $this->booked_seats) . "'";

            if (!empty($bookedSeatsStr)) {
                $registerquery = "SELECT seat FROM seats WHERE seat NOT IN ($bookedSeatsStr)";
            } else {
                $registerquery = "SELECT seat FROM seats";
            }

            $result = $conn->query($registerquery);
            while ($row = $result->fetch_assoc()) {
                array_push($this->free_seats, $row['seat']);
            }

            $conn->close();
        }
    }

    // Finds which seats are free if any for return flight
    function find_free_seats_r($flight_id_r)
    {
        require "config.php";

        $registerquery = "SELECT seat FROM passengers WHERE flight_id=?";
        $stmt = $conn->prepare($registerquery);
        $stmt->bind_param("i", $flight_id_r);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == $this->theseats) {
            echo "No available seats!";
            $conn->close();
        } else {
            while ($row = $result->fetch_assoc()) {
                array_push($this->booked_seats_r, $row['seat']);
            }
            $bookedSeatsStrR = "'" . implode("','", $this->booked_seats_r) . "'";

            if (!empty($bookedSeatsStr)) {
                $registerquery = "SELECT seat FROM seats WHERE seat NOT IN ($bookedSeatsStrR)";
            } else {
                $registerquery = "SELECT seat FROM seats";
            }

            $result = $conn->query($registerquery);
            while ($row = $result->fetch_assoc()) {
                array_push($this->free_seats_r, $row['seat']);
            }

            $conn->close();
        }
    }
}
