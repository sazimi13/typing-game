<?php
session_start();
require "../config/config.php";
$mysqli = new mysqli(host, user, password, db);	
if ($mysqli->connect_errno) {
  echo $mysqli->connect_error;
  exit();	
}
$username = $_SESSION["username"];
// Delete an account
if (isset($_POST['delete'])) {
  $sql = "DELETE FROM stats WHERE username='$username'";
  $result = $mysqli->query($sql);    
  $sql2 = "DELETE FROM login WHERE username='$username'";
  $result = $mysqli->query($sql2);
  header("location: login.php");
}
$sql = "SELECT first_name, last_name, occupation, keyboard, region, wpm_goal, school FROM login WHERE username='$username'";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $first_name_prev = $row["first_name"];
    $last_name_prev = $row["last_name"];
    $occupation_prev = $row["occupation"];
    $keyboard_prev = $row["keyboard"];
    $region_prev = $row["region"];
    $wpm_goal_prev = $row["wpm_goal"];
    $school_pre = $row["school"];
  }
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])){
  if(empty(trim($_POST["first_name"])) === false){
    $first_name = trim($_POST["first_name"]);
  }
  else {
    $first_name = $first_name_prev;
  }
  if(empty(trim($_POST["last_name"])) === false) {
  $last_name = trim($_POST["last_name"]);
  }
  else {
  $last_name = $last_name_prev;
  }
  if (empty(trim($_POST["occupation"])) === false){
  $occupation = trim($_POST["occupation"]);
  }
  else {
    $occupation = $occupation_prev;
  }
  if (empty(trim($_POST["keyboard"])) === false){
    $keyboard = trim($_POST["keyboard"]);
  }
  else {
    $keyboard = $keyboard_prev;
  }
  if (empty(trim($_POST["region"])) === false){
    $region = trim($_POST["region"]);
  }
  else {
    $region = $region_prev;
  }
  if (empty(trim($_POST["school"])) === false){
    $school = trim($_POST["school"]);
  }
  else {
    $school = $school_prev;
  }
  if (empty(trim($_POST["wpm_goal"])) === false){
    $wpm_goal = trim($_POST["wpm_goal"]);
  }
  else {
    $wpm_goal = $wpm_goal_prev;
  }

$login_arr = array();
$sql = "UPDATE login SET first_name='$first_name', last_name='$last_name', occupation='$occupation', keyboard='$keyboard', region = '$region', wpm_goal = '$wpm_goal', school = '$school' WHERE username=?";
$stmt = $mysqli->prepare($sql); 
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
header("location: profile.php");
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
    <link rel="stylesheet" href="../css/edit_profile.css">
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
          <form action="edit_profile.php" method="POST">
          <div class="card-body pt-0">
            <table class="table table-bordered">
              <tr>
                <th>First Name</th>
                <td class="colon">:</td>
                <td class="edit">
                  <input name="first_name"></td>
              </tr>
              <tr>
                <th>Last Name</th>
                <td class="colon">:</td>
                <td class="edit">
                  <input name="last_name" type="text"></td>
              </tr>
              <tr>
                <th>Occupation</th>
                <td class="colon">:</td>
                <td class="edit">
                  <input name="occupation" type="text"></td>
              </tr>
              <tr>
                <th>Region</th>
                <td class="colon">:</td>
                <td class="edit">
                  <input name="region" type="text"></td>
              </tr>
              <tr>
                <th>Keyboard</th>
                <td class="colon">:</td>
                <td class="edit">
                  <input name="keyboard" type="text"></td>
              </tr>
              <th>WPM Goal</th>
                <td class="colon">:</td>
                <td class="edit">
                  <input name="wpm_goal" type="text"></td>
              </tr>
              <th>School</th>
                <td class="colon">:</td>
                <td class="edit">
                  <input name="school" type="text"></td>
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
      <input id="btn" name="edit" type="submit" class="btn btn-secondary btn-lg btn-block mt-4 mt-md-2" formmethod="POST" formaction="edit_profile.php" value="Save Changes">
      <input id="btn" name="delete" type="submit" class="btn btn-secondary btn-lg btn-block mt-4 mt-md-2" formmethod="POST" formaction="edit_profile.php" value="Delete Account">
			</div> 
		</div> 
</form>
	</div>
</body>
</html>