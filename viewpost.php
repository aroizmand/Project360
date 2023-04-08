<?php
// Initialize the session
session_start();

// Connect to the database
require_once "config.php";

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];
    

$sql = "SELECT * FROM posts WHERE id='$post_id'";
$result = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($result);


$comments_sql = "SELECT comments.id, comments.content, comments.created_at, users.username 
                 FROM comments
                 JOIN users ON comments.user_id = users.id
                 WHERE comments.post_id='$post_id'";

$comment_result = mysqli_query($link, $comments_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $row['title']; ?> | Recipe Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style_viewpost.css" />    
</head>
<body>
<header class="header">
    <h1>Recipe</h1>
    <ul>
      <li><a href="welcome.php">Welcome</a></li>
      <li><a href="user_profile.php">Profile</a></li>
    </ul>
  </header>
<div class="container">
    <h1 class="my-5"><?php echo $row['title']; ?></h1>
    <p><?php echo $row['content']; ?></p>
    <h5 class="card-text"><small class="text-muted">Posted by <a href="profile.php?username=<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a> on <?php echo $row['created_at']; ?></small></h5>
    <hr>
    <h2>Comments</h2>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
        <form id="comment-form">
            <div class="form-group">
                <label for="comment">Leave a Comment:</label>
                <textarea class="form-control" id="comment" name="content"></textarea>
            </div>
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    <?php else: ?>
        <p>Please <a href="login.php">login</a> to leave a comment.</p>
    <?php endif; ?>
    <hr>
    <div id="comment-section">
        <?php while ($comment_row = mysqli_fetch_assoc($comment_result)): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h4 class="card-text"><?php echo $comment_row['content']; ?></h4>
                    <h5 class="card-text"><small class="text-muted">Posted by <a href="profile.php?username=<?php echo $comment_row['username']; ?>"><?php echo $comment_row['username']; ?></a> on <?php echo $comment_row['created_at']; ?></h5>

                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
<?php
} else {
    ?>
    <h2>Comments</h2>
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
        <!-- Comment form here -->
    <?php else: ?>
        <p>Please <a href="login.php">login</a> to leave a comment.</p>
    <?php endif; 
}
?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#comment-form').submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "add_comment.php",
                data: $(this).serialize(),
                success: function(response) {
                    $('#comment-section').append(response);
                    $('#comment-form')[0].reset();
                }
            });
        });
    });
</script>

</body>
</html>
