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
	<title>Team 04 Exercise</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
	<!-- Results from Database Test -->
	<h4>Clinic Table Data</h4>
	<br>
	<?php 

		foreach ($db->query('SELECT clinic_name FROM clinic') as $row)
		{
		  echo 'Clinic Name: ' . $row['clinic_name'];
		  echo '<br/>';
		}

	?>
	<br>

	<h4>Account Type Table Data</h4>
	<br>
	<?php 

		foreach ($db->query('SELECT account_type_name FROM account_type') as $row)
		{
		  echo 'Account Type Name: ' . $row['account_type_name'];
		  echo '<br/>';
		}

	?>
	<br>

	<h4>Modality Table Data</h4>
	<br>
	<?php 

		foreach ($db->query('SELECT modality_name FROM modality') as $row)
		{
		  echo 'Modality Name: ' . $row['modality_name'];
		  echo '<br/>';
		}

	?>
	<br>

	<h4>Discipline Table Data</h4>
	<br>
	<?php 

		foreach ($db->query('SELECT discipline_name FROM discipline') as $row)
		{
		  echo 'Discipline Name: ' . $row['discipline_name'];
		  echo '<br/>';
		}

	?>
	<br>

	<!-- Clinic Data Entry -->	
	<h4>Update Static Tables</h4>
	<br>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-checkout">

		<label for="clinic_name">Clinic Name</label><br>
		<input class="field-checkout" type="text" placeholder="Clinic Name" name="clinic_name"><br>

		<label for="account_type">Account Type</label><br>		
		<input class="field-checkout" type="text" placeholder="Account Type" name="account_type"><br>

		<label for="discipline">Discipline Name</label><br>		
		<input class="field-checkout" type="text" placeholder="Discipline" name="discipline"><br>
		
		<label for="modality">Modality Name</label><br>
		<input class="field-checkout" type="text" placeholder="Modality" name="modality"><br>

		<input class="add-button" type="submit" value="Update Data">

	</form>
	<br>

</body>
</html>