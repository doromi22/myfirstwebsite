<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Notepad Online</title>
    <link rel="stylesheet" type="text/css" href="./assets/style.css" />
</head>

<body>
    <h1><a href="index.php">Notepad Online</a></h1>
    <div class="boxtop">
        <ul>
            <li id="write"><a href="write.php">Write</a></li>
            <li id="history"><a href="history.php">History</a></li>
            <?php
            if (isset($_SESSION['username'])) {
                // logged in
                $loggedInUsername = $_SESSION['username'];
                echo '<li id="logoutBtn"><a href="logout.php">Logout</a></li>';
                echo '<li id="welcomelogin">Welcome, ' . $loggedInUsername . '!</li>';
            } else {
                // not logged in
                echo '<li id="loginBtn"><a href="#" onclick="openPopup(\'loginform\')">Login</a></li>';
                echo '<li id="registerBtn"><a href="#" onclick="openPopup(\'registerform\')">Register</a></li>';
            }
            ?>
        </ul>
    </div>
    <div id="loginform" class="modal">
        <div class="modal-content">
            <h2>Login</h2>
            <form action="sign.php" method="post">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username">
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                </div>
                <button type="submit" name="login">Login</button>
                <button type="button" onclick="closePopup()">Close</button>
            </form>
        </div>
    </div>
    <div id="registerform" class="modal">
        <div class="modal-content">
            <h2>Sign Up</h2>
            <form action="signup.php" method="post">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username">
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password">
                </div>
                <button type="submit" name="signup">Register</button>
                <button type="button" onclick="closePopup()">Close</button>
            </form>
        </div>
    </div>
    <script src="./assets/script.js"></script>
</body>

</html>