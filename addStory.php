
<?php
  require 'database.php';
  session_start();
  if(!hash_equals($_SESSION['token'], $_POST['token'])){
	   die("Request forgery detected");
  }


  if (empty($_POST['storyLink']) || empty($_POST['storyDescription']) || empty($_POST['storyTitle'])) {
    header("refresh:2; url=viewStories.php");
    echo "Please input all fields to add a story to the feed";
    exit;
  }
  else {
    $user_id = $_SESSION['user_id'];
    $storyLink = (String)$_POST['storyLink'];
    $storyTitle = (String)$_POST['storyTitle'];
    $storyDescription = (String)$_POST['storyDescription'];

    if ($_POST['category'] == "Add new category") {
      $category = (String)$_POST['addOption'];
    }
    else {
      $category = (String)$_POST['category'];
      echo "existing category";
    }
    $stmt = $mysqli->prepare("insert into stories (user_id, story_link, title, description, category) values (?, ?, ?, ?, ?)");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('sssss', $user_id, $storyLink, $storyTitle, $storyDescription, $category);
    $stmt->execute();
    $stmt->close();
    header("Location: viewStories.php");
    exit;
  }


 ?>
