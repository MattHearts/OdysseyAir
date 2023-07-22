<?php
//class for ticket search
class Passengers{

    public $passengerName=array();
    public $passengerSurname=array();
    public $passengerTitle=array();
    public $checkInRadio;
    public $howMany;
    public $err;
    public $checkIn;
    public $checkInCost;
    public $passengerSeat=array();
    public $passengerSeatR=array();
    public $suitcaseNumber=array();
    public $overallPriceV2;

    public $passengersErr;
    public $checkInErr;


    function validate_passengers(){
        $err=false;

        for($x=1;$x<=$this->howMany;$x++){
            
            
            
    
                $_SESSION['passengerName'.$x]= $this->passengerName[$x];
                $_SESSION['passengerSurname'.$x]=$this->passengerSurname[$x];
                $_SESSION['passengerTitle'.$x]=$this->passengerTitle[$x];
                $_SESSION['suitcaseNumber'.$x]=$this->suitcaseNumber[$x];
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
                $_SESSION['overallPriceV2']=$this->overallPriceV2;

 
                echo "<script>window.location.href='pick-seats.php'</script>";
            
        


    }
}

    function array_has_dupes($array) {
        return count($array) !== count(array_unique($array));
     }

    

}
?>