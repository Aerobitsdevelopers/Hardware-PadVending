<?php
include("./config.php");
session_start();

$error = "Login to continue";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $myusername = mysqli_real_escape_string($mysqli, substr($_POST['username'], 0, 60));
    $mypassword = mysqli_real_escape_string($mysqli, substr($_POST['password'], 0, 16));

    $myusernameformatted = strtolower(preg_replace('/\s+/', '', $myusername));

    $result = $mysqli->query("SELECT id,username,passcode,criteria FROM admin WHERE username = '$myusernameformatted' AND active = 1");

    if ($result) {
        $count = mysqli_num_rows($result);
        $row = mysqli_fetch_array($result);
        if ($count == 1 && password_verify($mypassword, $row['passcode'])) {
            if ($row['criteria'] != null || $row['criteria'] != '') {
                $_SESSION['login_user'] = $myusernameformatted;
                if ($row['criteria'] == 'admin') {
                    header("location: control/index.php");
                } else {
                    $timestamp = date("d/m/y - h:i:s");
                    $mysqli->query("UPDATE admin SET login = '$timestamp' WHERE username = '$myusernameformatted'");
                    header("location: index.php");
                }
            } else {
                $error = "No Criteria Assigned to this Account";
            }
        } else {
            $error = "Invalid Credentials";
        }
    }
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vending Admin</title>
    <meta name="description" content="Adishankara Business Incubator">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/login.css" />
</head>

<body class="background-bgimg">
    <div class="login-content">
        <h1>Login</h1>
        <form action="" method="post">
            <input type="text" name="username" class="box" placeholder="Username"><br><br>
            <input type="password" name="password" class="box" placeholder="Password"><br><br>
            <div style="font-size:11px; color:#cc0000; margin-bottom:10px"><?php echo $error; ?></div>
            <input type="submit" value="Login" /><br>
        </form>
        <img class="logo-container" src="./images/logo.png">
        <!-- <div class="copyright">
            &copy; 2023 ASIET. All Rights Reserved. Designed by <a style="text-decoration: none;color: #2980B9;" href="http://aerodevelopers.com/" target="_blank">Aerobits Developers</a><br>
        </div> -->
    </div>
</body>

</html>