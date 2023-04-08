<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


require_once "config.php";

// Select all the posts from the "posts" table
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = mysqli_query($link, $sql);

$is_admin = false;
$username = $_SESSION["username"];
$sql2 = "SELECT is_admin FROM users WHERE username = '$username'";
if($result2 = mysqli_query($link, $sql2)){
    if(mysqli_num_rows($result2) == 1){
        $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
        if($row2["is_admin"] == 1){
            $is_admin = true;
        }
    }
}

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
<header class="header">
    <h1>World's Recipes</h1>
    <ul>
  <li><a href="user_profile.php">Profile</a></li>
  <?php if ($is_admin) { ?>
            <li><a href="admin.php">Admin Panel</a></li>
        <?php } ?>
</ul>
  </header>
    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to the Recipe Book!.</h1>
<div class="row">
  <div class="leftcolumn">
    <?php
  while ($row = mysqli_fetch_assoc($result)) {
  $id = $row['id'];
  $title = $row['title'];
  $content = $row['content'];
  $author = $row['username'];
  $created_at = $row['created_at'];
echo "<div class=card>";
echo "<h2>$title</h2>";
echo "<h5>$content</h5>";
echo "<div class='meta'>By <a href='profile.php?username=".urlencode($author)."'>$author</a> on $created_at</div>";
echo "<a href='viewpost.php?id=$id' class='btn btn-primary mt-3'>View Recipe</a>";
echo "</div>";
}
?>

  </div>
  <div class="rightcolumn">
    <div class="card">
    <a href="post.php" class="btn btn-warning">Post a Recipe!</a>
</div>
<div class="card">
    <h3>Search for a Recipe</h3>
<form action="search.php" method="GET">
    <input type="text" name="search" placeholder="Search by title...">
    <button type="submit">Search</button>
</form>
</div>
<div class = "card"> 
<a href="logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
</div>
  </div>
</div>
</body>
</html> 