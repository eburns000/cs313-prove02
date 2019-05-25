<?php

    session_start();

    // depending upon which account type or if it is a new account, will depend upon which php file is included
    // the dashboard or a message that user account has not yet been verified, to please wait, will show

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

  if(!empty($_POST["logout"])) {
    $_SESSION["user_id"] = "";
    $_SESSION["account_type_id"] = "";
    $_SESSION["new_account"] = NULL;
    session_destroy();
    header("Location:login.php");
  }

  echo '<br><br><br><br><br><br>';

  echo 'test1';
  // get current user id passed in from admin dashboard
  $current_user_id_str = $_GET['row_id'];

  echo 'test2' . $current_user_id_str;
  $current_user_id = intval($current_user_id_str);


  echo 'test3' . $current_user_id;
  // get an array of current user data
  $statement = $db->query(' SELECT a.id as user_id, c.clinic_name as clinic, at.account_type_name as account_type, 
                                   a.assigned_therapist_id as assigned_therapist, a.first_name as first, a.last_name as last,
                                   a.phone as phone, a.active as active, a.new_account as new, a.locked as locked
                            FROM account as a
                            JOIN clinic as c on c.id = a.assigned_clinic_id
                            JOIN account_type as at on at.id = a.account_type_id 
                            WHERE a.id = $current_user_id ');

  echo 'test4';
  $row = $statement->fetch(PDO::FETCH_ASSOC);

  echo 'test5';

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
            <form id="logout_form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
              <input type="hidden" name="logout" value="Logout">
              <a class="nav-link" href="#" onclick="logoutsession(); return false;">Logout</a>
            </form>
          </li>                                    
        </ul> 
      </div>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="container-fluid main">

  <!-- Admin Dashboard: Show list of Users -->
  <h2>User Information</h2>
  <br>

  <table>
    <tr>
      <th>User ID</th>
      <th>Assigned Clinic</th>
      <th>Account Type</th>
      <th>Assigned Therapist</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Phone</th>
      <th>Active?</th>
      <th>New Account?</th>
      <th>Locked?</th>
    </tr>
  
  <?php 

    echo $row['user_id'];

  ?>
  
  </table>

  <br>

  </div>
  
</body>
</html>



