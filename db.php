<?php
    $host_name = 'db698740020.db.1and1.com';
    $user_name = 'dbo698740020';
    $password = 'ThisP4ssw0r6';
    $db = 'db698740020';

    $mysqli = new mysqli($host_name, $user_name, $password, $db);
    if ($mysqli->connect_errno) {
        printf("Connection failed: %s\n", $mysqli->connect_error);
        die();
    }
?>