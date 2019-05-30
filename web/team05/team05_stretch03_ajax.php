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

<!DOCTYPE html>
<html>
<head>
  <title>Team 05 - Insert Scripture</title>
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

	<!-- Core 2 Requirements -->
	<!-- 1) Create form to insert scriptures with topics -->
	<!-- 2) Have PHP generate checkboxes for each topic in the DB table -->
	<!-- 3) Have a submit button insert the scripture into both the scriptures and scriptures_topic tables -->
	<!-- See insert_scripture.php for the insert functionality -->
	<h2>Team 05 examples</h2>
	<h4>Core 02</h4>
	<br>

	<form id="userForm">

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

	  		echo '<input type="checkbox" name="topic[]" value="' . $id . '">';
	  		echo $topic;
	  		echo '<br>';

	  	}

	  ?>

	  <!-- Stretch 01 - Create empty check box and empty text box next to it -->
	  <input type="checkbox" name="other" value="other"><span>Other: </span>
	  <input type="text" name="other_topic" placeholder="Enter custom topic">

	  <input type="submit" value="Insert">

	</form>

	<div id="response"></div>

	<!-- Stretch 03 - post data to same page using AJAX -->
	<!-- Reference: https://stackoverflow.com/questions/5004233/jquery-ajax-post-example-with-php -->
	<!-- Reference: https://www.spaceotechnologies.com/jquery-ajax-post-example-php/ -->

	<br>

	<script>

		$(document).ready(function(){

			$('#userForm').submit(function(){

				// show that something is loading
				$('#response').html("<b>Loading response...</b>");

				// Call ajax for pass data to other place
				$.ajax({
				type: 'POST',
				url: 'insert_scripture_ajax.php',
				data: $(this).serialize() // getting filed value in serialize form
				})
				.done(function(data){ // if getting done then call.

				// show the response
				$('#response').html(data);

				})
				.fail(function() { // if fail then getting message

				// just in case posting your form failed
				alert( "Posting failed." );

				});

				// to prevent refreshing the whole page page
				return false;

			});

		});

	</script>
	
</body>
</html>
