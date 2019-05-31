<?php

  // start session, get database, and set common initial parameters
  include 'getdb.php';

  // get current user id passed in from admin dashboard
  $current_user_id_str = $_GET['row_id'];
  $current_user_id = intval($current_user_id_str);

  // get an array of current user data
  $statement = $db->query(" SELECT a.id as user_id, a.username as username, a.email as email,
                                   a.assigned_clinic_id, a.account_type_id, a.assigned_therapist_id,
                                   c.clinic_name as clinic, at.account_type_name as account_type, 
                                   a.assigned_therapist_id, a2.first_name as assigned_first, 
                                   a2.last_name as assigned_last, a.first_name as first, a.last_name as last,
                                   a.phone as phone, a.active as active, a.new_account as new, a.locked as locked
                            FROM account as a
                            INNER JOIN account as a2 on a.assigned_therapist_id = a2.id
                            JOIN clinic as c on c.id = a.assigned_clinic_id
                            JOIN account_type as at on at.id = a.account_type_id 
                            WHERE a.id = '$current_user_id' ");

  $row = $statement->fetch(PDO::FETCH_ASSOC);

  // if assigned therapist id is self, which is the value for admin and therapist users, then print n/a for assigned therapist
  if ($row['assigned_therapist_id'] == $current_user_id) {
    $row['assigned_first'] = 'n/a';
    $row['assigned_last'] = '';
  }

  // get array for assigned clinic values for drop down select tag
  $stmtClinic = $db->prepare('SELECT id as clinic_id, clinic_name FROM clinic');
  $stmtClinic->execute();

  // get array for account type values for drop down select tag
  $stmtAccountType = $db->prepare('SELECT id as account_type_id, account_type_name FROM account_type');
  $stmtAccountType->execute();

  // get array for assigned therapist values for drop down select tag
  $stmtTherapist = $db->prepare('SELECT id as therapist_id, first_name, last_name, account_type_id FROM account WHERE account_type_id = 2');
  $stmtTherapist->execute();    

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

  <form action="update_user.php" method="post" class="form-checkout">

    <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>"><br>

    <label for="username">Username</label><br>    
    <input class="field-checkout" type="text" name="username" value="<?php echo $row['username']; ?>"><br>

    <label for="email">Email Address</label><br>    
    <input class="field-checkout" type="text" name="email" value="<?php echo $row['email']; ?>"><br>

    <label for="first_name">First Name</label><br>    
    <input class="field-checkout" type="text" name="first_name" value="<?php echo $row['first']; ?>"><br>

    <label for="last_name">Last Name</label><br>    
    <input class="field-checkout" type="text" name="last_name" value="<?php echo $row['last']; ?>"><br>

    <label for="phone">Phone</label><br>    
    <input class="field-checkout" type="text" name="phone" value="<?php echo $row['phone']; ?>"><br> 

    <label for="clinic">Assigned Clinic</label>    
    <select name="clinic_id">
      <?php

        // display options for drop down box from clinic table
        while ($rowClinic = $stmtClinic->fetch(PDO::FETCH_ASSOC)) {
          echo "<option value='" . $rowClinic['clinic_id'] . "' ";

          // set the default selected item based on the assigned clinic
          if ($rowClinic['clinic_id'] == $row['assigned_clinic_id']) {
            echo 'selected';
          }

          echo ">" . $rowClinic['clinic_name'] . "</option>";
        } 

       ?>
    </select><br>

    <label for="account_type">Account Type</label>    
    <select name="account_type_id">
      <?php

        // display options for drop down box from clinic table
        while ($rowAccountType = $stmtAccountType->fetch(PDO::FETCH_ASSOC)) {
          echo "<option value='" . $rowAccountType['account_type_id'] . "' ";

          // set the default selected item based on the assigned clinic
          if ($rowAccountType['account_type_id'] == $row['account_type_id']) {
            echo 'selected';
          }

          echo ">" . $rowAccountType['account_type_name'] . "</option>";
        } 

       ?>
    </select><br>

    <label for="assigned_therapist">Assigned Therapist</label>    
    <select name="assigned_therapist_id">
      <?php

        // display options for drop down box from clinic table
        // to make this dynamic, need to add javascript so that as account type is changed, 
        // this option will either gray out and become disabled or be enabled
        if ($row['account_type_id'] != 3) {

          echo "<option value='" . $row['user_id'] . "'>n/a</option>";

        } else {

          while ($rowTherapist = $stmtTherapist->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $rowTherapist['therapist_id'] . "' ";

            // set the default selected item based on the assigned clinic
            if ($rowTherapist['therapist_id'] == $row['assigned_therapist_id']) {
              echo 'selected';
            }

            echo ">" . $rowTherapist['first_name'] . " " . $rowTherapist['last_name'] . "</option>";
          } 

        }

       ?>
    </select><br>

    <input class="field-checkout" type="checkbox" name="active" value="1" <?php echo($row['active'] == 1 ? "checked" : ""); ?> > Active?<br>

    <input class="field-checkout" type="checkbox" name="new_account" value="1" <?php echo($row['new'] == 1 ? "checked" : ""); ?> > New Account?<br>

    <input class="field-checkout" type="checkbox" name="locked" value="1" <?php echo($row['locked'] == 1 ? "checked" : ""); ?> > Locked?<br>

    <input class="add-button" type="submit" value="Update User">

  </form>

  <br>

  </div>
  
</body>
</html>



