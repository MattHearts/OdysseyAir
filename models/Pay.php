<?php
//class for ticket search
class Pay{
    public $cardNumber;
    public $cardName;
    public $cardCVV;

    public $numErr;
    public $nameErr;
    public $CVVErr;

    public $err=false;

    function validateCard(){
        if(!strlen($this->cardNumber)==16)
        {
            $this->numErr="Please enter a 16-digit card number";
            $this->err=true;
        }
        if(empty($this->cardName))
        {
            $this->nameErr="Please enter the name on your card";
            $this->err=true;
        }
        if(!strlen($this->cardCVV)==3||!strlen($this->cardCVV)==3)
        {
            $this->CVVErr="Please enter a 3-4 digit CVV";
            $this->err=true;
        }

        if ($this->err==false){
    
            $_SESSION['cardNumber']= $this->cardNumber;
            $_SESSION['cardName']= $this->cardNumber;
            $_SESSION['cardCVV']= $this->cardNumber;
        }
    }
}