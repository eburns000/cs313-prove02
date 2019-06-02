<?php

  // start session, get database, and set common initial parameters
  include 'getdb.php';

  // get current user id passed in from admin dashboard
  $current_exercise_id_str = $_GET['exercise_id'];
  $current_exercise_id = intval($current_exercise_id_str);

  // get an array of library data
  $statement = $db->query(" SELECT e.id as exercise_id, e.exercise_name as exercise_name, d.discipline_name as discipline, 
                                   m.modality_name as modality_name,  e.assignment as assignment, e.video_link as link, e.active as active,
                                   e.discipline_id as discipline_id, e.modality_id as modality_id
                            FROM exercise as e
                            JOIN discipline as d on d.id = e.discipline_id
                            JOIN modality as m on m.id = e.modality_id
                            WHERE e.id = '$current_exercise_id' ");

  $row = $statement->fetch(PDO::FETCH_ASSOC);

  // get array for modality for drop down select tag
  $stmtModality = $db->prepare('SELECT id as modality_id, modality_name FROM modality');
  $stmtModality->execute();  

  // get array for discipline for drop down select tag
  $stmtDiscipline = $db->prepare('SELECT id as discipline_id, discipline_name FROM discipline');
  $stmtDiscipline->execute();

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

  <form action="update_exercise.php" method="post" class="form-checkout">

    <input type="hidden" name="exercise_id" value="<?php echo $row['exercise_id']; ?>"><br>

    <label for="exercise">Exercise Name</label><br>    
    <input class="field-checkout" type="text" name="exercise_name" value="<?php echo $row['exercise_name']; ?>"><br>

    <label for="discipline">Discipline</label>    
    <select name="discipline_id">
      <?php

        // display options for drop down box from clinic table
        while ($rowDiscipline = $stmtDiscipline->fetch(PDO::FETCH_ASSOC)) {
          echo "<option value='" . $rowDiscipline['discipline_id'] . "' ";

          // set the default selected item based on the assigned clinic
          if ($rowDiscipline['discipline_id'] == $row['discipline_id']) {
            echo 'selected';
          }

          echo ">" . $rowDiscipline['discipline_name'] . "</option>";
        } 

       ?>
    </select><br>

    <label for="modality">Modality</label>    
    <select name="modality_id">
      <?php

        // display options for drop down box from clinic table
        while ($rowModality = $stmtModality->fetch(PDO::FETCH_ASSOC)) {
          echo "<option value='" . $rowModality['modality_id'] . "' ";

          // set the default selected item based on the assigned clinic
          if ($rowModality['modality_id'] == $row['modality_id']) {
            echo 'selected';
          }

          echo ">" . $rowModality['modality_name'] . "</option>";
        } 

       ?>
    </select><br>

    <label for="assignment">Assignment</label><br>
    <textarea class="field-checkout" name="assignment" rows="10" cols="30"><?php echo $row['assignment']; ?></textarea><br>  

    <label for="link">Video Link</label><br>    
    <input class="field-checkout" type="text" name="video_link" value="<?php echo $row['link']; ?>"><br>

    <input class="field-checkout" type="checkbox" name="active" value="1" <?php echo($row['active'] == 1 ? "checked" : ""); ?> > Active?<br>

    <input class="add-button" type="submit" value="Update Exercise"> 

  </form>
  <br>
  </div>
  
</body>
</html>



