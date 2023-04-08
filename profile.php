<?php
// Connect to the database
require_once "config.php";

// Retrieve the user's username from the URL parameter
if (!isset($_GET['username'])) {
    echo "User not found.";
    exit;
}
$username = $_GET['username'];

// Query the database to get the user's information and posts
$user_query = "SELECT * FROM users WHERE username = '$username'";
$user_result = mysqli_query($link, $user_query);
$user_row = mysqli_fetch_assoc($user_result);

$post_query = "SELECT * FROM posts WHERE username = '$username' ORDER BY created_at DESC";
$post_result = mysqli_query($link, $post_query);

// If the user is not found in the database, display an error message
if (!$user_row) {
    echo "User not found.";
    exit;
}

// Close the database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $user_row['username']; ?>'s Profile</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style_welcome.css">
</head>
<body>
	<!-- Header -->
	<header class="header">
    <h2><?php echo $user_row['username']; ?>'s Profile</h2>    
    <ul>
      <li><a href="welcome.php">Welcome</a></li>
      <li><a href="profile.php">Profile</a></li>
    </ul>
  </header>
  <div>
		<h2><?php echo $user_row['bio']; ?></h2>
	</div>

			<?php while ($post_row = mysqli_fetch_assoc($post_result)) { ?>
				<div class="card">
					<h2><?php echo $post_row['title']; ?></h2>
					<h5><?php echo $post_row['created_at']; ?></h5>
					<p><?php echo $post_row['content']; ?></p>
					<a href="viewpost.php?id=<?php echo $post_row['id']; ?>" class="btn btn-primary">View Recipe</a>
				</div>
			<?php } ?>

</body>
</html>
