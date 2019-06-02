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

  // Test to see that all fields are in post array and if so, add the record to the database
  if( isset($_POST['exercise_id']) ) {

    echo 'test1';

    $exercise_id = $_POST['exercise_id'];

    // get current values from table to use as default values
    $stmtExercise = $db->prepare('SELECT exercise_name, discipline_id, modality_id, assignment, video_link, active
                                  FROM exercise
                                  WHERE exercise_id = :exercise_id');
    $stmtExercise->bindValue(':exercise_id', $exercise_id, PDO::PARAM_INT);
    $stmtExercise->execute();
    $rowExercise = $stmtExercise->fetch(PDO::FETCH_ASSOC);

    // sanitize the input and set all variables
    $exercise_name = ( isset($_POST['exercise_name'])        ? htmlspecialchars($_POST['exercise_name'])    : $rowExercise['exercise_name']);
    $discipline_id = ( isset($_POST['discipline_id'])        ? htmlspecialchars($_POST['discipline_id'])    : $rowExercise['discipline_id']);
    $modality_id   = ( isset($_POST['modality_id'])          ? htmlspecialchars($_POST['modality_id'])      : $rowExercise['modality_id']);
    $assignment    = ( isset($_POST['assignment'])           ? htmlspecialchars($_POST['assignment'])       : $rowExercise['assignment']);
    $video_link    = ( isset($_POST['video_link'])           ? htmlspecialchars($_POST['video_link'])       : $rowExercise['video_link']);
    $active = ( isset($_POST['active']) ? 't' : 'f' );

    // insert values into account table to create another user
    $stmtUpdate = $db->prepare('UPDATE exercise
                                SET exercise_name          = :exercise_name,
                                    discipline_id          = :discipline_id,
                                    modality_id            = :modality_id,
                                    assignment             = :assignment,
                                    video_link             = :video_link,
                                    active                 = :active
                                WHERE id = :exercise_id');
    $stmtUpdate->bindValue(':exercise_name', $exercise_name);
    $stmtUpdate->bindValue(':discipline_id', $discipline_id);
    $stmtUpdate->bindValue(':modality_id', $modality_id);
    $stmtUpdate->bindValue(':assignment', $assignment);
    $stmtUpdate->bindValue(':video_link', $video_link);
    $stmtUpdate->bindValue(':active', $active);
    $stmtUpdate->bindValue(':exercise_id', $exercise_id);
    $stmtUpdate->execute();

  }

  // go to dashboard page after updating a new user
  // header('Location: library.php');
  // die();

?>
<!DOCTYPE html>
<html>
<head>
  <title>HTP Update Exercise</title>
</head>
<body>

</body>
</html>