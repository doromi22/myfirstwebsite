<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $dotenv = parse_ini_file('.env');
        $host = $dotenv['DB_HOST'];
        $username = $dotenv['DB_USERNAME'];
        $password = $dotenv['DB_PASSWORD'];
        $database = "notepad";

        // database connection
        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("database connection failed: " . $conn->connect_error);
        }

        // get data from login form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // user identification
        $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            // password check if user exists
            $storedPassword = $result['password'];
            if (password_verify($password, $storedPassword)) {
                // login success if password is correct
                $_SESSION['username'] = $username; // save username to session
                session_regenerate_id(true); // create new session id
                $loginSuccessMessage = "logged in successfully.";
                // pop up message and redirection to index
                echo '<script>alert("' . $loginSuccessMessage . '"); window.location.href = "index.php";</script>';
                exit();
            } else {
                // incorrect password
                $loginFailureMessage = "login failed. please check username/password.";
                echo '<script>alert("' . $loginFailureMessage . '"); window.location.href = "index.php";</script>';
            }
        } else {
            // user doesn't exist
            $loginFailureMessage = "login failed. please check username/password.";
            echo '<script>alert("' . $loginFailureMessage . '"); window.location.href = "index.php";</script>';
        }

        $conn->close(); // end database connection
    }
}
?>