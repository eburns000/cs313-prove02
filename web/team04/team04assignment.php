<?php 

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

<!DOCTYPE html>
<html>
<head>
	<title>Team 04 Assignment</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1">
</head>
<body>
	<!-- Results from Database Test -->
	<h2>Scripture Resources</h2>
	<br>
	<?php 

		foreach ($db->query('SELECT book, chapter, verse, content FROM scriptures') as $row)
		{
		  echo '<strong>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</strong>' . ' - ' . $row['content'];
		  echo '<br/>';
		}

	?>
	<br>

	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
		
		<label for="search">Search by Book</label><br>
		<input class="field-book" type="text" placeholder="enter book name" name="search"><br>

		<input class="search-button" type="submit" value="Search">

	</form>
	<br>

	<h2>Search Results</h2>
	<br>
	<?php 		

		if ( isset($_POST['search']) ) {

			$searchValue = $_POST['search'];

			foreach ($db->query("SELECT id, book, chapter, verse, content FROM scriptures WHERE book = '$searchValue' ") as $row)
			{
			  $id = $row['id'];

			  echo '<a href="scripture.php?row_id=$id">';
			  echo $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'];
			  echo '</a><br/>';
			}

		}

	?>
	<br>

</body>
</html>