<?php
/* Displays all error messages */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:300,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/index.css">
</head>
<body>
<div class="box">
    <div class="form">
        <h2>Fehler</h2>
        <p>
        <?php 
        if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
            echo $_SESSION['message'];    
        else:
            header( "location: index.php" );
        endif;
        ?>
        </p>     
        <a href="index.php"><button class="button button-block">Zurück</button></a>
    </div>
</div>
</body>
</html>