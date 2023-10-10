<?php //session_start(); 
require 'config.php';
if(isset($_SESSION["login_id"])){
$id = $_SESSION['login_id'];
$get_user = mysqli_query($db_connection, "SELECT * FROM `users` WHERE `google_id`='$id'");
if(mysqli_num_rows($get_user) > 0){
    $user = mysqli_fetch_assoc($get_user);
}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="./style.css" />
    <title>Relaxsome</title>
  </head>
  <body>
    <div class="screen-one">
    <?php 
    if(empty($_SESSION["login_id"]))
     {?>
    <a href="/" class="back-btn"><img src="./images/icon.png"></img></a>
    <?php } else {?>
     <div class="profile_img"><img src="<?php echo $user['profile_image']; ?>"/></div>
     <a href="logout.php" class="logout_btn">Logout</a>
     <?php } ?>
         <?php 
    if(empty($_SESSION["login_id"]))
     {?>
      <button id="toggle">MEDITATING</button>
      <div id="welcome">
       <p>Hello,How are you doing today?</p>
       <form action="/playmusic.php" method="POST">
        <label>You can powerup your dead cells by meditating for</label>
        <input type="radio" id="2" name="timer" value="2" required /><span>2 minutes </span>
        <input type="radio" id="5" name="timer" value="5" required/><span>5 minutes </span>
        <input type="radio" id="10" name="timer" value="10" required/><span>10 minutes </span>
       <input type="submit" name="submit" value="Listen" class="listen_btn">
       </form>
      </div>
      <?php } else{?>
       <button type="submit" id="stress_btn" onclick="hrefFunction()">STRESS CALCULATOR</button>
       <button type="submit" id="audio_btn" onclick="audioplayer()">AUDIO PLAYER</button>
    <?php  }?>
    </div>
    <script>
      function hrefFunction(){
                location.href = "https://relaxsome.me/stress.php";
            }
      function audioplayer(){
                location.href = "https://relaxsome.me/playmusic.php";
            }
        const targetDiv = document.getElementById("welcome");
const btn = document.getElementById("toggle");
btn.onclick = function () {
  if (targetDiv.style.display !== "none") {
    targetDiv.style.display = "none";
  } else {
    targetDiv.style.display = "block";
  }
}; 
    </script>
    

  </body>
</html>