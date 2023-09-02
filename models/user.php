<?php
class User
{
    public $username;
    public $password;
    public $surname;
    public $email;
    public $type = 1;
    public $usernameErr = "";
    public $passwordErr = "";
    public $surnameErr = "";
    public $loginErr = "";

    // Function to log in the user
    function loginUser()
    {
        require "config.php";

        // Searches for the user
        $loginquery = "SELECT username, password, surname, type FROM user WHERE username=?";
        $stmt = $conn->prepare($loginquery);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $storedPassword = $row['password'];
            $this->type = $row['type'];
            $this->username = $row['username'];
            $this->surname = $row['surname'];

            // Verify the provided password with the stored hashed password
            if (password_verify($this->password, $storedPassword)) {
                // Password is correct, generate a new token
                $token = bin2hex(random_bytes(32));
                $_SESSION['auth_token'] = $token;
                $_SESSION['username'] = $this->username;
                $_SESSION['utype'] = $this->type;
                $_SESSION['surname'] = $this->surname;

                setcookie('auth_token', $token, time() + 3600, '/');
                $query = "UPDATE user SET token = ? WHERE username = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $token, $this->username);
                $stmt->execute();
                $stmt->close();
                $conn->close();

                if ($_SESSION['loggedToBook'] == true) {
                    echo "<script>window.location.href='../controllers/passenger-details.php'</script>";
                    $_SESSION['loggedToBook'] = false;
                } else if ($this->type == 2) {
                    echo "<script>window.location.href='../controllers/admin-menu.php'</script>";
                } else {
                    echo "<script>window.location.href='../controllers/index.php'</script>";
                }
            } else {
                // Incorrect password
                $this->loginErr = "Wrong credentials";
                $stmt->close();
                $conn->close();
            }
        } else {
            // User not found
            $this->loginErr = "User not found";
            $stmt->close();
            $conn->close();
        }
    }

    // Function to register a new user
    function register_user()
    {
        require "config.php";
        $err = false;

        // Checks if user already exists
        $registerquery = "SELECT * FROM user WHERE username=?";
        $stmt = $conn->prepare($registerquery);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Validates data
        if (empty($this->username)) {
            $this->usernameErr = "Email is required";
            $err = true;
        } else if (!filter_var($this->username, FILTER_VALIDATE_EMAIL)) {
            $this->usernameErr = "Invalid email format";
            $err = true;
        } else if ($result->num_rows > 0) {
            $this->usernameErr = "Email already exists";
            $err = true;
        }

        if (empty($this->surname)) {
            $this->surnameErr = "Surname is required";
            $err = true;
        }

        if (strlen($this->password) < 8) {
            $this->passwordErr = "Password must be 8 characters or more";
            $err = true;
        }

        if (empty($this->password)) {
            $this->passwordErr = "Password is required";
            $err = true;
        }

        // If err is false, insert a new user into the database
        if ($err == false) {
            $registerquery = "INSERT INTO user (username, password, surname, type) VALUES (?, ?, ?, 1)";
            $stmt = $conn->prepare($registerquery);
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bind_param("sss", $this->username, $hashedPassword, $this->surname);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            echo "<script>window.location.href='../controllers/login.php'</script>";
        } else if ($err == true) {
            $stmt->close();
            $conn->close();
        }
    }
}
