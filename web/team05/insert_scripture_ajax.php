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

  // CORE 2 - insert values from form (from team05.php) into both scriptures and scriptures_topic tables
  // check if book, chapter, verse, and content were all present, and if so, then cleanse data input first
  // then insert reference into scriptures table
  // if topics were selected, then add a record in the scriptures_topic table for each scripture-topic combination
  // reference to get last ID: https://www.w3schools.com/php/php_mysql_insert_lastid.asp
  if(isset($_POST['book']) && isset($_POST['chapter']) && isset($_POST['verse']) && isset($_POST['content'])) {

    $book = htmlspecialchars($_POST['book']);
    $chapter = htmlspecialchars($_POST['chapter']);
    $verse = htmlspecialchars($_POST['verse']);
    $content = htmlspecialchars($_POST['content']);

    $stmt = $db->prepare('INSERT INTO scriptures (book, chapter, verse, content) VALUES (:book, :chapter, :verse, :content)');
    $stmt->bindValue(':book', $book, PDO::PARAM_STR);
    $stmt->bindValue(':chapter', $chapter, PDO::PARAM_INT);
    $stmt->bindValue(':verse', $verse, PDO::PARAM_INT);
    $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    $stmt->execute();
    $lastScriptureID = $db->lastInsertID("scriptures_id_seq"); // this gets the id of the last inserted data. Ref: https://www.w3schools.com/php/php_mysql_insert_lastid.asp

    // add value scripture id and topic id to scriptures_topic for each topic selected
    // note that $_POST['topic'] will return an array of the values returned from only those boxes which are checked
    // reference: http://form.guide/php-form/php-form-checkbox.html
    if (!empty($_POST['topic'])) {

      // determine how many checkboxes were checked
      $nvals = count($_POST['topic']);

      // loop through the array, inserting into the scriptures_topic table the scripture ID (from $last_id above) and the 
      // topic ID from the value that was passed into the "checkbox" array 
      // note that we had to set the "value" of each check box to the ID of each topic, which was retrieved by 
      // querying the topic table - this was done in team05.php
      for ($i = 0; $i < $nvals; $i++) {

        // note that the actual value passed in corresponds to the appropriate topic id from the topic table
        $stmt = $db->prepare('INSERT INTO scriptures_topic (scriptures_id, topic_id) VALUES (:scripture_id, :topic_id)');
        $stmt->bindValue(':scripture_id', $lastScriptureID, PDO::PARAM_INT);
        $stmt->bindValue(':topic_id', $_POST['topic'][$i], PDO::PARAM_INT);
        $stmt->execute();

      }

    }

      // STRETCH 01 - get value from other check box
      if(isset($_POST['other']) && isset($_POST['other_topic'])) {

        // add other topic to topic table first
        // note should do a try statement and only if it is successful do we move on but for this exercise I will leave it
        $other_topic = $_POST['other_topic'];
        $stmtOtherTopic = $db->prepare('INSERT INTO topic (name) VALUES (:other_topic)');
        $stmtOtherTopic->bindValue(':other_topic', $other_topic, PDO::PARAM_STR);
        $stmtOtherTopic->execute();
        $lastTopicID = $db->lastInsertID("topic_id_seq");

        // now add topic to scripture the way we did it above
        $stmt = $db->prepare('INSERT INTO scriptures_topic (scriptures_id, topic_id) VALUES (:scripture_id, :topic_id)');
        $stmt->bindValue(':scripture_id', $lastScriptureID, PDO::PARAM_INT);
        $stmt->bindValue(':topic_id', $lastTopicID, PDO::PARAM_INT);
        $stmt->execute();
    
      }

  }

  // redirect back to php page with form - this was for CORE 02 - comment out for CORE 03
  // RECOMMENT BACK IN FOR STRETCH 02 - NOTE - EVEN THOUGH WE ARE REDIRECTING BEFORE THE CODE BELOW
  // CAN BE EXECUTED, I'M LEAVING IT UNCOMMENTED FOR REFERENCE
  // reference: https://stackoverflow.com/questions/4871942/how-to-redirect-to-another-page-using-php
  header('Location: team05.php');

  // add a die() statement - see teacher solution - always add die() after re-directs
  die();


  // Core 03
  // After a user submits the form, have the application show a page
  // that lists all the scriptures in the database, each one with it's associated topics.

  // first prepare the statement to get the scripture reference
  $stmtScripture = $db->prepare('SELECT id, book, chapter, verse, content FROM scriptures');
  $stmtScripture->execute();

  // for each scripture, then loop through the scripture_topic table and pull those related topics
  while ($row = $stmtScripture->fetch(PDO::FETCH_ASSOC)) {

    echo '<p>';
    echo '<strong>' . $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'] . '</strong>' . ' - ';
    echo $row['content'];
    echo '<br>';
    echo 'Topics: ';

    // get topics for the given scripture above
    $stmtTopics = $db->prepare('SELECT name FROM topic t JOIN scriptures_topic st ON st.topic_id = t.id WHERE st.scriptures_id = :scripture_id');
    $stmtTopics->bindValue(':scripture_id', $row['id']);
    $stmtTopics->execute();

    // go through each topic
    while ($topicRow = $stmtTopics->fetch(PDO::FETCH_ASSOC)) {
      echo $topicRow['name'] . ' ';
    }

    echo '</p>';

  }

  // my original way of doing the 3rd part of the CORE challenge
  // $stmt2 = $db->prepare('SELECT s.book, s.chapter, s.verse, t.name, s.content 
  //                       FROM scriptures as s 
  //                       JOIN scriptures_topic as st ON s.id = st.scriptures_id
  //                       JOIN topic as t ON t.id = st.topic_id');
  // $stmt2->execute();
  // $rows = $stmt2->fetchALL(PDO::FETCH_ASSOC);

  // foreach ($rows as $row) {
  //   echo $row['book'] . ' ' . $row['chapter'] . ':' . $row['verse'];
  //   echo ' - topic: ' . $row['name'] . ' - scripture: ' . $row['content'] . '.' . '<br>';
  // }

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

</body>
</html>
