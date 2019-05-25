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

  // get client id passed in from therapist dashboard
  $current_client_id_str = $_GET['client_id'];
  $current_client_id = intval($current_exercise_id_str);  

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
            <a class="nav-link" href="../htp/library.php">Exercise Library</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../htp/dashboard.php">Dashboard</a>
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

  <!-- Client Exercises -->
  <?php 

    $login_user_id = $_SESSION['user_id'];

    echo '<!-- Therapist View of Client Exercises -->';
    echo '<h2>My Clients Exercises</h2>';
    echo '<br>';

    echo '<table>';
    echo '<tr>';
    echo '<th>Exercise</th>';
    echo '<th>Discipline</th>';
    echo '<th>Modality</th>';
    echo '<th>Assignment</th>';
    echo '<th>Video</th>';
    echo '<th>Point Value</th>';
    echo '<th>Completed?</th>';
    echo '<th>Assigned</th>';
    echo '<th>Active</th>';
    echo '</tr>';


    foreach ($db->query("SELECT e.exercise_name, d.discipline_name, m.modality_name, e.assignment, e.video_link,  
                                ae.assigned_date, ae.active, ae.point_value, 
                                ae.completed, ae.account_id, ae.exercise_id 
                                FROM assigned_exercise as ae 
                                JOIN exercise as e on e.id = ae.exercise_id 
                                JOIN modality as m on m.id = e.modality_id 
                                JOIN discipline as d on d.id = e.discipline_id 
                                WHERE ae.account_id = '$current_client_id' ") as $row)
    {
      $acct_id = $row['account_id'];
      $exer_id = $row['exercise_id'];

      echo '<tr>';

      echo '<td>';      
      echo '<a href="exercise_detail.php?account_id=' . $acct_id . '&exercise_id=' . $exer_id . '">';
      echo $row['exercise_name'];      
      echo '</a>';
      echo '</td>';

      echo '<td>';
      echo $row['discipline_name'];
      echo '</td>';

      echo '<td>';
      echo $row['modality_name'];
      echo '</td>'; 

      echo '<td>';
      echo $row['assignment'];
      echo '</td>';

      echo '<td>';
      echo $row['video_link'];
      echo '</td>';  

      echo '<td>';
      echo $row['point_value'];
      echo '</td>';  

      echo '<td>';
      echo ($row['completed'] == '1' ? 'True' : 'False');
      echo '</td>';   

      echo '<td>';
      echo $row['assigned_date'];
      echo '</td>';  

      echo '<td>';
      echo ($row['active'] == '1' ? 'True' : 'False');
      echo '</td>';                          

      echo '</tr>';

    }

    echo '</table>';
    echo '<br>';

  ?>

  </div>
  
</body>
</html>













