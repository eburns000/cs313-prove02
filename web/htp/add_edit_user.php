<?php

  // start session, get database, and set common initial parameters
  include 'getdb.php';

  // get current user id passed in from admin dashboard
  $current_user_id_str = $_GET['row_id'];
  $current_user_id = intval($current_user_id_str);

  // get an array of current user data
  $statement = $db->query(" SELECT a.id as user_id, c.clinic_name as clinic, at.account_type_name as account_type, 
                                   a.assigned_therapist_id, a2.first_name as assigned_first, 
                                   a2.last_name as assigned_last, a.first_name as first, a.last_name as last,
                                   a.phone as phone, a.active as active, a.new_account as new, a.locked as locked
                            FROM account as a
                            INNER JOIN account as a2 on a.assigned_therapist_id = a2.id
                            JOIN clinic as c on c.id = a.assigned_clinic_id
                            JOIN account_type as at on at.id = a.account_type_id 
                            WHERE a.id = '$current_user_id' ");

  $row = $statement->fetch(PDO::FETCH_ASSOC);

  if ($row['assigned_therapist_id'] == $current_user_id) {
    $row['assigned_first'] = 'n/a';
    $row['assigned_last'] = '';
  }

?>

  <!-- Header -->
  <?php include 'head.html'; ?>
  
	<!-- Navigation -->
  <?php include 'nav.php'; ?>

  <!-- Main Content -->
  <div class="container-fluid main">

  <!-- Admin Dashboard: Show list of Users -->
  <h2>User Account Details</h2>
  <br>

  <table class="table-standard">
    <tr>
      <th>User ID</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Assigned Clinic</th>
      <th>Account Type</th>
      <th>Assigned Therapist</th>
      <th>Phone</th>
      <th>Active?</th>
      <th>New Account?</th>
      <th>Locked?</th>
    </tr>
  
  <?php 

      echo '<tr>';

      echo '<td>';      
      echo $row['user_id'];      
      echo '</td>';

      echo '<td>';
      echo $row['first'];
      echo '</td>'; 

      echo '<td>';
      echo $row['last'];
      echo '</td>';

      echo '<td>';
      echo $row['clinic'];
      echo '</td>';

      echo '<td>';
      echo $row['account_type'];
      echo '</td>'; 

      echo '<td>';
      echo $row['assigned_first'] . ' ' . $row['assigned_last'];
      echo '</td>'; 

      echo '<td>';
      echo $row['phone'];
      echo '</td>'; 

      echo '<td>';
      echo ($row['active'] == '1' ? 'True' : 'False');
      echo '</td>';              

      echo '<td>';
      echo ($row['new'] == '1' ? 'True' : 'False');
      echo '</td>'; 

      echo '<td>';
      echo ($row['locked'] == '1' ? 'True' : 'False');
      echo '</td>';             

      echo '</tr>'; 

  ?>
  
  </table>

  <br>

  </div>
  
</body>
</html>



