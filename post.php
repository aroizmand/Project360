<?php

// Connect to the database
$conn = mysqli_connect("cosc360.ok.ubc.ca", "71867832", "a123d1234", "db_71867832");

// If the user clicks the "Add Post" button
if (isset($_POST['add_post'])) {
  $title = $_POST['title'];
  $content = $_POST['content'];
  $author = $_POST['author'];

  // Insert the post into the "posts" table
  $sql = "INSERT INTO posts (title, content, author, created_at) 
          VALUES ('$title', '$content', '$author', NOW())";

  if (mysqli_query($conn, $sql)) {
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="post.css">
    <title>Document</title>
</head>
<body>
<h2>Add Post</h2>
<form method="post" action="">
  <label>Title:</label>
  <input type="text" name="title" required><br>

  <label>Recipe:</label>
  <textarea name="content" required></textarea><br>

  <label>First Name:</label>
  <input type="text" name="author" required><br>

  <input type="submit" name="add_post" value="Add Post">
</form>
</body>
</html>