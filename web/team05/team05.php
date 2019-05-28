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

  // how many topics there are
  if(isset($_POST['book']) && isset($_POST['chapter']) && isset($_POST['verse']) && isset($_POST['content'])) {



  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Team 05 Workspace</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1">
</head>
<body>
	<h2>Team 05 examples</h2>
	<h4>Core 02</h4>
	<br>

	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-checkout">

	  <label for="book">Book</label><br>
	  <input type="text" name="book"><br>

	  <label for="chapter">Chapter</label><br>
	  <input type="text" name="chapter"><br>

	  <label for="verse">Verse</label><br>
	  <input type="text" name="verse"><br>

	  <label for="content">Content</label><br>
	  <textarea name="content" rows="5" cols="40"></textarea><br>

	  <?php

	  	foreach ($db->query('SELECT id, name FROM topic') as $row) {

	  		$id = $row['id'];
	  		$topic = $row['name'];

	  		echo '<input type="checkbox" name="topic$id" value="$topic">';
	  		echo $topic;
	  		echo '<br>';

	  	}

	  ?>

	  <input type="submit" value="Insert">

	</form>
	<br>

	<?php 

		// topic1... topic2... topic3... array - change value above to increment by 1
		// then traverse array here in a foreach statement





	?>


	
</body>
</html>
