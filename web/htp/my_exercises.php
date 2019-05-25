<?php 

  $login_user_id = $_SESSION['user_id'];

  echo '<!-- Client Dashboard: Show list of Clients Exercises -->';
  echo '<h2>My Exercises</h2>';
  echo '<br>';

  echo '<table>';
  echo '<tr>';
  echo '<th>First Name</th>';
  echo '<th>Last Name</th>';
  echo '<th>Email</th>';
  echo '</tr>';

  foreach ($db->query("SELECT a.id as client_id, a.assigned_therapist_id as assigned_therapist_id, 
                              a.first_name as first_name, a.last_name as last_name, a.email as email 
                       FROM account as a 
                       WHERE a.assigned_therapist_id = '$login_user_id' ") as $row)
  {
    $id = $row['client_id'];

    echo '<tr>';

    echo '<td>';      
    echo '<a href="add_edit_user.php?client_id=' . $id . '">';
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



