<?php
//class for ticket search
class Passengers{

    public $passengerName=array();
    public $passengerSurname=array();
    public $passengerTitle=array();
    public $checkInRadio;
    public $howMany;
    public $err;
    public $checkInCost;
    public $passengerSeat=array();

    public $passengersErr;
    public $checkInErr;

    function validate_passengers(){
        $err=false;

        for($x=1;$x<=$this->howMany;$x++){
            
            if (empty($this->passengerName[$x])||empty($this->passengerSurname[$x])||empty($this->passengerTitle[$x])) 
            {
                
                $this->passengersErr="All fields are required";
                $err=true;
                
            }
            if ($this->checkInRadio==false) 
            {
                
                $err=true;
                $this->checkInErr="This field is required";
                
            }
            
            if ($err==false){
    
                $_SESSION['passengerName'.$x]= $this->passengerName[$x];
                $_SESSION['passengerSurname'.$x]=$this->passengerSurname[$x];
                $_SESSION['passengerTitle'.$x]=$this->passengerTitle[$x];
                $_SESSION['checkIn']=$this->checkIn;
                if($this->checkIn=="online")
                {
                    $this->checkInCost=0;
                }
                else{
                    $this->checkInCost=15*$this->howMany;
                }
                $_SESSION['checkInCost']=$this->checkInCost;
                $_SESSION['x']=1;

                echo "<script>window.location.href='pick-seats.php'</script>";
            }
        }


    }

    function array_has_dupes($array) {
        return count($array) !== count(array_unique($array));
     }

    
}
?>