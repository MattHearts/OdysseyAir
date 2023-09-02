<?php
//class for ticket search
class Search
{
    public $depAirport;
    public $destAirport;
    public $depDate;
    public $retDate;
    public $searchDepAirport;
    public $searchDestAirport;
    public $searchDepDate;
    public $searchRetDate;
    public $depTime;
    public $passengerNum;
    public $whosGoing;
    public $searchErr = "";
    public $arrTime;
    public $flightID;
    public $pricePerPerson;
    public $durationMin;


    public $depDateMinus3;
    public $pricePerPersonMinus3;
    public $depDateMinus2;
    public $pricePerPersonMinus2;
    public $depDateMinus1;
    public $pricePerPersonMinus1;
    public $depDatePlus1;
    public $pricePerPersonPlus1;
    public $depDatePlus2;
    public $pricePerPersonPlus2;
    public $depDatePlus3;
    public $pricePerPersonPlus3;
    public $isFlight;
    public $pricePerPersonNum;

    public $depAirportR;
    public $destAirportR;
    public $depDateR;
    public $retDateR;
    public $searchDepAirportR;
    public $searchDestAirportR;
    public $searchDepDateR;
    public $searchRetDateR;
    public $depTimeR;
    public $arrTimeR;
    public $flightIDR;
    public $pricePerPersonR;
    public $durationMinR;
    public $depDateMinus3R;
    public $pricePerPersonMinus3R;
    public $depDateMinus2R;
    public $pricePerPersonMinus2R;
    public $depDateMinus1R;
    public $pricePerPersonMinus1R;
    public $depDatePlus1R;
    public $pricePerPersonPlus1R;
    public $depDatePlus2R;
    public $pricePerPersonPlus2R;
    public $depDatePlus3R;
    public $pricePerPersonPlus3R;
    public $isFlightR;
    public $pricePerPersonNumR;

    public $depTimeMinus3;
    public $depTimeMinus2;
    public $depTimeMinus1;
    public $depTimePlus1;
    public $depTimePlus2;
    public $depTimePlus3;

    public $depTimeMinus3R;
    public $depTimeMinus2R;
    public $depTimeMinus1R;
    public $depTimePlus1R;
    public $depTimePlus2R;
    public $depTimePlus3R;

    public $theseats = 53;
    public $booked_seats = array();



    // Validates the search form data
    function validate_search()
    {
        if (empty($this->searchDepAirport) || empty($this->searchDestAirport) || empty($this->searchDepDate)) {
            $this->searchErr = "All fields are required";
        } else if ($this->searchDepAirport == $this->searchDestAirport) {
            $this->searchErr = "Cannot do that smartass";
        } else {
            $this->search_flights();
        }
    }


    // Performs a search of the flights based on the form the user submitted
    function search_flights()
    {


        $_SESSION['whosGoing'] = $this->whosGoing;
        $_SESSION['searchDepAirport'] = $this->searchDepAirport;
        $_SESSION['searchDestAirport'] = $this->searchDestAirport;
        $_SESSION['searchDepDate'] = $this->searchDepDate;

        require "config.php";
        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirport, $this->searchDestAirport, $this->searchDepDate);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depAirport = $row['dep_airport'];
            $this->destAirport = $row['dest_airport'];
            $this->depDate = $row['dep_date'];
            $this->flightID = $row['flight_id'];
            $this->pricePerPerson = $row['price'];
            $this->durationMin = $row['duration_min'];

            $search_query2 = "SELECT TIME_FORMAT(`dep_time`, '%H:%i') AS `dep_open_time` , TIME_FORMAT(`arr_time`, '%H:%i') AS `arr_open_time` FROM flights WHERE flight_id=?";
            $stmt = $conn->prepare($search_query2);
            $stmt->bind_param("i", $this->flightID);
            $stmt->execute();
            $result2 = $stmt->get_result();

