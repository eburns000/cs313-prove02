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
	<!-- Results from Database Search -->
	<h2>Result</h2>
	<br>
	<?php 		

		if ( isset($_GET['row_id']) ) {

			$row_id = $_GET['row_id'];

			foreach ($db->query("SELECT id, book, chapter, verse, content FROM scriptures WHERE id = $row_id ") as $row)
			{
				echo '<strong>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</strong>' . ' - ' . $row['content'];
				echo '<br/>';
			}

		}

	?>
	<br>

</body>
</html>