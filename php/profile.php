<?php
session_start();
require "../config/config.php";
$mysqli = new mysqli(host, user, password, db);	
if ($mysqli->connect_errno) {
  echo $mysqli->connect_error;
  exit();	
}
$username = $_SESSION["username"];
$sql = "SELECT first_name, last_name, occupation, keyboard, region, wpm_goal, school FROM login WHERE username='$username'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $first_name = $row["first_name"];
    $last_name = $row["last_name"];
    $occupation = $row["occupation"];
    $keyboard = $row["keyboard"];
    $region = $row["region"];
    $school = $row["school"];
    $wpm_goal = $row["wpm_goal"];
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
    <link rel="stylesheet" href="../css/profile.css">
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
          <a class="nav-link active" href="stats.php">View Stats</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container">
    <div class="row mt-4 mb-4">
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0">View Your Profile</h3>
          </div>
          <div class="card-body pt-0">
            <table class="table table-bordered">
              <tr>
                <th>First Name</th>
                <td class="colon">:</td>
                <td> <?php echo $first_name ?> </td>
              </tr>
              <tr>
                <th>Last Name</th>
                <td class="colon">:</td>
                <td> <?php echo $last_name ?> </td>
              </tr>
              <tr>
                <th>Occupation</th>
                <td class="colon">:</td>
                <td> <?php echo $occupation ?> </td>
              </tr>
              <tr>
                <th>Region</th>
                <td class="colon">:</td>
                <td> <?php echo $region ?> </td>
              </tr>
              <tr>
                <th>Keyboard</th>
                <td class="colon">:</td>
                <td> <?php echo $keyboard ?> </td>
              </tr>
              <tr>
                <th>WPM Goal</th>
                <td class="colon">:</td>
                <td> <?php echo $wpm_goal ?> </td>
              </tr>
              <tr>
                <th>School</th>
                <td class="colon">:</td>
                <td> <?php echo $school ?> </td>
              </tr>
            </table>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
		<div class="row mt-4 mb-4">
			<div class="col-lg-8">
				<a id ="butt" href="edit_profile.php" class="btn btn-dark">Edit Your Profile</a>
			</div> 
		</div> 
	</div>
</body>
</html>