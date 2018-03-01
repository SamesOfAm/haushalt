<?php
ob_start();
require 'db.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Haushalt</title>
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:300,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/index.css">
</head>
<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (isset($_POST['login'])) {
            require 'login.php';
        }
        
        elseif (isset($_POST['register'])) {
            require 'register.php';
        }
    }
?>
<body>
    <div class="header">
        <h1>Haushalt</h1>
        <h3>Login oder Registrieren</h3>
    </div>
    <div class="box">
        <div class="index-select">
            <div class="tab active">
                <a id="log-select" href="#login">Login</a>
            </div>
            <div class="tab">
                <a id="reg-select" href="#register">Registrieren</a>
            </div>
        </div>
        <div class="tabs">
            <div id="login">
                <form action="index.php" method="post" id="login-form" class="index-form" name="login">
                    <input required type="text" placeholder="E-Mail" name="email">
                    <input required type="password" placeholder="Passwort" name="password">
                    <button class="button" name="login">Login</button>
                </form>
            </div>
            <div id="register">
                <form action="index.php" method="post" id="register-form" class="index-form" name="register">
                    <input required type="text" placeholder="Vorname" name="firstname">
                    <input required type="text" placeholder="Nachname" name="lastname">
                    <input required type="password" placeholder="Passwort" name="password">
                    <input required type="text" placeholder="E-Mail" name="email">
                    <button class="button" name="register">Registrieren</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
</body>
</html>