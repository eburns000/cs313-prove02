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

  echo '<h1>Success!</h1>';
  // // Test to see that all fields are in post array and if so, add the record to the database
  // if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) &&
  //    isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['phone'])) {

  //   // sanitize the input
  //   $username = htmlspecialchars($_POST['username']);
  //   $password = htmlspecialchars($_POST['password']);
  //   $email = htmlspecialchars($_POST['email']);
  //   $first_name = htmlspecialchars($_POST['first_name']);
  //   $last_name = htmlspecialchars($_POST['last_name']);
  //   $phone = htmlspecialchars($_POST['phone']);

  //   // insert values into account table to create another user
  //   $stmt = $db->prepare('INSERT INTO account (username, password, email, first_name, last_name, phone) 
  //                         VALUES (:username, :password, :email, :first_name, :last_name, :phone)');
  //   $stmt->bindValue(':username', $username, PDO::PARAM_STR);
  //   $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  //   $stmt->bindValue(':email', $email, PDO::PARAM_STR);
  //   $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
  //   $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
  //   $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
  //   $stmt->execute();

  // }

  // // go to login page after registing a new user
  // header('Location: login.php');
  // die();

?>

