<?php
// Class for ticket search
class Seats {
    public $booked_seats = array();
    public $free_seats = array();
    public $booked_seats_r = array();
    public $free_seats_r = array();
    public $theseats = 53;

    function find_free_seats($flight_id) {
        require "config.php";

        $registerquery = "SELECT seat FROM passengers WHERE flight_id='$flight_id'";
        $result = $conn->query($registerquery);
        if ($result->num_rows == $this->theseats) {
            echo "No available seats!";
            $conn->close();
        } else {
            while ($row = $result->fetch_assoc()) {
                array_push($this->booked_seats, $row['seat']);
            }
			$bookedSeatsStr = "'" . implode("','", $this->booked_seats) . "'"; // Enclose values in single quotes

			if (!empty($bookedSeatsStr)) {
            $registerquery = "SELECT seat FROM seats WHERE seat NOT IN ($bookedSeatsStr)";
			}
			else{
				$registerquery = "SELECT seat FROM seats";
			}
			//echo "Query: $registerquery";
            $result = $conn->query($registerquery);
            while ($row = $result->fetch_assoc()) {
                array_push($this->free_seats, $row['seat']);
            }
		
            $conn->close();
        }
    }

    function find_free_seats_r($flight_id_r) {
        require "config.php";

        $registerquery = "SELECT seat FROM passengers WHERE flight_id='$flight_id_r'";
        $result = $conn->query($registerquery);
        if ($result->num_rows == $this->theseats) {
            echo "No available seats!";
            $conn->close();
        } else {
            while ($row = $result->fetch_assoc()) {
                array_push($this->booked_seats_r, $row['seat']);
            }
			$bookedSeatsStrR = "'" . implode("','", $this->booked_seats_r) . "'"; // Enclose values in single quotes

			if (!empty($bookedSeatsStr)) {
				$registerquery = "SELECT seat FROM seats WHERE seat NOT IN ($bookedSeatsStrR)";
				}
				else{
					$registerquery = "SELECT seat FROM seats";
				}

			//echo "Query: $registerquery";
            $result = $conn->query($registerquery);
            while ($row = $result->fetch_assoc()) {
                array_push($this->free_seats_r, $row['seat']);
            }

            $conn->close();
        }
    }
}
?>
