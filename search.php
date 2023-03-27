<?php
$conn = mysqli_connect("cosc360.ok.ubc.ca", "71867832", "a123d1234", "db_71867832");

if(isset($_GET['search'])) {
  $search = mysqli_real_escape_string($conn, $_GET['search']);
  $sql = "SELECT * FROM posts WHERE title LIKE '%$search%'";
  $result = mysqli_query($conn, $sql);
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
</head>
<body>
  <div class="container">
    <h1>Results:</h1>
    <?php
      if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          echo "<div class='card'>";
          echo "<h2>" . $row['title'] . "</h2>";
          echo "<h5>" . $row['content'] . "</h5>";
          echo "<div class='meta'>By " . $row['author'] . " on " . $row['created_at'] . "</div>";
          echo "</div>";
        }
      } else {
        echo "No results found.";
      }
    ?>
  </div>
  <a href="welcome.php" class="btn">Take me Back!</a>
</body>
</html>