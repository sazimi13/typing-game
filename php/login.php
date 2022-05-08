<?php
  session_start();
	require "../config/config.php";
  $mysqli = new mysqli(host, user, password, db);	
  if ($mysqli->connect_errno) {
    echo $mysqli->connect_error;
    exit();	
  }
  $login_arr = array();
  $blank = "";
  $blank2 = 0;
  $i = 0;
  $rank = "Grandma";
  $username = $password = "";
  $username_err = $password_err = $login_err = "";
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
    if(empty($username_err) && empty($password_err)){
      // Prepare a select statement
      $sql = "SELECT username, password FROM login WHERE username = ?";
      $stmt = $mysqli->prepare($sql); 
      $stmt->bind_param("s", $username);
      $stmt->execute();
      $result = $stmt->get_result(); // get the mysqli result
      //$user = $result->fetch_assoc(); // fetch data
      while ($row = mysqli_fetch_assoc($result)) { 
        foreach ($row as $value) { 
          $login_arr[$i] = $value;
          $i++;
        }
      }
      if (count($login_arr) == 0) {
        $sql = "INSERT INTO login (username, password, first_name, last_name, occupation, region, keyboard, wpm_goal, school) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        if($stmt = mysqli_prepare($mysqli, $sql)){
          //Bind variables to the prepared statement as parameters
          mysqli_stmt_bind_param($stmt, "sssssssis", $username, $password, $blank, $blank, $blank, $blank, $blank, $blank2, $blank);
          if(mysqli_stmt_execute($stmt)){
            // Redirect to login page
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
          }
        }
        $sql2 = "INSERT INTO stats (username, rank, races, avg_wpm, lowest_wpm, lowest_acc, fastest_time, wpm_pr, wpm_total) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
          if($stmt2 = mysqli_prepare($mysqli, $sql2)){
            mysqli_stmt_bind_param($stmt2, "ssididdid", $username, $rank, $blank2, $blank2, $blank2, $blank2, $blank2, $blank2, $blank2);
              if(mysqli_stmt_execute($stmt2)){
                header("location: race.php");
            }
          }
        } 
      else if ($login_arr[0] == $username && $login_arr[1] == $password) {
        session_start();                
        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $id;
        $_SESSION["username"] = $username;                            
        // Redirect user to welcome page
        header("location: race.php");
      }
      else if ($login_arr[0] == $username && $login_arr[1] != $password) {
         $wrong_pw = "Wrong Password";
         echo "<script>alert('$wrong_pw')</script>";
      }        
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
    <link rel="stylesheet" href="../css/login.css">
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
    <div class="collapse navbar-collapse"></div>
  </div>
</nav>
    <div class="full-screen-container">
        <div class="login-container">
          <h3 class="login-title">Log In</h3>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">            
          <div class="input-group">
              <label>Username</label>
              <input name="username">
            </div>
            <div class="input-group">
              <label>Password</label>
              <input type="password" name="password">
            </div>
            <input type="submit" class="btn btn-secondary btn-lg btn-block mt-4 mt-md-2" value="login">
          </form>
        </div>
      </div>
  </div>
</div>
</div>
	<script src="../js/login.js"></script>
  </body>
</html>
