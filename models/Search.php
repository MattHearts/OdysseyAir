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




    function search_flights()
    {
        $_SESSION['whosGoing'] = $this->whosGoing;
        $_SESSION['searchDepAirport'] = $this->searchDepAirport;
        $_SESSION['searchDestAirport'] = $this->searchDestAirport;
        $_SESSION['searchDepDate'] = $this->searchDepDate;
        $err = false;


        if (empty($this->searchDepAirport) || empty($this->searchDestAirport) || empty($this->searchDepDate)) {
            $this->searchErr = "All fields are required";

            $err = true;
        }
        if ($err == false) {

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
                echo "<script>window.location.href='../controllers/search-results.php'</script>";

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
                echo "<script>window.location.href='../controllers/search-results.php'</script>";
                $_SESSION['errMessage'] = "Sorry, no available flights this day :(";
            }

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

}