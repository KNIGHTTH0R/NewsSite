<?php
  require 'database.php';
  session_start();
  if(!hash_equals($_SESSION['token'], $_POST['token'])){
	   die("Request forgery detected");
  }
  $file_name = $_POST['name'];
  $stmt = $mysqli->prepare("delete from stories where story_id=$file_name");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }
  $stmt->execute();
  $stmt->close();
  header("Location: viewStories.php");
  echo "Story deleted succesfully";
  exit;

  ?>
