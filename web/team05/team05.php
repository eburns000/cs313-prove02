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
	<title>Team 05 Workspace</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1">
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

	<form action="insert_scripture.php" method="post" class="form-checkout">

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

	<!-- Stretch 02 - post data to same page -->

	<?php 

	  // This was copied from Core 03 - this is the display of the scriptures and their topics

	  // NOTE THAT FOR STRETCH 02, this will essentially be "refreshed" by the fact that we are redirecting 
	  // back to this page

	  // first prepare the statement to get the scripture reference
	  $stmtScripture2 = $db->prepare('SELECT id, book, chapter, verse, content FROM scriptures');
	  $stmtScripture2->execute();

	  // for each scripture, then loop through the scripture_topic table and pull those related topics
	  while ($row2 = $stmtScripture2->fetch(PDO::FETCH_ASSOC)) {

	    echo '<p>';
	    echo '<strong>' . $row2['book'] . ' ' . $row2['chapter'] . ':' . $row2['verse'] . '</strong>' . ' - ';
	    echo $row2['content'];
	    echo '<br>';
	    echo 'Topics: ';

	    // get topics for the given scripture above
	    $stmtTopics2 = $db->prepare('SELECT name FROM topic t JOIN scriptures_topic st ON st.topic_id = t.id WHERE st.scriptures_id = :scripture_id2');
	    $stmtTopics2->bindValue(':scripture_id2', $row2['id']);
	    $stmtTopics2->execute();

	    // go through each topic
	    while ($topicRow2 = $stmtTopics2->fetch(PDO::FETCH_ASSOC)) {
	      echo $topicRow2['name'] . ' ';
	    }

	    echo '</p>';

	  }	


	?>

	<br>
	
</body>
</html>
