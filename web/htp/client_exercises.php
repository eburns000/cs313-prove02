<?php

  // start session, get database, and set common initial parameters
  include 'getdb.php';

?>

  <!-- Header -->
  <?php include 'head.html'; ?>
  
  <!-- Navigation -->
  <?php include 'nav.php'; ?>

  <!-- Main Content -->
  <div class="container-fluid main">

  <!-- Client Exercises -->
  <?php 

    $login_user_id = $_SESSION['user_id'];


    // get client id passed in from therapist dashboard
    $current_client_id = $_GET['client_id'];

    // get client's first name
    $statement = $db->query("SELECT first_name FROM account WHERE id = '$current_client_id' ");
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $first_name = $row['first_name'];

    echo '<!-- Therapist View of Client Exercises -->';
    echo '<h2>' . $first_name . '\'s Assigned Exercises</h2>';
    echo '<br>';

    echo '<table class="table-standard">';
    echo '<tr>';
    echo '<th>Exercise</th>';
    echo '<th>Discipline</th>';
    echo '<th>Modality</th>';
    echo '<th>Assignment</th>';
    echo '<th>Video</th>';
    echo '<th>Point Value</th>';
    echo '<th>Completed?</th>';
    echo '<th>Assigned</th>';
    echo '<th>Active</th>';
    echo '</tr>';


    foreach ($db->query("SELECT e.exercise_name, d.discipline_name, m.modality_name, e.assignment, e.video_link,  
                                ae.assigned_date, ae.active, ae.point_value, 
                                ae.completed, ae.account_id, ae.exercise_id 
                                FROM assigned_exercise as ae 
                                JOIN exercise as e on e.id = ae.exercise_id 
                                JOIN modality as m on m.id = e.modality_id 
                                JOIN discipline as d on d.id = e.discipline_id 
                                WHERE ae.account_id = '$current_client_id' 
                                ORDER BY d.discipline_name ASC, e.exercise_name ASC ") as $row)
    {
      $acct_id = $row['account_id'];
      $exer_id = $row['exercise_id'];

      echo '<tr>';

      echo '<td>';      
      echo '<a href="exercise_detail.php?account_id=' . $acct_id . '&exercise_id=' . $exer_id . '">';
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

  </div>
  
</body>
</html>













