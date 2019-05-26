<?php

  // start session, get database, and set common initial parameters
  include 'getdb.php';

  $account_type_id = $_SESSION['account_type_id'];
  $login_user_id = $_SESSION['user_id'];

?>

  <!-- Header -->
  <?php include 'head.html'; ?>

  <!-- Navigation -->
  <?php include 'nav.php'; ?>

  <!-- Main Content -->
  <div class="container-fluid main">

  <?php 

    echo '<!-- Individual User Profile Screen -->';
    echo '<h2>My Profile</h2>';
    echo '<br>';

    echo '<table class="table-standard">';
    echo '<tr>';
    echo '<th>First Name</th>';
    echo '<th>Last Name</th>';
    echo '<th>Email</th>';
    echo '</tr>';

    foreach ($db->query("SELECT first_name, last_name, username, email, phone, my_points FROM account WHERE id = '$login_user_id' ") as $row)
    {

      echo '<tr>';

      echo '<td>';      
      echo $row['first_name'];      
      echo '</td>';

      echo '<td>';
      echo $row['last_name'];
      echo '</td>';

      echo '<td>';
      echo $row['username'];
      echo '</td>';

      echo '<td>';
      echo $row['email'];
      echo '</td>';

      echo '<td>';
      echo $row['phone'];
      echo '</td>';

      echo '<td>';
      echo $row['my_points'];
      echo '</td>';             

      echo '</tr>';

    }

    echo '</table>';
    echo '<br>';

  ?>
  </div>
  
</body>
</html>










