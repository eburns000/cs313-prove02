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
        echo 'Error Message';
    }

  ?>

  </div>
  
</body>
</html>



