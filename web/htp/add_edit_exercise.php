<?php

  // start session, get database, and set common initial parameters
  include 'getdb.php';

  // get current user id passed in from admin dashboard
  $current_exercise_id_str = $_GET['exercise_id'];
  $current_exercise_id = intval($current_exercise_id_str);

  // get an array of library data
  $statement = $db->query(" SELECT e.id as exercise_id, e.exercise_name as exercise, d.discipline_name as discipline, 
                                   m.modality_name as modality,  e.assignment as assignment, e.video_link as link, e.active as active
                            FROM exercise as e
                            JOIN discipline as d on d.id = e.discipline_id
                            JOIN modality as m on m.id = e.modality_id
                            WHERE e.id = '$current_exercise_id' ");

  $row = $statement->fetch(PDO::FETCH_ASSOC);

?>

  <!-- Header -->
  <?php include 'head.html'; ?>

	<!-- Navigation -->
  <?php include 'nav.php'; ?>

  <!-- Main Content -->
  <div class="container-fluid main">

  <!-- Admin Dashboard: Show list of Users -->
  <h2>Add/Edit Exercise</h2>
  <br>

  <table class="table-standard">
    <tr>
      <th>Exercise</th>
      <th>Discipline</th>
      <th>Modality</th>
      <th>Assignment</th>
      <th>Video</th>
      <th>Active</th>
    </tr>
  
  <?php 

      echo '<tr>';

      echo '<td>';
      echo $row['exercise'];
      echo '</td>';

      echo '<td>';
      echo $row['discipline'];
      echo '</td>'; 

      echo '<td>';
      echo $row['modality'];
      echo '</td>'; 

      echo '<td>';
      echo $row['assignment'];
      echo '</td>'; 

      echo '<td>';
      echo $row['link'];
      echo '</td>';

      echo '<td>';
      echo ($row['active'] == '1' ? 'True' : 'False');
      echo '</td>';

      echo '</tr>'; 

  ?>
  
  </table>

  <br>

  </div>
  
</body>
</html>



