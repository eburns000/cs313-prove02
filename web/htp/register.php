<?php

    session_start();

  try
  {
    $dbUrl = getenv('DATABASE_URL');

    $dbOpts = parse_url($dbUrl);

    $dbHost = $dbOpts["host"];
    $dbPort = $dbOpts["port"];
    $dbUser = $dbOpts["user"];
    $dbPassword = $dbOpts["pass"];
    $dbName = ltrim($dbOpts["path"],'/');

    $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch (PDOException $ex)
  {
    echo 'Error!: ' . $ex->getMessage();
    die();
  }

?>

  <!-- Header -->
  <?php include 'head.html'; ?>
  
	<!-- Navigation -->
  <div class="container">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark fixed-top">
      
      <!--Toggler/collapsible Button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>        
      </button>
      
      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="../htp/login.php">Home</a>
          </li>                                   
        </ul> 
      </div>
    </nav>
  </div>

  <!-- Main Content -->
  <div class="container-fluid main">

    <!-- Clinic Data Entry -->  
    <h4>Register as a new user</h4>
    <br>
    <form action="insert_new_user.php" method="post" class="form-checkout">

      <!-- prior action statement <?php // echo htmlspecialchars($_SERVER['PHP_SELF']); ?> -->

      <label for="username">Username</label><br>
      <input class="field-checkout" type="text" name="username"><br>

      <label for="password">Password</label><br>    
      <input class="field-checkout" type="password" name="password"><br>

      <label for="confirm_password">Confirm Password</label><br>    
      <input class="field-checkout" type="password" name="confirm_password"><br>

      <label for="email">Email</label><br>    
      <input class="field-checkout" type="text" name="email"><br>

      <label for="confirm_email">Confirm Email</label><br>    
      <input class="field-checkout" type="text" name="confirm_email"><br>      

      <label for="first_name">First Name</label><br>    
      <input class="field-checkout" type="text" name="first_name"><br>

      <label for="last_name">Last Name</label><br>    
      <input class="field-checkout" type="text" name="last_name"><br> 

      <label for="phone">Phone</label><br>    
      <input class="field-checkout" type="text" name="phone"><br>

      <input class="add-button" type="submit" value="Register">

    </form>
    <br>

  </div>
  
</body>
</html>



