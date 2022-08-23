<?php

$document_root=$_SERVER['DOCUMENT_ROOT'];

require $document_root.'/php/connect.php';
require $document_root.'/php/functions.php';

session_start();

// set timezone to Lisbon (Portugal)
date_default_timezone_set("Europe/Lisbon");

// destroy session if logout
if (isset($_GET['submit']) && $_GET['submit'] == "logout")
    session_destroy();
// if already in session then go to home
else if(isset($_SESSION["userId"])){
    header("Location: home");
    exit();
}

$method = $_SERVER['REQUEST_METHOD']; 
if ($method === 'POST') {
    // check if there was a login submition
    if (isset($_POST['login-submit'])) {
        // fetch information from the login form
        $email = trim($_POST['email']);
        $pwd = $_POST['password'];

        // check if username exists
        $sql = "SELECT * FROM UserAuth WHERE email=?;";
        $stmt = mysqli_stmt_init($conn);
        // check if the query makes sense
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: login?submit=error");
            exit();
        }
        else {
            // use binding to prevent executing queries from the user
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            // fetch rows
            if ($row = mysqli_fetch_assoc($result)) {
                $pwd_check = password_verify($pwd, $row['pwd']);
                if ($pwd_check == true){
                    // get user data
                    $userData = apiFetch("http://".$_SERVER['SERVER_NAME']."/api/users?email=". $email)["data"][0];
                    
                    if ($userData) {
                        session_start();

                        $_SESSION['userId'] = $userData["id"];
                        $_SESSION['userUsername'] = $userData["username"];
                        $_SESSION['userStreamer'] = $userData["streamer"];
                        $_SESSION['userTickets'] = $userData["tickets"];

                        header("Location: login?submit=login");
                        exit();
                    }
                    else {
                        // Password is incorrect
                        header("Location: login?submit=error");
                        exit();
                    }
                }
                else {
                    // Password is incorrect
                    header("Location: login?submit=invalid");
                    exit();
                }
            }
            else {
                // Username not found
                header("Location: login?submit=invalid");
                exit();
            }
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/login.css"/>
    <link rel="stylesheet" href="css/essentials.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="icon" href="/images/GameBetLogo-square.png">
    <title>Login - Gamebet</title>
</head>

<body>
    <div id="container">
        <div class="button button-sec"><a href="signup">Create Account</a></div>

        <h1 style="margin-top: 30px;" id="login-title">Login</h1>

        <?php
            if (isset($_GET['submit'])) {
                switch($_GET['submit']) {
                    case "nologin":
                        echo "
                            <div style=\"color: red;\" class=\"session-message\">
                                You need to be logged in to view that page.
                            </div>
                        ";
                        break;
                    case "invalid":
                        echo "
                            <div style=\"color: red;\" class=\"session-message\">
                                <strong>ERROR:</strong> The credentials provided are invalid.
                            </div>
                        ";
                        break;
                    case "error":
                        echo "
                            <div style=\"color: red;\" class=\"session-message\">
                               <strong>ERROR:</strong> There was an issue while trying to login!
                            </div>
                        ";
                        break;
                    case "logout":
                        echo "
                            <div style=\"color: green;\" class=\"session-message\">
                                <strong>SUCCESS:</strong> Logged out successfuly!
                            </div>
                        ";
                        break;
                    case "login":
                        echo "
                            <div style=\"color: green;\" class=\"session-message\">
                                <strong>SUCCESS:</strong> Logged in successfuly!
                            </div>
                        ";
                        break;
                }
            }
        ?>

        <!-- não encontrei a imagem que está no prototipo-->
        <img src="images/AS-logo.png" id="logo">

        <form class="auth-form" method="post" action="login">
            <div>
                <img src="images/email.png">        
                <input placeholder="email@example.com" type="text" name="email" required>
            </div>
            <div>
                <img src="images/lock.png">     
                <input placeholder="password" type="password" name="password" required>
            </div>
            <input class="button" type="submit" value="Login" name="login-submit">                         
        </form> 
    </div>

    <script type="text/javascript" src="js/login.js"></script>
</body>
</html>
