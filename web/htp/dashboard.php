<?php

  // start session, get database, and set common initial parameters
  include 'getdb.php';

  $account_type_id = $_SESSION['account_type_id'];

?>

  <!-- Header -->
  <?php include 'head.html'; ?>
  
	<!-- Navigation -->
  <?php include 'nav.php'; ?>

  <!-- Main Content -->
  <div class="container-fluid main">

  <!-- Include Appropriate Dashboard -->
  <?php 

    switch ($account_type_id) {
      case 1: // admin user
        include 'users.php';
        break;
      case 2: // therapist user
        include 'clients.php';
        break;
      case 3: // client user
        include 'my_exercises.php';
        break;
      default:
        echo 'Please wait for the administrator to complete your account setup';
        echo 'Redirecting to login screen in 5 seconds';
        sleep(5);
        header('Location: login.php');
        die();
    }

  ?>

  </div>
  
</body>
</html>



