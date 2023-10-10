<?php
require 'config.php';
if(isset($_SESSION['login_id'])){
    header('Location: meditating.php');
    exit;
}
require 'google-api/vendor/autoload.php';
// Creating new google client instance
$client = new Google_Client();
// Enter your Client ID
$client->setClientId('683208443895-gfg4rvmt62jkgo7iln556n3mo5dtvtr3.apps.googleusercontent.com');
// Enter your Client Secrect
$client->setClientSecret('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');
// Enter the Redirect URL
$client->setRedirectUri('https://relaxsome.me');
// Adding those scopes which we want to get (email & profile Information)
$client->addScope("email");
$client->addScope("profile");
if(isset($_GET['code'])){
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if(!isset($token["error"])){
        $client->setAccessToken($token['access_token']);
        // getting profile information
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
    
        // Storing data into database
        $id = mysqli_real_escape_string($db_connection, $google_account_info->id);
        $full_name = mysqli_real_escape_string($db_connection, trim($google_account_info->name));
        $email = mysqli_real_escape_string($db_connection, $google_account_info->email);
        $profile_pic = mysqli_real_escape_string($db_connection, $google_account_info->picture);
        // checking user already exists or not
        $get_user = mysqli_query($db_connection, "SELECT `google_id` FROM `users` WHERE `google_id`='$id'");
        if(mysqli_num_rows($get_user) > 0){
            $_SESSION['login_id'] = $id; 
            header('Location: meditating.php');
            exit;
        }
        else{
            // if user not exists we will insert the user
            $insert = mysqli_query($db_connection, "INSERT INTO `users`(`google_id`,`name`,`email`,`profile_image`) VALUES('$id','$full_name','$email','$profile_pic')");
            if($insert){
                $_SESSION['login_id'] = $id; 
                header('Location: meditating.php');
                exit;
            }
            else{
                echo "Sign up failed!(Something went wrong).";
            }
        }
    }
    else{
        header('Location: login.php');
        exit;
    }
    
  }
    // Google Login Url = $client->createAuthUrl(); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Babylonica' rel='stylesheet'>
    <link rel="stylesheet" href="./style.css" />
    <title>Relaxsome</title>
  </head>
  <body>
   
    <div class="screen-one">
      <span id="MyClockDisplay" class="clock" onload="showTime()"></span>
      <h2>RELAXSOME</h2>
      <!-- <button id="social_login_btn">Login with Google</button> -->
      <a type="button" class="login-with-google-btn" href="<?php echo $client->createAuthUrl(); ?>">
            Sign in with Google
        </a>
      <span id="alt_stmnt">OR</span>
     <a href="meditating.php" class="trial_btn"> <p>Free Trial</p></a>
    </div>
    
    

    <script src="app.js"></script>
    

  </body>
</html>