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

  echo '<p>1</p>';

  // Test to see that all fields are in post array and if so, add the record to the database
  if( isset($_POST['id']) ) {

    echo '<p>2</p>';

    $user_id = $_POST['id'];

    echo '<p>3</p>';

    // get current values from table to use as default values
    $stmtCurrent = $db->prepare('SELECT username, email, first_name, last_name, phone, assigned_clinic_id, account_type_id, 
                                         assigned_therapist_id, active, new_account, locked 
                                 FROM account
                                 WHERE id = :user_id');

    echo '<p>3a</p>';

    $stmtCurrent->bindValue(':user_id', $user_id, PDO::PARAM_INT);

    echo '<p>3b</p>';

    $stmtCurrent->execute();

    echo '<p>3c</p>';

    $rowCurrent = $stmtCurrent->fetch(PDO::FETCH_ASSOC);

    echo '<p>4</p>';

    // sanitize the input and set all variables
    $username   = ( isset($_POST['username']) )                         ? htmlspecialchars($_POST['username'])              : $rowCurrent['username'];
    $email      = ( isset($_POST['email']) )                            ? htmlspecialchars($_POST['email'])                 : $rowCurrent['email'];
    $first_name = ( isset($_POST['first_name']) )                       ? htmlspecialchars($_POST['first_name'])            : $rowCurrent['first_name'];
    $last_name  = ( isset($_POST['last_name']) )                        ? htmlspecialchars($_POST['last_name'])             : $rowCurrent['last_name'];
    $phone      = ( isset($_POST['phone']) )                            ? htmlspecialchars($_POST['phone'])                 : $rowCurrent['phone'];

    $clinic_id             = ( isset($_POST['clinic_id']) )             ? htmlspecialchars($_POST['clinic_id'])             : $rowCurrent['assigned_clinic_id'];
    $account_type_id       = ( isset($_POST['account_type_id']) )       ? htmlspecialchars($_POST['account_type_id'])       : $rowCurrent['account_type_id'];
    $assigned_therapist_id = ( isset($_POST['assigned_therapist_id']) ) ? htmlspecialchars($_POST['assigned_therapist_id']) : $rowCurrent['assigned_therapist_id'];

    $active = ( isset($_POST['active']) )         ? 1 : $rowCurrent['active'];
    $new    = ( isset($_POST['new_account']) )    ? 1 : $rowCurrent['new_account'];
    $locked = ( isset($_POST['locked']) )         ? 1 : $rowCurrent['locked'];

    echo $rowCurrent['active'];
    echo $rowCurrent['new_account'];
    echo $rowCurrent['locked'];

    echo '<p>5</p>';

    // insert values into account table to create another user
    $stmtUpdate = $db->prepare('UPDATE account
                                SET username              = :username,
                                SET email                 = :email,
                                SET first_name            = :first_name,
                                SET last_name             = :last_name,
                                SET phone                 = :phone,
                                SET assigned_clinic_id    = :clinic_id,
                                SET account_type_id       = :account_type_id,
                                SET assigned_therapist_id = :assigned_therapist_id,
                                WHERE id = :user_id');
    $stmtUpdate->bindValue(':username', $username, PDO::PARAM_STR);
    $stmtUpdate->bindValue(':email', $email, PDO::PARAM_STR);
    $stmtUpdate->bindValue(':first_name', $first_name, PDO::PARAM_STR);
    $stmtUpdate->bindValue(':last_name', $last_name, PDO::PARAM_STR);
    $stmtUpdate->bindValue(':phone', $phone, PDO::PARAM_STR);
    $stmtUpdate->bindValue(':clinic_id', $clinic_id, PDO::PARAM_INT);
    $stmtUpdate->bindValue(':account_type_id', $account_type_id, PDO::PARAM_INT);
    $stmtUpdate->bindValue(':assigned_therapist_id', $assigned_therapist_id, PDO::PARAM_INT);
    // $stmtUpdate->bindValue(':active', $active);
    // $stmtUpdate->bindValue(':new_account', $new);
    // $stmtUpdate->bindValue(':locked', $locked);
    $stmtUpdate->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmtUpdate->execute();

    echo '<p>Update Successful</p>';

  }

  echo '<p>return to dashboard</p>';

  // go to dashboard page after updating a new user
  // header('Location: dashboard.php');
  // die();


                                  // SET active                = :active,
                                // SET new_account           = :new_account,
                                // SET locked                = :locked 

?>
<!DOCTYPE html>
<html>
<head>
  <title>HTP Update User</title>
</head>
<body>

</body>
</html>

