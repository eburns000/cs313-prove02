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
  if( isset($_POST['id']) ) {

    $user_id = $_POST['id'];

    // get current values from table to use as default values
    $stmtCurrent = $db->prepare('SELECT username, password, email, first_name, last_name, phone
                                 FROM account
                                 WHERE id = :user_id');
    $stmtCurrent->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmtCurrent->execute();
    $rowCurrent = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

    // sanitize the input and set all variables
    $username   = ( isset($_POST['username'])                           ? htmlspecialchars($_POST['username'])              : $rowCurrent['username']);
    $password   = ( isset($_POST['password'])                           ? htmlspecialchars($_POST['password'])              : $rowCurrent['password']);
    $email      = ( isset($_POST['email'])                              ? htmlspecialchars($_POST['email'])                 : $rowCurrent['email']);
    $first_name = ( isset($_POST['first_name'])                         ? htmlspecialchars($_POST['first_name'])            : $rowCurrent['first_name']);
    $last_name  = ( isset($_POST['last_name'])                          ? htmlspecialchars($_POST['last_name'])             : $rowCurrent['last_name']);
    $phone      = ( isset($_POST['phone'])                              ? htmlspecialchars($_POST['phone'])                 : $rowCurrent['phone']);

    // insert values into account table to create another user
    $stmtUpdate = $db->prepare('UPDATE account
                                SET username              = :username,
                                    email                 = :email,
                                    first_name            = :first_name,
                                    last_name             = :last_name,
                                    phone                 = :phone,
                                    password              = :password
                                WHERE id = :user_id');
    $stmtUpdate->bindValue(':username', $username);
    $stmtUpdate->bindValue(':email', $email);
    $stmtUpdate->bindValue(':first_name', $first_name);
    $stmtUpdate->bindValue(':last_name', $last_name);
    $stmtUpdate->bindValue(':phone', $phone);
    $stmtUpdate->bindValue(':password', $password);
    $stmtUpdate->bindValue(':user_id', $user_id);
    $stmtUpdate->execute();

  }

  // go to dashboard page after updating a new user
  header('Location: dashboard.php');
  die();

?>
<!DOCTYPE html>
<html>
<head>
  <title>HTP Update Profile</title>
</head>
<body>

</body>
</html>