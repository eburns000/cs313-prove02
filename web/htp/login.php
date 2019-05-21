<?php

  session_start();

  try
  {
    $dbUrl = getenv('DATABASE_URL');

    $dbOpts = parse_url($dbUrl);

    $dbHost = $dbOpts["host"];
    $dbPort = $dbOpts["port"];
    $dbUser = $dbOpts["user"];
    $dbPassword = $dbOpts["pass"];
    $dbName = ltrim($dbOpts["path"],'/');

    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch (PDOException $ex)
  {
    echo 'Error!: ' . $ex->getMessage();
    die();
  }


  $message="";

  if(!empty($_POST["login"])) {

    $message = 'login post check';
    // $statement = $db->query('SELECT id, username, password FROM account WHERE username="' . $_POST['username'] . '" AND password="' . $_POST['password'] . '"');
    // $row = $statement->fetch(PDO::FETCH_ASSOC);
    // if(is_array($row)) {
    //   $_SESSION["user_id"] = $row["id"];
    //   $message = 'Login Successful';
    // } else {
    //   $message = "Invalid Username or Password!";
    // }
  }

  // if(!empty($_POST["logout"])) {
  //   $_SESSION["user_id"] = "";
  //   session_destroy();
  //   $message = 'Logout Successful';
  // }

?>

<!DOCTYPE html>
<html>
<head>
	<title>My Home Therapy Program</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
	<!-- Navigation -->
  <div class="container">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
      
      <!--Toggler/collapsible Button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>        
      </button>
      
      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="../htp/login.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../htp/assign.php">My Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../htp/assign.php">Exercise Library</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../htp/assign.php">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../htp/assign.php">Logout</a>
          </li>                                    
        </ul> 
      </div>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="container-fluid main">

    <!-- Clinic Data Entry -->  
    <h4>Login</h4>
    <br>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-checkout">

      <div class="error-message"><?php if(isset($message)) { echo $message; } ?></div>

      <!-- TODO: Depending upon type of user logging in will determine which dashboard it goes to -->

      <label for="username">Username</label><br>
      <input class="field-checkout" type="text" name="username"><br>

      <label for="password">Password</label><br>    
      <input class="field-checkout" type="text" name="password"><br>

      <input class="add-button" type="submit" value="Login" name="login">

    </form>
    <br>
    <p>For first time users, click to register below</p>
    <form action="register.php" method="post" class="form-submit">
        <input class="add-button" type="submit" value="Register">
    </form>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-submit">
        <input class="add-button" type="submit" value="Logout" name="logout">
    </form>    

  </div>

</body>
</html>



