<?php 
require "config.php";
if(isset($_POST['submit'])){
    $stress_facts = json_encode($_POST['stress_facts']);
   if(!$db_connection->query("INSERT INTO activity VALUES(NULL,'".$_POST['google_id']."','".$stress_facts."','".$_POST['anxious_facts']."','".$_POST['created_at']."','".$_POST['updated_at']."')")){
    echo("Error description: ".$db_connection->error);
   }
   $result = $db_connection->query("SELECT stress_facts from activity WHERE created_at ='".$_POST['created_at']."'");
//print_r($result);
}
?>
<html>
    <head>
        <style>
             .app {
    height: 100vh;
    display: flex;
    justify-content: space-evenly;
    align-items: center;
    font-family: "Montserrat", sans-serif;
    background-size: cover;
    background-image: url(/images/bg-img.jpg);
  }
  .stress_analysis{
    float: left;
    position: absolute;
    left: 10%;
    right: 10%;
  }
  .stress_analysis label{
    float: left;
    width: 27%;
    font-size: 34px;
    margin-bottom: 20px;
  }
  .stress_analysis span{
    font-size:25px;
   }
   .anxious_blck{
    float:left;
    width:100%;
   }
   .stress_analysis textarea{
    float: left;
    width: 70%;
    margin-bottom:20px;
   }
   .listen_btn{
    float: left;
    max-width: 120px;
    width: 100%;
    margin-top: 12px;
  } 
  .meter {
  background: #ccc;
  border-radius: 25px;
  box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
  display: block;
  height: 35px;
  margin-bottom: 10px;
  padding: 8px;
  position: absolute;
  bottom:30%;
  width:auto;
  left:20%;
  right:20%;
  }
  .meter span {
    display: block;
    height: 100%;
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
    border-top-left-radius: 20px;
    border-bottom-left-radius: 20px;
    background-color: rgb(43,194,83);
    background-image: linear-gradient(to top, rgb(43,194,83) 37%, rgb(84,240,84) 69%);
    box-shadow: inset 0 2px 9px rgba(255,255,255,0.3) inset 0 -2px 6px rgba(0,0,0,0.4);
    position: relative;
    overflow: hidden;
    transition: width 2s ease-out;
  }
  .cadetblue span {
    background-color: cadetblue;
    background-image: linear-gradient(to bottom, aqua, dodgerblue);
  }
  .stress_blockstmt{
    color: black;
    font-size: 50px;
    position: absolute;
    top: 23%;
  }
  .back-btn{
    position: absolute;
    top: 3%;
    left: 4%;
}
        </style>
    </head>
    <title>Stress</title>
    <body>
        <div class="app">
       <?php if(!empty($_SESSION["login_id"]))
     {?>
    <a href="/meditating.php" class="back-btn"><img src="./images/icon.png"></img></a>
    <?php }?>
    <form class="stress_analysis" method="POST" action="stress.php">
    <input type="hidden" value="<?php echo $_SESSION['login_id'];?>" name="google_id">
    <label>You feel stressed about:</label>
    <input type="checkbox" name="stress_facts[]" value="Sleep Problems"><span>Sleep Problems</span>
    <input type="checkbox" name="stress_facts[]" value="Fatigue"><span>Fatigue</span>
    <input type="checkbox" name="stress_facts[]" value="Muscle Aches"><span>Muscle Aches</span>
    <div class="anxious_blck">
        <label>What makes you anxious?</label>
    <textarea rows = "5" cols = "50" name = "anxious_facts">
         </textarea>
    </div>
    <input type="hidden" value="<?php echo date('d-m-y h:i:s');?>" name="created_at"/>
<input type="hidden" value="<?php echo date('d-m-y h:i:s');?>" name="updated_at"/>
<input type="submit" value="Submit" name="submit" class="listen_btn"/>
</form>
<?php if(isset($_POST['submit'])){?>
    <p class="stress_blockstmt">Your stress level today:</p>
<div class="meter cadetblue">
  <span data-progress="<?php echo count(json_decode($stress_facts));?>" style="width:0;"></span>
</div>
<?php } ?>
</div>
<script>
    var bars = document.querySelectorAll('.meter span');
console.clear();
setInterval(function(){
  bars.forEach(function(bar){
    var getWidth = parseFloat(bar.dataset.progress);
    
    for(var i = 0; i < getWidth; i++) {
      bar.style.width = i*10 + '%';
    }
  });
}, 500);
</script>
</body>
</html>