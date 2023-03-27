<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "recipebook");

// Select all the posts from the "posts" table
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style_welcome.css" />    
</head>
<body>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to the Recipe Book!.</h1>
<div class="header">
  <h2>World's Recipes</h2>
</div>

<div class="row">
  <div class="leftcolumn">
    <?php
  while ($row = mysqli_fetch_assoc($result)) {
  $id = $row['id'];
  $title = $row['title'];
  $content = $row['content'];
  $author = $row['author'];
  $created_at = $row['created_at'];

  echo "<div class=card>";
  echo "<h2>$title</h2>";
  echo "<h5>$content</h5>";
  echo "<div class='meta'>By $author on $created_at</div>";
  echo "</div>";
}
?>
    
  </div>
  <div class="rightcolumn">
    <div class="card">
    <a href="post.php" class="btn btn-warning">Post a Recipe!</a>
</div>
<div class = "card"> 
<a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</div>
<div class="card">
    <h3>Search for a Recipe</h3>
    
<form action="search.php" method="GET">
    <input type="text" name="search" placeholder="Search by title...">
    <button type="submit">Search</button>
</form>
</div>
  </div>
</div>
</body>
</html>