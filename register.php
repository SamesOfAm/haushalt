<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
      
// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM users WHERE email='$email'") or die($mysqli->error());

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
    
    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");
    
}
else { // Email doesn't already exist in a database, proceed...

    // active is 0 by DEFAULT (no need to include it here)
    $sql = "INSERT INTO users (first_name, last_name, email, password, hash) " 
            . "VALUES ('$first_name','$last_name','$email','$password', '$hash')";

    // Add user to the database
    if ( $mysqli->query($sql) ){

        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
        $_SESSION['logged_in'] = true; // So we know the user has logged in
        $_SESSION['message'] =
                
                 "Confirmation link has been sent to $email, please verify
                 your account by clicking on the link in the message!";
        
        $query = "SELECT CONCAT(id,'_',first_name,'_',last_name) FROM users WHERE email='$email'";
        $result = $mysqli->query($query);
        $result_array = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $result_array = $row;
        };
        $new_user_table = $result_array["CONCAT(id,'_',first_name,'_',last_name)"];        
        $next_query = "CREATE TABLE " . $new_user_table . " (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
            date VARCHAR(11) NOT NULL,
            dayClass INT(11) NOT NULL,
            type VARCHAR(50) NOT NULL,
            item VARCHAR(50), 
            amount DECIMAL(10,2) NOT NULL
        )";
        
        if ( $mysqli->query($next_query) ){
            echo 'Created new table';
        }        
        else {
            die ('Could not create user table');
        }
        
        // Send registration confirmation link (verify.php)
        $to      = $email;
        $subject = 'Registrierung abschließen';
        $message_body = 'Hallo,
        zum Aktivieren Link klicken:

        http://samesofam.com/verify.php?email='.$email.'&hash='.$hash;  

        mail( $to, $subject, $message_body, "From: service@haushalt.de" );

        header("location: profile.php"); 

    }

    else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: error.php");
    }

}
ob_end_flush();
?>