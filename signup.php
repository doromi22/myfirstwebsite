<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
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

        // get data from register form
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Check if username or password is empty or contains only spaces
        if (empty($username) || empty($password) || !preg_match('/\S/', $username) || !preg_match('/\S/', $password)) {
            echo '<script>alert("Invalid username or password."); window.location.href = "index.php";</script>';
            exit();
        }

        // hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // username duplication check
        $check_query = "SELECT * FROM users WHERE username=?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result()->fetch_assoc();

        if ($check_result) {
            echo '<script>alert("Username already taken."); window.location.href = "index.php";</script>';
        } else {
            // new user
            $insert_query = "INSERT INTO users (username, password) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("ss", $username, $hashedPassword);
            $insert_stmt->execute();

            echo '<script>alert("Signed up successfully.");</script>';
            echo '<script>alert("Please login first."); window.location.href = "index.php";</script>';
            exit();
        }

        $conn->close(); // end database connection
    }
}
?>