<?php
session_start();
require "../config/config.php";
$mysqli = new mysqli(host, user, password, db);	
if ($mysqli->connect_errno) {
  echo $mysqli->connect_error;
  exit();	
}
$username = $_SESSION["username"];
$races_prev;
$avg_wpm_prev;
$lowest_wpm_prev;
$wpm_pr_prev;
$fastest_time_prev;
$prev_rank;
$lowest_acc_prev;
$wpm_total_prev;

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $sql = "SELECT rank, races, avg_wpm, lowest_wpm, lowest_acc, fastest_time, wpm_pr, wpm_total FROM stats WHERE username='$username'";
  $result = $mysqli->query($sql);
  if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $prev_rank = $row["rank"];
    $races_prev = $row["races"];
    $avg_wpm_prev = $row["avg_wpm"];
    $lowest_wpm_prev = $row["lowest_wpm"];
    $lowest_acc_prev = $row["lowest_acc"];
    $fastest_time_prev = $row["fastest_time"];
    $wpm_pr_prev = $row["wpm_pr"];
    $wpm_total_prev = $row["wpm_total"];
    }
  }
    $wpm = $_POST['wpm'];
    $wpm = floatval(ltrim($wpm, 'wpm = '));
    $wpm_total = $wpm + $wpm_total_prev;
    $time = $_POST['time'];
    $time = floatval(ltrim($time, 'time to finish = '));
    $lm = $_POST['lm'];
    $lm = intval(ltrim($lm, 'letters missed = '));
    // Get Race Count
    $race_count = $races_prev + 1;
    // Get AVG WPM
    $avg_wpm = $wpm_total / $race_count;
  
    // Get LOW WPM
    if ($lowest_wpm_prev == 0) {
      $lowest_wpm = $wpm;
    }
    else if (($wpm < $lowest_wpm_prev) && ($lowest_wpm_prev != 0)) {
      $lowest_wpm = $wpm;
    }
    else if (($wpm > $lowest_wpm_prev) && ($lowest_wpm_prev != 0)) {
      $lowest_wpm = $lowest_wpm_prev;
    }
    if ($lm > $lowest_acc_prev) {
      $lowest_acc = $lm;
    }
    else {
      $lowest_acc = $lowest_acc_prev;
    }
    // GET BEST WPM
    if ($wpm > $wpm_pr_prev) {
      $wpm_pr = $wpm;
    }
    else {
      $wpm_pr = $wpm_pr_prev;

    }
    // GET BEST time
    if ($fastest_time_prev == 0) {
      $fastest_time = $time;
    }
    else if (($time < $fastest_time_prev) && ($fastest_time_prev != 0)) {
      $fastest_time = $time;
    }
    else if (($time > $fastest_time_prev) && ($fastest_time_prev != 0)) {
      $fastest_time = $fastest_time_prev;
    }
    // Get Rank
    if ($avg_wpm < 40) {
      $rank = "Grandma";
    }
    else if ($avg_wpm >= 40 && $avg_wpm < 60) {
      $rank = "Noob";
    }
    else if ($avg_wpm >= 60 && $avg_wpm < 80) {
      $rank = "Intermediate";
    }
    else if ($avg_wpm >= 80 && $avg_wpm < 100) {
      $rank = "Advanced";
    }
    else if ($avg_wpm >= 100 && $avg_wpm < 110) {
      $rank = "Expert";
    }
    else if ($avg_wpm >= 110) {
      $rank = "God";
    }
$sql = "UPDATE stats SET 
rank='$rank', 
races='$race_count', 
avg_wpm='$avg_wpm', 
lowest_wpm='$lowest_wpm', 
lowest_acc = '$lowest_acc',
fastest_time = '$fastest_time',
wpm_pr = '$wpm_pr',
wpm_total = '$wpm_total'
WHERE username=?";
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/race.css">
    <title> TypeIt Game </title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
  <div class="container">
    <a class="navbar-brand" href="login.php">
      <a id="test" class="nav-link" href="login.php">TypeIt</a>
    </a>
    <button class="navbar-toggler" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="profile.php">View Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="stats.php">View Stats</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
    <div id="all">
      <form onsubmit="prepareDiv()">
      <div name="wpm" id="wpm"></div>
      <div name="wm" id="wm"></div>
      <div name="time" id="time"></div>
      <div id="typing1"></div><div id="typing"></div>
      <input id="words_per" type="hidden" name="wpm">
      <input id="time_taken" type="hidden" name="time">
      <input id="letters_missed" type="hidden" name="lm">
      <input id="save" type="submit" class="btn btn-secondary btn-lg btn-block mt-4 mt-md-2" formmethod="POST" formaction="race.php" value="Save Score">
      </form>
    </div>
    <button id="start-game"> Start New Game</button>
</div>
    <script
    src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
    crossorigin="anonymous"></script>
    <script src="../js/race.js"></script>
    <script>
      document.querySelector("#start-game").onclick=startGame;
    </script>
    <script>
    function prepareDiv() {
    document.getElementById("words_per").value = document.getElementById("wpm").innerHTML;
    document.getElementById("time_taken").value = document.getElementById("time").innerHTML;
    document.getElementById("letters_missed").value = document.getElementById("wm").innerHTML;


    }
    </script>
    

  </body>
</html>