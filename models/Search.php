<?php
//class for ticket search
class Search{
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
    public $searchErr="";
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

    function validate_search()
    {
        if (empty($this->searchDepAirport) || empty($this->searchDestAirport) || empty($this->searchDepDate)) {
            $this->searchErr = "All fields are required";
        } else {
            $this->search_flights();
        }
    }
    function search_flights()
    {

                    
    $_SESSION['whosGoing'] = $this->whosGoing;
    $_SESSION['searchDepAirport'] = $this->searchDepAirport;
    $_SESSION['searchDestAirport'] = $this->searchDestAirport;
    $_SESSION['searchDepDate'] = $this->searchDepDate;

            require "config.php";
            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirport' AND dest_airport='$this->searchDestAirport' AND dep_date='$this->searchDepDate'";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depAirport = $row['dep_airport'];
                $this->destAirport = $row['dest_airport'];
                $this->depDate = $row['dep_date'];
                $this->flightID = $row['flight_id'];
                $this->pricePerPerson = $row['price'];
                $this->durationMin =$row['duration_min'];

                $search_query2 = "SELECT TIME_FORMAT(`dep_time`, '%H:%i') AS `dep_open_time` , TIME_FORMAT(`arr_time`, '%H:%i') AS `arr_open_time` FROM flights WHERE flight_id='$this->flightID'";
                $result2 = $conn->query($search_query2);
                $row2 = $result2->fetch_assoc();
                $this->depTime = $row2['dep_open_time'];
                $this->arrTime = $row2['arr_open_time'];


                $_SESSION['depAirport'] = $this->depAirport;
                $_SESSION['destAirport'] = $this->destAirport;
                $_SESSION['depDate'] = $this->depDate;
                $_SESSION['depTime'] = $this->depTime;
                $_SESSION['arrTime'] = $this->arrTime;
                $_SESSION['durationMin'] = $this->durationMin;
                $_SESSION['pricePerPerson'] = $this->pricePerPerson;
                $_SESSION['flightID'] = $this->flightID;
                $this->search_close_flights();
               

            } else {
                $this->depAirport = "-";
                $this->destAirport = "-";
                $this->depDate = "-";
                $this->flightID = "-";
                $this->pricePerPerson = "-";
                $this->durationMin ="-";
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
                
                
                $this->search_close_flights();
                //echo "<script>window.location.href='../controllers/search-results.php'</script>";
                $_SESSION['errMessage'] = "Sorry, no available flights this day :(";
            }


        
    }

    function search_close_flights()
    {
        require "config.php";
        $search_query = "select '$this->searchDepDate'-interval 3 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDateMinus3 = $row['date'];
            $_SESSION['depDateMinus3'] = $this->depDateMinus3;
        }
        else{$_SESSION['depDateMinus3'] ="ha";}

        $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirport' AND dest_airport='$this->searchDestAirport' AND dep_date='$this->depDateMinus3';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->pricePerPersonMinus3 = $row['price'];
            $_SESSION['pricePerPersonMinus3'] = $this->pricePerPersonMinus3;
        }
        else
        {
            $_SESSION['pricePerPersonMinus3'] = "-";
        }


            require "config.php";
            $search_query = "select '$this->searchDepDate'-interval 2 day AS 'date';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depDateMinus2 = $row['date'];
                $_SESSION['depDateMinus2'] = $this->depDateMinus2;
            }
            else{$_SESSION['depDateMinus2'] ="ha";}

            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirport' AND dest_airport='$this->searchDestAirport' AND dep_date='$this->depDateMinus2';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->pricePerPersonMinus2 = $row['price'];
                $_SESSION['pricePerPersonMinus2'] = $this->pricePerPersonMinus2;
            }
            else
            {
                $_SESSION['pricePerPersonMinus2'] = "-";
            }


            require "config.php";
            $search_query = "select '$this->searchDepDate'-interval 1 day AS 'date';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depDateMinus1 = $row['date'];
                $_SESSION['depDateMinus1'] = $this->depDateMinus1;
            }
            else{$_SESSION['depDateMinus1'] ="ha";}

            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirport' AND dest_airport='$this->searchDestAirport' AND dep_date='$this->depDateMinus1';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->pricePerPersonMinus1 = $row['price'];
                $_SESSION['pricePerPersonMinus1'] = $this->pricePerPersonMinus1;
            }
            else
            {
                $_SESSION['pricePerPersonMinus1'] = "-";
            }


            require "config.php";
            $search_query = "select '$this->searchDepDate'+interval 1 day AS 'date';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depDatePlus1 = $row['date'];
                $_SESSION['depDatePlus1'] = $this->depDatePlus1;
            }
            else{$_SESSION['depDatePlus1'] ="ha";}

            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirport' AND dest_airport='$this->searchDestAirport' AND dep_date='$this->depDatePlus1';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->pricePerPersonPlus1 = $row['price'];
                $_SESSION['pricePerPersonPlus1'] = $this->pricePerPersonPlus1;
            }
            else
            {
                $_SESSION['pricePerPersonPlus1'] = "-";
            }


            require "config.php";
            $search_query = "select '$this->searchDepDate'+interval 3 day AS 'date';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depDatePlus3 = $row['date'];
                $_SESSION['depDatePlus3'] = $this->depDatePlus3;
            }
            else{$_SESSION['depDatePlus3'] ="ha";}

            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirport' AND dest_airport='$this->searchDestAirport' AND dep_date='$this->depDatePlus3';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->pricePerPersonPlus3 = $row['price'];
                $_SESSION['pricePerPersonPlus3'] = $this->pricePerPersonPlus3;
            }
            else
            {
                $_SESSION['pricePerPersonPlus3'] = "-";
            }

            require "config.php";
            $search_query = "select '$this->searchDepDate'+interval 2 day AS 'date';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depDatePlus2 = $row['date'];
                $_SESSION['depDatePlus2'] = $this->depDatePlus2;
            }
            else{$_SESSION['depDatePlus2'] ="ha";}

            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirport' AND dest_airport='$this->searchDestAirport' AND dep_date='$this->depDatePlus2';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->pricePerPersonPlus2 = $row['price'];
                $_SESSION['pricePerPersonPlus2'] = $this->pricePerPersonPlus2;
            }
            else
            {
                $_SESSION['pricePerPersonPlus2'] = "-";
            }
    }

    function validate_return_search(){
    if (empty($this->searchDepDateR)) {
        $this->searchErr = "All fields are required";

        
    }
    else{
        


$this->search_flights_return();
}
}
    function search_flights_return()
    {
        $this->searchDestAirportR = $this->searchDepAirport;
        $this->searchDepAirportR = $this->searchDestAirport;
        $_SESSION['searchDepAirportR'] = $this->searchDepAirportR;
        $_SESSION['searchDestAirportR'] = $this->searchDestAirportR;
        $_SESSION['searchDepDateR'] = $this->searchDepDateR;


            require "config.php";
            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirportR' AND dest_airport='$this->searchDestAirportR' AND dep_date='$this->searchDepDateR'";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depAirportR = $row['dep_airport'];
                $this->destAirportR = $row['dest_airport'];
                $this->depDateR = $row['dep_date'];
                $this->flightIDR = $row['flight_id'];
                $this->pricePerPersonR = $row['price'];
                $this->durationMinR =$row['duration_min'];

                $search_query2 = "SELECT TIME_FORMAT(`dep_time`, '%H:%i') AS `dep_open_time` , TIME_FORMAT(`arr_time`, '%H:%i') AS `arr_open_time` FROM flights WHERE flight_id='$this->flightIDR'";
                $result2 = $conn->query($search_query2);
                $row2 = $result2->fetch_assoc();
                $this->depTimeR = $row2['dep_open_time'];
                $this->arrTimeR = $row2['arr_open_time'];


                $_SESSION['depAirportR'] = $this->depAirportR;
                $_SESSION['destAirportR'] = $this->destAirportR;
                $_SESSION['depDateR'] = $this->depDateR;
                $_SESSION['depTimeR'] = $this->depTimeR;
                $_SESSION['arrTimeR'] = $this->arrTimeR;
                $_SESSION['durationMinR'] = $this->durationMinR;
                $_SESSION['pricePerPersonR'] = $this->pricePerPersonR;
                $_SESSION['flightIDR'] = $this->flightIDR;
                $this->search_close_flights_return();
                

            } else {
                $this->depAirportR = "-";
                $this->destAirportR = "-";
                $this->depDateR = "-";
                $this->flightIDR = "-";
                $this->pricePerPersonR = "-";
                $this->durationMinR ="-";
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
                
                
                $this->search_close_flights_return();
                $_SESSION['errMessage'] = "Sorry, no available flights this day :(";
            }

        
        
    }

    function search_close_flights_return()
    {
        require "config.php";
        $search_query = "select '$this->searchDepDateR'-interval 3 day AS 'date';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->depDateMinus3R = $row['date'];
            $_SESSION['depDateMinus3R'] = $this->depDateMinus3R;
        }
        else{$_SESSION['depDateMinus3R'] ="ha";}

        $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirportR' AND dest_airport='$this->searchDestAirportR' AND dep_date='$this->depDateMinus3R';";
        $result = $conn->query($search_query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $this->pricePerPersonMinus3R = $row['price'];
            $_SESSION['pricePerPersonMinus3R'] = $this->pricePerPersonMinus3R;
        }
        else
        {
            $_SESSION['pricePerPersonMinus3R'] = "-";
        }


            require "config.php";
            $search_query = "select '$this->searchDepDateR'-interval 2 day AS 'date';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depDateMinus2R = $row['date'];
                $_SESSION['depDateMinus2R'] = $this->depDateMinus2R;
            }
            else{$_SESSION['depDateMinus2'] ="ha";}

            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirportR' AND dest_airport='$this->searchDestAirportR' AND dep_date='$this->depDateMinus2R';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->pricePerPersonMinus2R = $row['price'];
                $_SESSION['pricePerPersonMinus2R'] = $this->pricePerPersonMinus2R;
            }
            else
            {
                $_SESSION['pricePerPersonMinus2R'] = "-";
            }


            require "config.php";
            $search_query = "select '$this->searchDepDateR'-interval 1 day AS 'date';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depDateMinus1R = $row['date'];
                $_SESSION['depDateMinus1R'] = $this->depDateMinus1R;
            }
            else{$_SESSION['depDateMinus1R'] ="ha";}

            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirportR' AND dest_airport='$this->searchDestAirportR' AND dep_date='$this->depDateMinus1R';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->pricePerPersonMinus1R = $row['price'];
                $_SESSION['pricePerPersonMinus1R'] = $this->pricePerPersonMinus1R;
            }
            else
            {
                $_SESSION['pricePerPersonMinus1R'] = "-";
            }


            require "config.php";
            $search_query = "select '$this->searchDepDateR'+interval 1 day AS 'date';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depDatePlus1R = $row['date'];
                $_SESSION['depDatePlus1R'] = $this->depDatePlus1R;
            }
            else{$_SESSION['depDatePlus1'] ="ha";}

            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirportR' AND dest_airport='$this->searchDestAirportR' AND dep_date='$this->depDatePlus1R';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->pricePerPersonPlus1R = $row['price'];
                $_SESSION['pricePerPersonPlus1R'] = $this->pricePerPersonPlus1R;
            }
            else
            {
                $_SESSION['pricePerPersonPlus1R'] = "-";
            }


            require "config.php";
            $search_query = "select '$this->searchDepDateR'+interval 3 day AS 'date';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depDatePlus3R = $row['date'];
                $_SESSION['depDatePlus3R'] = $this->depDatePlus3R;
            }
            else{$_SESSION['depDatePlus3'] ="ha";}

            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirportR' AND dest_airport='$this->searchDestAirportR' AND dep_date='$this->depDatePlus3R';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->pricePerPersonPlus3R = $row['price'];
                $_SESSION['pricePerPersonPlus3R'] = $this->pricePerPersonPlus3R;
            }
            else
            {
                $_SESSION['pricePerPersonPlus3R'] = "-";
            }

            require "config.php";
            $search_query = "select '$this->searchDepDateR'+interval 2 day AS 'date';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->depDatePlus2R = $row['date'];
                $_SESSION['depDatePlus2R'] = $this->depDatePlus2R;
            }
            else{$_SESSION['depDatePlus2'] ="ha";}

            $search_query = "SELECT * FROM  flights WHERE dep_airport='$this->searchDepAirportR' AND dest_airport='$this->searchDestAirportR' AND dep_date='$this->depDatePlus2R';";
            $result = $conn->query($search_query);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->pricePerPersonPlus2R = $row['price'];
                $_SESSION['pricePerPersonPlus2R'] = $this->pricePerPersonPlus2R;
            }
            else
            {
                $_SESSION['pricePerPersonPlus2R'] = "-";
            }
    }
}