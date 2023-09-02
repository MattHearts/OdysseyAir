<?php
class Authentication
{
    function isAuthenticated($token)
    {
        require "config.php"; 

        if (isset($_SESSION['username'])) {
            // Retrieves the stored token for the user from the database
            $username = $_SESSION['username']; 
            $query = "SELECT token FROM user WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $storedToken = $row['token'];

                // Compares the retrieved token with the provided token
                return ($token === $storedToken);
            }

            return false; // User not found
        } else {
            return false;
        }
    }

    // Checks if user is admin based on the type field
    public function isAdmin($username) {
        require "config.php"; 
        $query = "SELECT type FROM user WHERE username = ?";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        
        $stmt->execute();
        $stmt->bind_result($type);
        $stmt->fetch();
        $stmt->close();
        
        return $type === 2;
    }
}
