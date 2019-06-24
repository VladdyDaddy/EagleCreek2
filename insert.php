<?php
// Checks if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6LdM7akUAAAAAAaIRc_-AgoYc8gR4sKQkLEl6x6H',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    // Call the function post_captcha
    $res = post_captcha($_POST['g-recaptcha-response']);

    if (!$res['success']) {
        // What happens when the reCAPTCHA is not properly set up
        echo 'reCAPTCHA error: Check to make sure your keys match the registered domain and are in the correct locations. You may also want to doublecheck your code for typos or syntax errors.';
    } else {
        // If CAPTCHA is successful...

        // Paste mail function or whatever else you want to happen here!

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
    }
  } else {
    echo "This is bad";
  } 
?>
