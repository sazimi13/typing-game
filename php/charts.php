<?php
session_start();
require "../config/config.php";
$mysqli = new mysqli(host, user, password, db);	
if ($mysqli->connect_errno) {
  echo $mysqli->connect_error;
  exit();	
}
$average_arr = array();
$i = 0;
$username = $_SESSION["username"];	
$sql = "SELECT avg_wpm FROM stats WHERE username='$username'";
$result = $mysqli->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
  			$avg_wpm_prev = $row["avg_wpm"];
  }
}
$sql = "SELECT avg_wpm FROM stats";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $average_arr[$i] = $row["avg_wpm"];
    $i++;
  }
}
$avg_wpm_prev = floatval($avg_wpm_prev);
$site_avg = array_sum($average_arr) / count($average_arr);
$site_avg = $site_avg;
$dataPoints = array( 
	array("y" => $avg_wpm_prev,"label" => "Your Average" ),
	array("y" => $site_avg,"label" => "Site Average" ),
);
 
?>
<!DOCTYPE HTML>
<html>
<head>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/stats.css">
    <title> TypeIt Login </title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
  <div class="container">
    <a class="navbar-brand" href="login.php">
      <a id="test" class="nav-link" aria-current="page" href="login.php">TypeIt</a>
    </a>
    <button class="navbar-toggler" type="button">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="race.php">Take Typing Test</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="profile.php">View Profile</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</body>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Your Average WPM vs Site Average WPM"
	},
	axisY: {
		title: "Words Per Minute",
		includeZero: true,
	},
	data: [{
		type: "bar",
		indexLabel: "{y}",
		indexLabelPlacement: "inside",
		indexLabelFontWeight: "bolder",
		indexLabelFontColor: "white",
		dataPoints: <?php echo json_encode($dataPoints); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>