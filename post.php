<?php

// Connect to the database
require_once "config.php";

session_start();

// If the user clicks the "Add Post" button
if (isset($_POST['add_post'])) {
  $title = mysqli_real_escape_string($link, $_POST['title']);
  $content = mysqli_real_escape_string($link, $_POST['content']);
  $username = $_SESSION['username'];

  // Insert the post into the "posts" table
  $sql = "INSERT INTO posts (title, content, created_at,username) 
          VALUES ('$title', '$content', NOW(),'$username')";

  if (mysqli_query($link, $sql)) {
    // Redirect to the main page
    header("Location: welcome.php");
    exit();
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  
}

?>
<!-- HTML code for the "Add Post" form -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style_viewpost.css" />
  <title>Add Post</title>
</head>
<body>
  <header class="header">
    <h1>Add Post</h1>
    <ul>
      <li><a href="welcome.php">Welcome</a></li>
      <li><a href="user_profile.php">Profile</a></li>
    </ul>
  </header>
  <div class="container">
    <form method="post" action="">
      <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
      </div>
      <div class="form-group">
        <label for="content">Recipe:</label>
        <textarea name="content" id="content" required></textarea>
      </div>
      <div class="form-group">
        <input type="submit" name="add_post" value="Add Post">
      </div>
    </form>
  </div>
</body>
</html>
