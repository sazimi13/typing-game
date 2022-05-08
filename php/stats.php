<?php
session_start();
require "../config/config.php";
$mysqli = new mysqli(host, user, password, db);	
if ($mysqli->connect_errno) {
  echo $mysqli->connect_error;
  exit();	
}
$username = $_SESSION["username"];	
$sql = "SELECT rank, races, avg_wpm, lowest_wpm, lowest_acc, fastest_time, wpm_pr FROM stats WHERE username='$username'";
$result = $mysqli->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
  			$prev_rank = $row["rank"];
  			$races_prev = $row["races"];
  			$avg_wpm_prev = $row["avg_wpm"];
  			$lowest_wpm_prev = $row["lowest_wpm"];
  			$lowest_acc_prev = $row["lowest_acc"];
  			$fastest_time_prev = $row["fastest_time"];
  			$wpm_pr_prev = $row["wpm_pr"];
  }
}
?>
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
  <div id="head">
		<div class="row">
			<h1 class="col-12 mt-6">View Your Stats</h1>
		</div> 
	</div> 
	<div id="info">
		<div class="row mt-4">
			<div class="col-12">
					<table class="table table-responsive">
						<tr>
							<th class="text-left">Rank:</th>
							<td><?php echo $prev_rank ?></td>
						</tr>
						<tr>
							<th class="text-left">Average WPM:</th>
							<td><?php echo $avg_wpm_prev ?></td>
						</tr>
						<tr>
							<th class="text-left">Fastest Time (seconds):</th>
							<td><?php echo $fastest_time_prev ?></td>
						</tr>
						<tr>
							<th class="text-left">Most Letters Missed:</th>
							<td><?php echo $lowest_acc_prev ?></td>
						</tr>
						<tr>
							<th class="text-left">All Time WPM Low:</th>
							<td><?php echo $lowest_wpm_prev ?></td>
						</tr>
						<tr>
							<th class="text-left">All Time Best WPM:</th>
							<td><?php echo $wpm_pr_prev ?></td>
						</tr>
						<tr>
							<th class="text-left">Races Completed:</th>
							<td><?php echo $races_prev ?></td>
						</tr>
						<tr>
							<th class="text-left">Your Charts:</th>
							<td>
							<a id ="butt" href="charts.php" class="btn btn-dark">View Your Charts</a>
							</td>
						</tr>
					</table>
			</div> 
		</div>
	</div>
</body>
</html>