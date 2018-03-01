<?php
/* Displays all successful messages */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Success</title>
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:300,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/index.css">
</head>
<body>
<div class="form">
    <h2><?= 'Registrierung erfolgreich'; ?></h2>
    <div class="box">
        <p>
            <?php 
                if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ):
                    echo $_SESSION['message'];    
                else:
                    header( "location: index.php" );
                endif;
            ?>
        </p>
        <div id="login">
                <form action="index.php" method="post" id="login-form" class="index-form" name="login">
                    <input required type="text" placeholder="E-Mail" name="email">
                    <input required type="password" placeholder="Passwort" name="password">
                    <button class="button" name="login">Login</button>
                </form>
            </div>
    </div>
</div>
</body>
</html>
