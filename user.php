<?php
//κλαση για τον user που έκανε log
class User{
    public $username;
    public $password;
    public $surname;
    public $email;
    public $type=1;
    public $usernameErr="";
    public $passwordErr="";
    public $surnameErr="";
    public $loginErr="";


    function loginUser()
    {
        require "config.php";

        $loginquery = "SELECT * FROM user WHERE username='$this->username' AND password = '$this->password'";
        $result =$conn->query($loginquery);
        if ($result->num_rows > 0) 
        {
            $row = $result->fetch_assoc();
            $this->type= $row['type'];
            $this->username= $row['username'];
            $this->surname= $row['surname'];
            
            $_SESSION['username']=$this->username;
            $_SESSION['utype']=$this->type;
            $_SESSION['surname']=$this->surname;

            $conn->close();
		
            if($_SESSION['loggedToBook']==true){
                echo "<script>window.location.href='passenger-details.php'</script>";
                $_SESSION['loggedToBook']=false;
            }
            else if ($this->type == 2) {
                echo "<script>window.location.href='admin-menu.php'</script>";
            }
            else
            echo "<script>window.location.href='index.php'</script>";

        }
        else
        {
            $conn->close();
            $this->loginErr = "Wrong credentials";
        }
    }

    function register_user()
    {
        
        require "config.php";
        $err=false;

        $registerquery = "SELECT *  FROM user WHERE username='$this->username' ";
        $result = $conn->query( $registerquery);
        
        if (empty($this->username)) 
        {
            $this->usernameErr="Email is required";
            //die("<p>Please fill all required fields!</p>");
            $err=true;
            
            
        }

        else if (!filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
            $this->usernameErr = "Invalid email format";
            
            $err=true;
          }
                
        else if ($result->num_rows > 0) 
        {
            $this->usernameErr="Email already exists";
            //echo "<p>This account already exists.</p>";
            
            $err=true;
            
        }

        if (empty($this->surname))
        {
            $this->surnameErr="Surname is required";
            
            $err=true;
        }

        if (strlen($this->password)<8)
        {
            $this->passwordErr="Password must be 8 characters or more";
            
            $err=true;
        }
        
        if (empty($this->password))
        {
            $this->passwordErr="Password is required";
            
            $err=true;
        }


        

        
        if ($err==false)
	    {
			
		$registerquery = "INSERT INTO user (username, password, surname, type)
		VALUES ('$this->username', '$this->password','$this->surname',1)";

		if ($conn->query($registerquery)) 
		{
		
			$_SESSION['username']=$this->username;
			$_SESSION['utype']=$this->type;
			$_SESSION['surname']=$this->surname;
			$conn->close();
            echo "<script>window.location.href='menu.php'</script>";
        }
        }
        else if ($err==true)
        {
            $conn->close();
        }
    }
}