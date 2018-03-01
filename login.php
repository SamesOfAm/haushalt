<?php
$email = $mysqli->escape_string($_POST['email']);
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

if ( $result->num_rows == 0 ){
    echo 'Kein Nutzer mit dieser E-Mail-Adresse';
    $_SESSION['message'] = "Kein Nutzer mit dieser E-Mail-Adresse";
    header("location: error.php");
}

else {
    $user = $result->fetch_assoc();
    
    if ( password_verify($_POST['password'], $user['password']) ) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['active'] = $user['active'];
        
        $_SESSION['logged_in'] = true;
        
        header("location: profile.php");
    }
    
    else {
        $_SESSION['message'] = "Falscher Nutzername oder Passwort";
    }
}
?>