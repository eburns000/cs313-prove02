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

  <?php 

    echo '<!-- Individual User Profile Screen -->';
    echo '<h2>Users</h2>';
    echo '<br>';

    echo '<table class="table-standard">';
    echo '<tr>';
    echo '<th>First Name</th>';
    echo '<th>Last Name</th>';
    echo '<th>Email</th>';
    echo '</tr>';

    foreach ($db->query("SELECT id, first_name, last_name, email FROM account") as $row)
    {
      $id = $row['id'];

      echo '<tr>';

      echo '<td>';      
      echo '<a href="add_edit_user.php?row_id=' . $id . '">';
      echo $row['first_name'];      
      echo '</a>';
      echo '</td>';

      echo '<td>';
      echo $row['last_name'];
      echo '</td>';

      echo '<td>';
      echo $row['email'];
      echo '</td>'; 

      echo '</tr>';

    }

    echo '</table>';
    echo '<br>';

  ?>
  </div>
  
</body>
</html>










