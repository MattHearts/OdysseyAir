<?php
class Pay{
    public $cardNumber;
    public $cardName;
    public $cardCVV;

    public $numErr;
    public $nameErr;
    public $CVVErr;

    public $err=false;

    // Validates card data
    function validateCard(){
        if (strlen($this->cardNumber) != 19) {
            $this->numErr = "Please enter a 16-digit card number";
            $this->err = true;
        }
        if (empty($this->cardName)) {
            $this->nameErr = "Please enter the name on your card";
            $this->err = true;
        }
        if (!(strlen($this->cardCVV) == 3 || strlen($this->cardCVV) == 4)) {
            $this->CVVErr = "Please enter a 3-4 digit CVV";
            $this->err = true;
        }
    
        if (!$this->err) {
            $_SESSION['cardNumber'] = $this->cardNumber;
            $_SESSION['cardName'] = $this->cardName;
            $_SESSION['cardCVV'] = $this->cardCVV;
        }
    }
}