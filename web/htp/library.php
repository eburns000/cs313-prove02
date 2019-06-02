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

  <!-- Admin Dashboard: Show list of Users -->
  <h2>Exercise Library</h2>
  <br>

  <table class="table-standard">
    <tr>
      <th>Exercise</th>
      <th>Discipline</th>
      <th>Modality</th>
      <th>Assignment</th>
      <th>Link</th>
    </tr>
  
  <?php 

    // get an array of library data
    $statement = $db->query(" SELECT e.id as exercise_id, e.exercise_name as exercise, d.discipline_name as discipline, 
                                   m.modality_name as modality,  e.assignment as assignment, e.video_link as link
                            FROM exercise as e
                            JOIN discipline as d on d.id = e.discipline_id
                            JOIN modality as m on m.id = e.modality_id 
                            ORDER BY discipline ASC, exercise ASC ");

    while ($row = $statement->fetch(PDO::FETCH_ASSOC))
    {
      $id = $row['exercise_id'];

      echo '<tr>';

      echo '<td>';      
      echo '<a href="add_edit_exercise.php?exercise_id=' . $id . '">';
      echo $row['exercise'];      
      echo '</a>';
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

      echo '</tr>';

    }

  ?>
  
  </table>

  <br>

  

  </div>


  
</body>
</html>



