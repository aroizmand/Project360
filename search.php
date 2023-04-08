<?php
require_once "config.php";

if(isset($_GET['search'])) {
  $search = mysqli_real_escape_string($link, $_GET['search']);
  $sql = "SELECT * FROM posts WHERE title LIKE '%$search%'";
  $result = mysqli_query($link, $sql);
} else {
  header("location: welcome.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Results</title>
  <link rel="stylesheet" href="style_welcome.css">
  <style>
  .btn {
  display: block;
  margin: 20px auto;
  padding: 10px 20px;
  background-color: black;
  color: #fff;
  text-align: center;
  text-decoration: none;
  border-radius: 5px;
}

.card .btn {
  position: relative;
  bottom: 10px;
  right: 10px;
}
    </style>
</head>
<body>
<header class="header">
    <h1>World's Recipes</h1>
    <ul>
      <li><a href="welcome.php">Welcome</a></li>
      <li><a href="user_profile.php">Profile</a></li>
    </ul>
  </header>
  <div class="container">
    <h1>Results:</h1>
    <?php
      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          echo "<div class='card'>";
          echo "<h2>" . $row['title'] . "</h2>";
          echo "<h5>" . $row['content'] . "</h5>";
          echo "<div class='meta'>By " . $row['username'] . " on " . $row['created_at'] . "</div>";
          echo "<a href='viewpost.php?id=" . $row['id'] . "' class='btn'>View Recipe</a>";
          echo "</div>";
        }
      } else {
        echo "No results found.";
      }
    ?>
  </div>
</body>
</html>