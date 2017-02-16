<?php
  session_start();
  require 'database.php';
  if (isset($_POST['guest'])){
    if (!isset($_SESSION['username'])){
      $_SESSION['username'] = "guest";
    }
  }
  // Code taken from course wiki
  $stmt = $mysqli->prepare("select story_link, title, description, story_id from stories order by story_id");
  if(!$stmt){
  	printf("Query Prep Failed: %s\n", $mysqli->error);
  	exit;
  }
  $stmt->execute();

  $result = $stmt->get_result();

  echo "<ul>\n";
  while($row = $result->fetch_assoc()){
  	printf("<a href='%s'> %s </a><br>", $row["story_link"], $row["title"]);
    printf("%s", $row["description"]);
  }
  echo $_SESSION['username'];

  if (isset($_SESSION['username']) && $_SESSION['username'] != "guest") {
    printf("<form action='addStory.php' method='post'>");
    printf("Logout <input type='submit' value='Add story' name='Submit'></form>");
    printf("<form action='logout.php' method='post'>");
    printf("<input type='submit' value='Logout' name='Submit'></form>");

  }

$stmt->close();
?>