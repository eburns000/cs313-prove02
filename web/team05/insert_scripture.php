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

  // check if book, chapter, verse, and content were all present, and if so, then cleanse data input first
  // then insert reference into scriptures table
  // if topics were selected, then add a record in the scriptures_topic table for each scripture-topic combination
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
    $last_id = $db->lastInsertID();

    echo $last_id . '<br>';
    echo $book . '<br>';
    echo $chapter . '<br>';
    echo $verse . '<br>';
    echo $content . '<br>';

    // add value scripture id and topic id to scriptures_topic for each topic selected
    if (!empty($_POST['topic'])) {

      // determine how many checkboxes were checked
      $nvals = count($_POST['topic']);

      for ($i = 0; $i < $nvals; $i++) {

        // note that the actual value passed in corresponds to the appropriate topic id from the topic table
        $stmt = $db->prepare('INSERT INTO scriptures_topic (scriptures_id, topic_id) VALUES (:scriptures_id, :topic_id)');
        $stmt->bindValue(':scripture_id', $last_id, PDO::PARAM_INT);
        $stmt->bindValue(':topic_id', $_POST['topic'][$i], PDO::PARAM_INT);
        $stmt->execute();

      }

    }

  }

  // redirect back to php page with form
  header('Location: team05.php');

?>
<!DOCTYPE html>
<html>
<head>
  <title>test05 insert scripture</title>
</head>
<body>

</body>
</html>
