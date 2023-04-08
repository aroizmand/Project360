<?php
// Start the session
session_start();



// Include the database connection file
require_once "config.php";

// Check if the user is logged in and has admin privileges
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["is_admin"] = 0) {
    header("location: login.php");
    exit;
}

// Retrieve all users from the database
$sql_users = "SELECT * FROM users";
$result_users = $link->query($sql_users);

// Retrieve all comments from the database
$sql_comments = "SELECT * FROM comments";
$result_comments = $link->query($sql_comments);

// Retrieve all posts from the database
$sql_posts = "SELECT * FROM posts";
$result_posts = $link->query($sql_posts);

// Close the database connection
$link->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style_welcome.css">

    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
        }
    </style>
</head>
<header class="header">
    <h1>Admin Panel</h1>
    <ul>
      <li><a href="welcome.php">User View</a></li>
      <li><a href="logout.php">Log Out</a></li>
    </ul>
  </header>
<body>
    <h2>Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while($row_users = $result_users->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row_users["id"]; ?></td>
                <td><?php echo $row_users["username"]; ?></td>
                <td><?php echo $row_users["status"] == 1 ? "Enabled" : "Disabled"; ?></td>
                <td>
                    <?php if($row_users["status"] == 1) { ?>
                        <a href="disable_user.php?id=<?php echo $row_users["id"]; ?>">Disable</a>
                    <?php } else { ?>
                        <a href="enable_user.php?id=<?php echo $row_users["id"]; ?>">Enable</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <h2>Comments</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>User_ID</th>
            <th>Post ID</th>
            <th>Content</th>
            <th>Action</th>
        </tr>
        <?php while($row_comments = $result_comments->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row_comments["id"]; ?></td>
                <td><?php echo $row_comments["user_id"]; ?></td>
                <td><?php echo $row_comments["post_id"]; ?></td>
                <td><?php echo $row_comments["content"]; ?></td>
                <td><a href="delete_comment.php?id=<?php echo $row_comments["id"]; ?>">Delete</a></td>
            </tr>
        <?php } ?>
    </table>
    <h2>Posts</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Title</th>
            <th>Content</th>
            <th>Action</th>
        </tr>
        <?php while($row_posts= $result_posts->fetch_assoc()) { ?>
<tr>
<td><?php echo $row_posts["id"]; ?></td>
<td><?php echo $row_posts["username"]; ?></td>
<td><?php echo $row_posts["title"]; ?></td>
<td><?php echo $row_posts["content"]; ?></td>
<td><a href="delete_post.php?id=<?php echo $row_posts["id"]; ?>">Delete</a></td>
</tr>
<?php } ?>
</table>

</body>
</html> 