            $row2 = $result2->fetch_assoc();
            $this->depTime = $row2['dep_open_time'];
            $this->arrTime = $row2['arr_open_time'];

            if ($this->areSeatsEnough($this->flightID) >= $this->whosGoing) {

                $_SESSION['depAirport'] = $this->depAirport;
                $_SESSION['destAirport'] = $this->destAirport;
                $_SESSION['depDate'] = $this->depDate;
                $_SESSION['depTime'] = $this->depTime;
                $_SESSION['arrTime'] = $this->arrTime;
                $_SESSION['durationMin'] = $this->durationMin;
                $_SESSION['pricePerPerson'] = $this->pricePerPerson;
                $_SESSION['flightID'] = $this->flightID;
            } else {
                $this->depAirport = "-";
                $this->destAirport = "-";
                $this->depDate = "-";
                $this->flightID = "-";
                $this->pricePerPerson = "-";
                $this->durationMin = "-";
                $this->depTime = "-";
                $this->arrTime = "-";

                $_SESSION['depAirport'] = $this->depAirport;
                $_SESSION['destAirport'] = $this->destAirport;
                $_SESSION['depDate'] = $this->depDate;
                $_SESSION['depTime'] = $this->depTime;
                $_SESSION['arrTime'] = $this->arrTime;
                $_SESSION['durationMin'] = $this->durationMin;
                $_SESSION['pricePerPerson'] = $this->pricePerPerson;
                $_SESSION['flightID'] = $this->flightID;
            }
        } else {
            $this->depAirport = "-";
            $this->destAirport = "-";
            $this->depDate = "-";
            $this->flightID = "-";
            $this->pricePerPerson = "-";
            $this->durationMin = "-";
            $this->depTime = "-";
            $this->arrTime = "-";

            $_SESSION['depAirport'] = $this->depAirport;
            $_SESSION['destAirport'] = $this->destAirport;
            $_SESSION['depDate'] = $this->depDate;
            $_SESSION['depTime'] = $this->depTime;
            $_SESSION['arrTime'] = $this->arrTime;
            $_SESSION['durationMin'] = $this->durationMin;
            $_SESSION['pricePerPerson'] = $this->pricePerPerson;
            $_SESSION['flightID'] = $this->flightID;



            $_SESSION['errMessage'] = "Sorry, no available flights this day :(";
        }
        $this->search_close_flights();
    }

    // Performs a search of the flights close to that date
    function search_close_flights()
    {
        require "config.php";
        $search_query = "select '$this->searchDepDate'-interval 3 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDateMinus3 = $row['date'];
            $_SESSION['depDateMinus3'] = $this->depDateMinus3;
        } else {
            $_SESSION['depDateMinus3'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirport, $this->searchDestAirport, $this->depDateMinus3);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {


                $this->pricePerPersonMinus3 = $row['price'];
            } else {

                $this->pricePerPersonMinus3 = "-";
            }
        } else {

            $this->pricePerPersonMinus3 = "-";
        }
        $_SESSION['pricePerPersonMinus3'] = $this->pricePerPersonMinus3;


        require "config.php";
        $search_query = "select '$this->searchDepDate'-interval 2 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDateMinus2 = $row['date'];
            $_SESSION['depDateMinus2'] = $this->depDateMinus2;
        } else {
            $_SESSION['depDateMinus2'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirport, $this->searchDestAirport, $this->depDateMinus2);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {


                $this->pricePerPersonMinus2 = $row['price'];
            } else {

                $this->pricePerPersonMinus2 = "-";
            }
        } else {

            $this->pricePerPersonMinus2 = "-";
        }
        $_SESSION['pricePerPersonMinus2'] = $this->pricePerPersonMinus2;


        require "config.php";
        $search_query = "select '$this->searchDepDate'-interval 1 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDateMinus1 = $row['date'];
            $_SESSION['depDateMinus1'] = $this->depDateMinus1;
        } else {
            $_SESSION['depDateMinus1'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirport, $this->searchDestAirport, $this->depDateMinus1);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {

                $this->pricePerPersonMinus1 = $row['price'];
            } else {

                $this->pricePerPersonMinus1 = "-";
            }
        } else {

            $this->pricePerPersonMinus1 = "-";
        }
        $_SESSION['pricePerPersonMinus1'] = $this->pricePerPersonMinus1;


        require "config.php";
        $search_query = "select '$this->searchDepDate'+interval 1 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDatePlus1 = $row['date'];
            $_SESSION['depDatePlus1'] = $this->depDatePlus1;
        } else {
            $_SESSION['depDatePlus1'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirport, $this->searchDestAirport, $this->depDatePlus1);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {

                $this->pricePerPersonPlus1 = $row['price'];
            } else {

                $this->pricePerPersonPlus1 = "-";
            }
        } else {

            $this->pricePerPersonPlus1 = "-";
        }
        $_SESSION['pricePerPersonPlus1'] = $this->pricePerPersonPlus1;


        require "config.php";
        $search_query = "select '$this->searchDepDate'+interval 2 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDatePlus2 = $row['date'];
            $_SESSION['depDatePlus2'] = $this->depDatePlus2;
        } else {
            $_SESSION['depDatePlus2'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirport, $this->searchDestAirport, $this->depDatePlus2);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {
                $this->pricePerPersonPlus2 = $row['price'];
            } else {

                $this->pricePerPersonPlus2 = "-";
            }
        } else {

            $this->pricePerPersonPlus2 = "-";
        }
        $_SESSION['pricePerPersonPlus2'] = $this->pricePerPersonPlus2;


        require "config.php";
        $search_query = "select '$this->searchDepDate'+interval 3 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDatePlus3 = $row['date'];
            $_SESSION['depDatePlus3'] = $this->depDatePlus3;
        } else {
            $_SESSION['depDatePlus3'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirport, $this->searchDestAirport, $this->depDatePlus3);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {
                $this->pricePerPersonPlus3 = $row['price'];
            } else {

                $this->pricePerPersonPlus3 = "-";
            }
        } else {

            $this->pricePerPersonPlus3 = "-";
        }
        $_SESSION['pricePerPersonPlus3'] = $this->pricePerPersonPlus3;
    }
    // Validates the return flight search
    function validate_return_search()
    {
        if (empty($this->searchDepDateR)) {
            $this->searchErr = "All fields are required";
        } else {



            $this->search_flights_return();
        }
    }
    // Performs a search for return flights
    function search_flights_return()
    {
        $this->searchDestAirportR = $this->searchDepAirport;
        $this->searchDepAirportR = $this->searchDestAirport;
        $_SESSION['searchDepAirportR'] = $this->searchDepAirportR;
        $_SESSION['searchDestAirportR'] = $this->searchDestAirportR;
        $_SESSION['searchDepDateR'] = $this->searchDepDateR;


        require "config.php";
        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active'";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirportR, $this->searchDestAirportR, $this->searchDepDateR);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depAirportR = $row['dep_airport'];
            $this->destAirportR = $row['dest_airport'];
            $this->depDateR = $row['dep_date'];
            $this->flightIDR = $row['flight_id'];
            $this->pricePerPersonR = $row['price'];
            $this->durationMinR = $row['duration_min'];

            $search_query2 = "SELECT TIME_FORMAT(`dep_time`, '%H:%i') AS `dep_open_time` , TIME_FORMAT(`arr_time`, '%H:%i') AS `arr_open_time` FROM flights WHERE flight_id=?";
            $stmt = $conn->prepare($search_query2);
            $stmt->bind_param("i", $this->flightIDR);
            $stmt->execute();
            $result2 = $stmt->get_result();
            $row2 = $result2->fetch_assoc();
            $this->depTimeR = $row2['dep_open_time'];
            $this->arrTimeR = $row2['arr_open_time'];


            if ($this->areSeatsEnough($this->flightIDR) >= $this->whosGoing) {

                $_SESSION['depAirportR'] = $this->depAirportR;
                $_SESSION['destAirportR'] = $this->destAirportR;
                $_SESSION['depDateR'] = $this->depDateR;
                $_SESSION['depTimeR'] = $this->depTimeR;
                $_SESSION['arrTimeR'] = $this->arrTimeR;
                $_SESSION['durationMinR'] = $this->durationMinR;
                $_SESSION['pricePerPersonR'] = $this->pricePerPersonR;
                $_SESSION['flightIDR'] = $this->flightIDR;
            } else {
                $this->depAirportR = "-";
                $this->destAirportR = "-";
                $this->depDateR = "-";
                $this->flightIDR = "-";
                $this->pricePerPersonR = "-";
                $this->durationMinR = "-";
                $this->depTimeR = "-";
                $this->arrTimeR = "-";

                $_SESSION['depAirportR'] = $this->depAirportR;
                $_SESSION['destAirportR'] = $this->destAirportR;
                $_SESSION['depDateR'] = $this->depDateR;
                $_SESSION['depTimeR'] = $this->depTimeR;
                $_SESSION['arrTimeR'] = $this->arrTimeR;
                $_SESSION['durationMinR'] = $this->durationMinR;
                $_SESSION['pricePerPersonR'] = $this->pricePerPersonR;
                $_SESSION['flightIDR'] = $this->flightIDR;
            }
        } else {
            $this->depAirportR = "-";
            $this->destAirportR = "-";
            $this->depDateR = "-";
            $this->flightIDR = "-";
            $this->pricePerPersonR = "-";
            $this->durationMinR = "-";
            $this->depTimeR = "-";
            $this->arrTimeR = "-";

            $_SESSION['depAirportR'] = $this->depAirportR;
            $_SESSION['destAirportR'] = $this->destAirportR;
            $_SESSION['depDateR'] = $this->depDateR;
            $_SESSION['depTimeR'] = $this->depTimeR;
            $_SESSION['arrTimeR'] = $this->arrTimeR;
            $_SESSION['durationMinR'] = $this->durationMinR;
            $_SESSION['pricePerPersonR'] = $this->pricePerPersonR;
            $_SESSION['flightIDR'] = $this->flightIDR;



            $_SESSION['errMessage'] = "Sorry, no available flights this day :(";
        }
        $this->search_close_flights_return();
    }

    //Performs a search of the flights close to the return date
    function search_close_flights_return()
    {
        require "config.php";
        $search_query = "select '$this->searchDepDateR'-interval 3 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDateMinus3R = $row['date'];
            $_SESSION['depDateMinus3R'] = $this->depDateMinus3R;
        } else {
            $_SESSION['depDateMinus3R'] = "";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirportR, $this->searchDestAirportR, $this->depDateMinus3R);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {
                $this->pricePerPersonMinus3R = $row['price'];
            } else {

                $this->pricePerPersonMinus3R = "-";
            }
        } else {

            $this->pricePerPersonMinus3R = "-";
        }
        $_SESSION['pricePerPersonMinus3R'] = $this->pricePerPersonMinus3R;



        require "config.php";
        $search_query = "select '$this->searchDepDateR'-interval 2 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDateMinus2R = $row['date'];
            $_SESSION['depDateMinus2R'] = $this->depDateMinus2R;
        } else {
            $_SESSION['depDateMinus2R'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirportR, $this->searchDestAirportR, $this->depDateMinus2R);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {
                $this->pricePerPersonMinus2R = $row['price'];
            } else {

                $this->pricePerPersonMinus2R = "-";
            }
        } else {

            $this->pricePerPersonMinus2R = "-";
        }
        $_SESSION['pricePerPersonMinus2R'] = $this->pricePerPersonMinus2R;




        require "config.php";
        $search_query = "select '$this->searchDepDateR'-interval 1 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDateMinus1R = $row['date'];
            $_SESSION['depDateMinus1R'] = $this->depDateMinus1R;
        } else {
            $_SESSION['depDateMinus1R'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirportR, $this->searchDestAirportR, $this->depDateMinus1R);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {

                $this->pricePerPersonMinus1R = $row['price'];
            } else {

                $this->pricePerPersonMinus1R = "-";
            }
        } else {

            $this->pricePerPersonMinus1R = "-";
        }
        $_SESSION['pricePerPersonMinus1R'] = $this->pricePerPersonMinus1R;



        require "config.php";
        $search_query = "select '$this->searchDepDateR'+interval 1 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDatePlus1R = $row['date'];
            $_SESSION['depDatePlus1R'] = $this->depDatePlus1R;
        } else {
            $_SESSION['depDatePlus1R'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirportR, $this->searchDestAirportR, $this->depDatePlus1R);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {
                $this->pricePerPersonPlus1R = $row['price'];
            } else {

                $this->pricePerPersonPlus1R = "-";
            }
        } else {

            $this->pricePerPersonPlus1R = "-";
        }
        $_SESSION['pricePerPersonPlus1R'] = $this->pricePerPersonPlus1R;


        require "config.php";
        $search_query = "select '$this->searchDepDateR'+interval 2 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDatePlus2R = $row['date'];
            $_SESSION['depDatePlus2R'] = $this->depDatePlus2R;
        } else {
            $_SESSION['depDatePlus2R'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirportR, $this->searchDestAirportR, $this->depDatePlus2R);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {
                $this->pricePerPersonPlus2R = $row['price'];
            } else {

                $this->pricePerPersonPlus2R = "-";
            }
        } else {

            $this->pricePerPersonPlus2R = "-";
        }
        $_SESSION['pricePerPersonPlus2R'] = $this->pricePerPersonPlus2R;

        require "config.php";
        $search_query = "select '$this->searchDepDateR'+interval 3 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDatePlus3R = $row['date'];
            $_SESSION['depDatePlus3R'] = $this->depDatePlus3R;
        } else {
            $_SESSION['depDatePlus3R'] = "ha";
        }

        $search_query = "SELECT * FROM  flights WHERE dep_airport=? AND dest_airport=? AND dep_date=? AND status='active';";
        $stmt = $conn->prepare($search_query);
        $stmt->bind_param("sss", $this->searchDepAirportR, $this->searchDestAirportR, $this->depDatePlus3R);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $flightIDtmp = $row['flight_id'];
            if ($this->areSeatsEnough($flightIDtmp) >= $this->whosGoing) {
                $this->pricePerPersonPlus3R = $row['price'];
            } else {

                $this->pricePerPersonPlus3R = "-";
            }
        } else {

            $this->pricePerPersonPlus3R = "-";
        }
        $_SESSION['pricePerPersonPlus3R'] = $this->pricePerPersonPlus3R;
    }

    // Method that checks if there are enough seats for booking
    function areSeatsEnough($flight_id)
    {
        require "config.php";
        $registerquery = "SELECT seat FROM passengers WHERE flight_id=?";
        $stmt = $conn->prepare($registerquery);
        $stmt->bind_param("i", $flight_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $bookedSeats = array();

        while ($row = $result->fetch_assoc()) {
            array_push($bookedSeats, $row['seat']);
        }
        if (count($bookedSeats) == $this->theseats) {
            $conn->close();
            return 0; 
        } else {
            $bookedSeatsStr = "'" . implode("','", $this->booked_seats) . "'";

            if (!empty($bookedSeatsStr)) {
                $registerquery = "SELECT COUNT(seat) AS free_seats FROM seats WHERE seat NOT IN ($bookedSeatsStr)";
            } else {
                $registerquery = "SELECT COUNT(seat) AS free_seats FROM seats";
            }

            $result = $conn->query($registerquery);
            $row = $result->fetch_assoc();

            $freeSeatsCount = $row['free_seats'];
            $conn->close();
            return $freeSeatsCount;
        }
    }
}
