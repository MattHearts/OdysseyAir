<?php
//class for ticket search
class Seats{

    public $booked_seats=array();
    public $free_seats=array();
public $theseats=53;
public $flight_id;

function find_free_seats()
{
	require "config.php";

	
	$registerquery = "SELECT seat  FROM passengers where  flight_id='$this->flight_id'";
	$result = $conn->query( $registerquery);
	if ($result->num_rows == $this->theseats) {
		echo "No  available seats! ";
		$conn->close();
	
	}
	else
	{
        
		
		while($row = $result->fetch_assoc()) {
			array_push($this->booked_seats,$row['seat']); 
            
			//echo "id: " . $row["showid"]. " - Name: " . $row["showtime"].  "<br>";
		}

        $registerquery = "SELECT seat  FROM seats";
        $result = $conn->query( $registerquery);
		for($i=1; $i<=$this->theseats; $i++)
		{
                
				if (!in_array($i, $this->booked_seats))
                $row = $result->fetch_assoc();
				array_push($this->free_seats,$row['seat']);
					//var_dump($this->free_seats);
                    //echo $this->free_seats[$i];
                    
		}

	$conn->close();
	}
}
}