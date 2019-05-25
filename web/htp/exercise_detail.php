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

  // get current account and exercise ids passed in
  $current_account_id_str = $_GET['account_id'];
  $current_account_id = intval($current_account_id_str);
  $current_exercise_id_str = $_GET['exercise_id'];
  $current_exercise_id = intval($current_exercise_id_str);

  // get an array of library data
  $statement = $db->query("SELECT e.exercise_name, d.discipline_name, m.modality_name, e.assignment, e.video_link,  
                              ae.assigned_date, ae.active, ae.point_value, 
                              ae.completed, ae.account_id, ae.exercise_id 
                              FROM assigned_exercise as ae 
                              JOIN exercise as e on e.id = ae.exercise_id 
                              JOIN modality as m on m.id = e.modality_id 
                              JOIN discipline as d on d.id = e.discipline_id 
                              WHERE ae.account_id = '$current_account_id' AND ae.exercise_id = '$current_exercise_id' ");

  $row = $statement->fetch(PDO::FETCH_ASSOC);

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
  <?php include 'nav.php'; ?>

  <!-- Main Content -->
  <div class="container-fluid main">

  <!-- Admin Dashboard: Show list of Users -->
  <h2>Exercise Detail</h2>
  <br>

  <table class="table-standard">
    <tr>
      <th>Exercise</th>
      <th>Discipline</th>
      <th>Modality</th>
      <th>Assignment</th>
      <th>Video</th>
      <th>Point Value</th>
      <th>Completed?</th>
      <th>Assigned</th>
      <th>Active</th>
    </tr>
  
  <?php 

    echo '<tr>';

    echo '<td>';
    echo $row['exercise_name'];
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

  ?>
  
  </table>

  <br>

  </div>
  
</body>
</html>



