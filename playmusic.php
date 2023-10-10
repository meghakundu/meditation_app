<?php session_start();
 //error_reporting(E_ERROR | E_PARSE);
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

.time-select,
.sound-picker {
  height: 80%;
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  flex-direction: column;
  flex: 1;
}
.time-select button,
.sound-picker button {
  color: white;
  width: 30%;
  height: 10%;
  background: none;
  font-size: 40px;
  cursor: pointer;
  border:0;
  transition: all 0.5s ease;
}

.sound-picker button {
  border: none;
  height: 120px;
  width: 120px;
  padding: 30px;
}
.sound-picker button:nth-child(1) {
  background: #4972a1;
}
.sound-picker button:nth-child(2) {
  background: #a14f49;
}
.sound-picker button img {
  height: 100%;
}

.time-select button:hover {
  background: transparent;
  color: black;
}

.player-container {
  position: relative;
  height: 80%;
  display: flex;
  justify-content: space-evenly;
  align-items: center;
  flex-direction: column;
  flex: 1;
}

.player-container svg {
  position: absolute;
  height: 50%;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(-90deg);
  pointer-events: none;
}
/* .player-container svg circle {
  transition: all 0.2s ease-in-out;
} */
.timer-statement{
    margin: 0;
    position: absolute;
    top: 42%;
    font-size: 30px;
    color: white;
}
.time-display {
    color: white;
    font-size: 40px;
}
.app audio{
    float:left;
    width:100%;
}
video {
  position: fixed;
  top: 0%;
  left: 0%;
  width: 100%;
  z-index: -10;
}
.back-btn{
    position: absolute;
    top: 3%;
    left: 4%;
}
.logout_btn{
  position: absolute;
    right: 10%;
    top: 3%;
    font-size: 20px;
    color: white;
    text-decoration: none;

}

        </style>
</head>
    <body>
<?php if(isset($_POST['submit'])){
    $timer_sec = ($_POST['timer'])*60;?>
 <div class="app">
 <a href="/meditating.php" class="back-btn"><img src="./images/icon.png"></img></a>
        <div class="time-select">
          <button data-time="<?php echo $timer_sec; ?>"><?php echo $_POST['timer']; ?>mins</button>
          <!-- <button data-time="300" class="medium-mins">5 Minutes</button>
          <button data-time="600" class="long-mins">10 Minutes</button> -->
        </div>
        <div class="player-container">
            <audio class="song" controls id="myAudio">
                <source src="./sounds/rain.mp3" class="play"/>
              </audio>
              <!-- <img src="./svg/play.svg" class="play"></img>
              <svg class="track-outline" width="453" height="453" viewBox="0 0 453 453" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="226.5" cy="226.5" r="216.5" stroke="white" stroke-width="20"/>
                </svg>
              <svg class="moving-outline" width="453" height="453" viewBox="0 0 453 453" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="226.5" cy="226.5" r="216.5" stroke="#018EBA" stroke-width="20"/>
                </svg> -->
              
            
           <p class="timer-statement"> Timer: <span class="time-display">0:00</span>  </p>   
      </div>
      <div class="sound-picker">
        <button data-sound="./sounds/rain.mp3" data-video="./video/rain.mp4" ><img src="./svg/rain.svg" alt=""></button>
        <button data-sound="./sounds/beach.mp3" data-video="./video/beach.mp4"><img src="./svg/beach.svg" alt=""></button>
      </div>
    </div>
    <?php 
   // if(!empty($_SESSION["login_id"]))
    // {?>
   
    <?php 
     } else{?>
     <div class="app">
 <a href="/meditating.php" class="back-btn"><img src="./images/icon.png"></img></a>
        <div class="player-container" style="margin-left:30px;">
            <audio class="song" controls id="myAudio">
                <source src="./sounds/rain.mp3" class="play"/>
              </audio>
           <p class="timer-statement"> Timer: <span class="time-display">0:00</span>  </p>   
      </div>
      <div class="sound-picker">
        <button data-sound="./sounds/rain.mp3" data-video="./video/rain.mp4" ><img src="./svg/rain.svg" alt=""></button>
        <button data-sound="./sounds/beach.mp3" data-video="./video/beach.mp4"><img src="./svg/beach.svg" alt=""></button>
      </div>
    </div>
    <a href="logout.php" class="logout_btn">Logout</a>
     <?php }?>
    <script>
const song = document.querySelector(".song");
const play = document.querySelector(".play");
//const replay = document.querySelector(".replay");
//const outline = document.querySelector(".moving-outline circle");
const video = document.querySelector(".vid-container video");
//Sounds
const sounds = document.querySelectorAll(".sound-picker button");
//Time Display
const timeDisplay = document.querySelector(".time-display");
const outlineLength = document.getElementById("myAudio").duration;
//Duration
const timeSelect = document.querySelectorAll(".time-select button");
let fakeDuration = 600;

// outline.style.strokeDashoffset = outlineLength;
// outline.style.strokeDasharray = outlineLength;
timeDisplay.textContent = `${Math.floor(fakeDuration / 60)}:${Math.floor(
  fakeDuration % 60
)}`;

sounds.forEach(sound => {
  sound.addEventListener("click", function() {
    song.src = this.getAttribute("data-sound");
    video.src = this.getAttribute("data-video");
    checkPlaying(song);
  });
});

play.addEventListener("click", function() {
  checkPlaying(song);
});

// replay.addEventListener("click", function() {
//     restartSong(song);
    
//   });


// const restartSong = song =>{
//     let currentTime = song.currentTime;
//     song.currentTime = 0;
//     console.log("ciao");
// }

timeSelect.forEach(option => {
  option.addEventListener("click", function() {
    fakeDuration = this.getAttribute("data-time");
    timeDisplay.textContent = `${Math.floor(fakeDuration / 60)}:${Math.floor(
      fakeDuration % 60
    )}`;
  });
});

const checkPlaying = song => {
  if (song.paused) {
    song.play();
    video.play();
    play.src = "./svg/pause.svg";
  } else {
    song.pause();
    video.pause();
    play.src = "./svg/play.svg";
  }
};

song.ontimeupdate = function() {
  let currentTime = song.currentTime;
  let elapsed = fakeDuration - currentTime;
  let seconds = Math.floor(elapsed % 60);
  let minutes = Math.floor(elapsed / 60);
  timeDisplay.textContent = `${minutes}:${seconds}`;
  let progress = outlineLength - (currentTime / fakeDuration) * outlineLength;
  //outline.style.strokeDashoffset = progress;

  if (currentTime >= fakeDuration) {
    song.pause();
    song.currentTime = 0;
    play.src = "./svg/play.svg";
    video.pause();
  }
};
    </script>
</body>
</html>