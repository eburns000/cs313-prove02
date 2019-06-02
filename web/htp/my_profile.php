<?php

  // start session, get database, and set common initial parameters
  include 'getdb.php';

  $account_type_id = $_SESSION['account_type_id'];
  $login_user_id = $_SESSION['user_id'];

  // get array for user profile from account
  $stmtProfile = $db->prepare('SELECT id, username, password, email, first_name, last_name, phone FROM account WHERE id = :user_id');
  $stmtProfile->bindValue(':user_id', $login_user_id, PDO::PARAM_INT);
  $stmtProfile->execute();
  $rowProfile = $stmtProfile->fetch(PDO::FETCH_ASSOC);

?>

  <!-- Header -->
  <?php include 'head.html'; ?>

  <!-- Navigation -->
  <?php include 'nav.php'; ?>

  <!-- Main Content -->
  <div class="container-fluid main">


  <!-- Admin Dashboard: Show list of Users -->
  <h2>My Profile</h2>
  <br>

  <form action="update_profile.php" method="post" class="form-checkout">

    <input type="hidden" name="id" value="<?php echo $rowProfile['id']; ?>"><br>

    <label for="first_name">First Name</label><br>    
    <input class="field-checkout" type="text" name="first_name" value="<?php echo $rowProfile['first_name']; ?>"><br>

    <label for="last_name">Last Name</label><br>    
    <input class="field-checkout" type="text" name="last_name" value="<?php echo $rowProfile['last_name']; ?>"><br>

    <label for="username">Username</label><br>    
    <input class="field-checkout" type="text" name="username" value="<?php echo $rowProfile['username']; ?>"><br>

    <label for="password">Password</label><br>    
    <input class="field-checkout" type="password" name="password" value="<?php echo $rowProfile['password']; ?>"><br>    

    <label for="email">Email Address</label><br>    
    <input class="field-checkout" type="text" name="email" value="<?php echo $rowProfile['email']; ?>"><br>

    <label for="phone">Phone</label><br>    
    <input class="field-checkout" type="text" name="phone" value="<?php echo $rowProfile['phone']; ?>"><br>

    <input class="add-button" type="submit" value="Update Profile"> 

  </form>

  <br>

</div>
  
</body>
</html>