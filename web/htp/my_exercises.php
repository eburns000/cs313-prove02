<?php 

  $login_user_id = $_SESSION['user_id'];

  echo '<!-- Client Dashboard: Show list of Clients Assigned Exercises -->';
  echo '<h2>My Exercises</h2>';
  echo '<br>';

  echo '<table>';
  echo '<tr>';
  echo '<th>First Name</th>';
  echo '<th>Last Name</th>';
  echo '<th>Email</th>';
  echo '<th>Email</th>';
  echo '<th>Email</th>';
  echo '<th>Email</th>';
  echo '<th>Email</th>';
  echo '<th>Email</th>';
  echo '<th>Email</th>';
  echo '</tr>';


  foreach ($db->query("SELECT e.exercise_name, d.discipline_name, m.modality_name, e.assignment, e.video_link,  
                              ae.assigned_date, ae.active, ae.point_value, 
                              ae.completed, ae.account_id, ae.exercise_id 
                              FROM assigned_exercise as ae 
                              JOIN exercise as e on e.id = ae.exercise_id 
                              JOIN modality as m on m.id = e.modality_id 
                              JOIN discipline as d on d.id = e.discipline_id 
                              WHERE ae.account_id = '$login_user_id' ") as $row)
  {
    $id = $row['account_id'] . $row['exercise_id'];

    echo '<tr>';

    echo '<td>';      
    echo '<a href="exercise_detail.php?ae_id=' . $id . '">';
    echo $row['exercise_name'];      
    echo '</a>';
    echo '</td>';

    echo '<td>';
    echo $row['discipline_name'];
    echo '</td>';

    echo '<td>';
    echo $row['modality_name'];
    echo '</td>'; 

    echo '<td>';
    echo $row['assignment'];
    echo '</td>';

    echo '<td>';
    echo $row['video_link'];
    echo '</td>';  

    echo '<td>';
    echo $row['point_value'];
    echo '</td>';  

    echo '<td>';
    echo ($row['completed'] == '1' ? 'True' : 'False');
    echo '</td>';   

    echo '<td>';
    echo $row['assigned_date'];
    echo '</td>';  

    echo '<td>';
    echo ($row['active'] == '1' ? 'True' : 'False');
    echo '</td>';                          

    echo '</tr>';

  }

  echo '</table>';
  echo '<br>';

?>




