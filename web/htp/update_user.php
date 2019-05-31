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
    $stmtCurrent = $db->prepare('SELECT (username, email, first_name, last_name, phone, clinic_id, account_type_id, 
                                         assigned_therapist_id, active, new_account, locked) 
                                 FROM account
                                 WHERE id = :user_id');
    $stmtCurrent->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmtCurrent->execute();
    $rowCurrent = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

    // sanitize the input and set all variables
    $username   = ( isset($_POST['username']) )                         ? htmlspecialchars($_POST['username'])              : $rowCurrent['username'];
    $email      = ( isset($_POST['email']) )                            ? htmlspecialchars($_POST['email'])                 : $rowCurrent['email'];
    $first_name = ( isset($_POST['first_name']) )                       ? htmlspecialchars($_POST['first_name'])            : $rowCurrent['first_name'];
    $last_name  = ( isset($_POST['last_name']) )                        ? htmlspecialchars($_POST['last_name'])             : $rowCurrent['last_name'];
    $phone      = ( isset($_POST['phone']) )                            ? htmlspecialchars($_POST['phone'])                 : $rowCurrent['phone'];

    $clinic_id             = ( isset($_POST['clinic_id']) )             ? htmlspecialchars($_POST['clinic_id'])             : $rowCurrent['clinic_id'];
    $account_type_id       = ( isset($_POST['account_type_id']) )       ? htmlspecialchars($_POST['account_type_id'])       : $rowCurrent['account_type_id'];
    $assigned_therapist_id = ( isset($_POST['assigned_therapist_id']) ) ? htmlspecialchars($_POST['assigned_therapist_id']) : $rowCurrent['assigned_therapist_id'];

    $active = ( isset($_POST['active']) )         ? 1 : $rowCurrent['active'];
    $new    = ( isset($_POST['new_account']) )    ? 1 : $rowCurrent['new_account'];
    $locked = ( isset($_POST['locked']) )         ? 1 : $rowCurrent['locked'];

    // insert values into account table to create another user
    $stmt = $db->prepare('INSERT INTO account (username, email, first_name, last_name, phone, clinic_id, account_type_id, 
                                               assigned_therapist_id, active, new_account, locked) 
                          VALUES (:username, :email, :first_name, :last_name, :phone, :clinic_id, :account_type_id, 
                                  :assigned_therapist_id, :active, :new_account, :locked)');
    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindValue(':clinic_id', $clinic_id, PDO::PARAM_INT);
    $stmt->bindValue(':account_type_id', $account_type_id, PDO::PARAM_INT);
    $stmt->bindValue(':assigned_therapist_id', $assigned_therapist_id, PDO::PARAM_INT);
    $stmt->bindValue(':active', $active, PDO::PARAM_BOOL);
    $stmt->bindValue(':new_account', $new, PDO::PARAM_BOOL);
    $stmt->bindValue(':locked', $locked, PDO::PARAM_BOOL);
    $stmt->execute();

  }

  // go to dashboard page after updating a new user
  header('Location: dashboard.php');
  die();

?>

