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
    // $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo $book;
    echo $chapter;
    echo $verse;
    echo $content;

    // get id of scripture we just inserted

    // $stmt = $db->prepare('INSERT INTO scriptures (book, chapter, verse, content) VALUES (:book, :chapter, :verse, :content)');
    // $stmt->bindValue(':book', $book, PDO::PARAM_STR);
    // $stmt->bindValue(':chapter', $chapter, PDO::PARAM_INT);
    // $stmt->bindValue(':verse', $verse, PDO::PARAM_INT);
    // $stmt->bindValue(':content', $content, PDO::PARAM_STR);
    // $stmt->execute();

    $topicsSelected = $_POST['topic[]'];

    var_dump($topicsSelected);

    if(!empty($topicsSelected)) {

      foreach ($topicsSelected as $topic) {
        
        $stmt = $db->prepare('INSERT INTO scriptures_topic (scriptures_id, topic_id) VALUES (1, :topic_id)');
        // $stmt->bindValue(':scripture_id', $scripture_id, PDO::PARAM_INT);
        $stmt->bindValue(':topic_id', $topic, PDO::PARAM_INT);
        $stmt->execute();

      }


    }


  }

  // header("Location: team05.php");




?>
<!DOCTYPE html>
<html>
<head>
  <title>test05 insert scripture</title>
</head>
<body>

</body>
</html>
