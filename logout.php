<?php
/* Log out process, unsets and destroys session variables */
session_start();
session_unset();
session_destroy(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Haushalt</title>
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:300,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/index.css">
</head>

<body>
    <div class="box">
        <h3>Logout erfolgreich</h3>
        <p>Erneut einloggen</p>
        <div id="login">
            <form action="index.php" method="post" id="login-form" class="index-form" name="login">
                <input required type="text" placeholder="E-Mail" name="email">
                <input required type="password" placeholder="Passwort" name="password">
                <button class="button" name="login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>