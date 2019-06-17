<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "vladdydaddy", "@\8Fn:f/BS7uS", "newsletter");

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security
$email = mysqli_real_escape_string($link, $_REQUEST['email']);

$clean_email = filter_var($email,FILTER_SANITIZE_EMAIL);

if ($email == $clean_email && filter_var($email,FILTER_VALIDATE_EMAIL)){
   // now you know the original email was safe to insert.
   // insert into database code go here.
}

// Attempt insert query execution
$sql = "INSERT INTO newsletter (email) VALUES ('$clean_email')";
if(mysqli_query($link, $sql)){
    header("Location: index2.html");
} else{
    echo "ERROR: Not able to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>
