<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Eagle Creek Lodge</title>
	<link rel="icon" href="img/favicon.png" type="image/png">

  <link rel="stylesheet" href="vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="vendors/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="vendors/linericon/style.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="css/normalize.css">

  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css?family=Zilla+Slab" rel="stylesheet">


<style>
  html,body{overflow-x: hidden;}
  html { overflow-y: scroll; }

  .navCustom{
    background-color: #b59a77;

  }
  .bodyCustom{
    background-color: #dbc4a6;
    padding-top: 2em;
  }
  .fontCustom{
    font-family: "Zilla Slab",serif!important;
  }
  .quotes{
    font-family: "Zilla Slab",serif!important;
    text-align: center;
    font-size: 28px;
    color: #000000;
    padding-top: 2em;
    padding-bottom: 2em;
  }
  .left{
    text-align: left;
  }
  .right{
    text-align: right;
  }
  .center{
    text-align: center;
  }
  .pad-right1{
    padding-right: 4em;
  }
  .brown1{
    color: #4c3216;
  }
  .inline{
    display: inline-block;
  }
  .padBottom{
    padding-bottom: 2em;
  }
  @media (max-width: 991px) {
    nav.navbar {
      background: lightgray !important;
    }
  }
  #header_placeholder {
    height:70px;
    width:100%;
    display:none;
}

    .img-responsivex {
      height: auto;
      width: auto;
      max-height: 77px;
      max-width: 255px;
    }
  </style>
</head>

<body>
  <!--================Header Menu Area =================-->
  <header class="header_area navCustom">
    <div class="main_menu">
      <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container box_1620">
          <!-- Brand and toggle get grouped for better mobile display -->
          <a class="navbar-brand logo_h" href="index.html"><img src="img/logo.png" alt="logo"
              class="img-responsivex"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
            <ul class="nav navbar-nav menu_nav mr-auto">
              <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
              <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
              <li class="nav-item"><a class="nav-link" href="amenities.html">Amenities</a></li>
              <li class="nav-item"><a class="nav-link" href="gallery.html">Gallery</a></li>
              <li class="nav-item submenu dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">Events</a>
                <ul class="dropdown-menu">
                  <li class="nav-item"><a class="nav-link" href="weddings.html">Weddings</a></li>
                  <li class="nav-item"><a class="nav-link" href="localActivities.html">Local Activities</a></li>
                </ul>
              </li>
              <li class="nav-item"><a class="nav-link" href="calendar.html">Calendar</a></li>
              <li class="nav-item"><a class="nav-link" href="testimonials.html">Testimonials</a></li>
              <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right navbar-social">
              <li><a href="#"><i class="ti-facebook"></i></a></li>
              <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
              <li><a href="#"><i class="ti-instagram"></i></a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <div id="header_placeholder"></div>
  </header>

</body>
</html>
  <!--================Header Menu Area =================-->
  <?php
  // Initialize the session
  session_start();

  // Check if the user is already logged in, if yes then redirect him to welcome page
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      header("location: weddings.html");
      exit;
  }

  // Include config file
  require_once "welcome.php";

  // Define variables and initialize with empty values
  $username = $password = "";
  $username_err = $password_err = "";

  // Processing form data when form is submitted
  if($_SERVER["REQUEST_METHOD"] == "POST"){

      // Check if username is empty
      if(empty(trim($_POST["username"]))){
          $username_err = "Please enter username.";
      } else{
          $username = trim($_POST["username"]);
      }

      // Check if password is empty
      if(empty(trim($_POST["password"]))){
          $password_err = "Please enter your password.";
      } else{
          $password = trim($_POST["password"]);
      }

      // Validate credentials
      if(empty($username_err) && empty($password_err)){
          // Prepare a select statement
          $sql = "SELECT id, username, password FROM users WHERE username = ?";

          if($stmt = mysqli_prepare($link, $sql)){
              // Bind variables to the prepared statement as parameters
              mysqli_stmt_bind_param($stmt, "s", $param_username);

              // Set parameters
              $param_username = $username;

              // Attempt to execute the prepared statement
              if(mysqli_stmt_execute($stmt)){
                  // Store result
                  mysqli_stmt_store_result($stmt);

                  // Check if username exists, if yes then verify password
                  if(mysqli_stmt_num_rows($stmt) == 1){
                      // Bind result variables
                      mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                      if(mysqli_stmt_fetch($stmt)){
                          if(password_verify($password, $hashed_password)){
                              // Password is correct, so start a new session
                              session_start();

                              // Store data in session variables
                              $_SESSION["loggedin"] = true;
                              $_SESSION["id"] = $id;
                              $_SESSION["username"] = $username;

                              // Redirect user to welcome page
                              header("location: welcome.php");
                          } else{
                              // Display an error message if password is not valid
                              $password_err = "The password you entered was not valid.";
                          }
                      }
                  } else{
                      // Display an error message if username doesn't exist
                      $username_err = "No account found with that username.";
                  }
              } else{
                  echo "Oops! Something went wrong. Please try again later.";
              }
          }

          // Close statement
          mysqli_stmt_close($stmt);
      }

      // Close connection
      mysqli_close($link);
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">
  <body>
  <main class="site-main bodyCustom">
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-lg-12 center padBottom">
          <a href="export.php" class="btn btn-info" role="button">Dump Email Database!</a>
        </div>
      </div>
    </div>

  </main>

  <!--================ Start Footer Area =================-->
  <footer class="footer-area section-padding">
    <div class="container">
      <div class="row">
        <div class="col-lg-5  col-md-6 col-sm-6 left">
          <div class="single-footer-widget">
            <h6>About Us</h6>
            <p>
              Whether you are looking to plan a relaxing weekend getaway with family and friends or attend a Penn State sporting event, Eagle Creek Lodge is the place for you!
            </p>
          </div>
        </div>
        <div class="col-lg-4  col-md-6 col-sm-6 center">
          <div class="single-footer-widget">
            <h6 class="pad-right1">Newsletter</h6>
            <p class="pad-right1">Stay up to date with our latest news</p>
            <div class="" id="mc_embed_signup">

              <form target="_blank" action="insert.php" method="post" class="form-inline">

                <div class="d-flex flex-row">

                  <input class="form-control" name="email" placeholder="Enter Email" onfocus="this.placeholder = ''"
                    onblur="this.placeholder = 'Enter Email '" required="" type="email">


                  <button class="click-btn btn btn-default"><span class="lnr lnr-arrow-right"></span></button>
                  <!--<div style="position: absolute; left: -5000px;">
                    <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
                  </div>-->

                </div>
                <div class="info"></div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-lg-3  col-md-6 col-sm-6 right">
          <div class="single-footer-widget">
            <h6>Follow Us</h6>
            <p> </p>
            <div class="footer-social right">
              <a href="#">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#">
                <i class="fab fa-instagram"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-bottom d-flex justify-content-center align-items-center flex-wrap">
        <p class="footer-text m-0">Copyright © 2019 Eagle Creek Lodge</p>
      </div>
    </div>
  </footer>
  <!--================ End Footer Area =================-->

  <script src="vendors/jquery/jquery-3.2.1.min.js"></script>
  <script src="vendors/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="js/main.js"></script>

</body>
</html>
