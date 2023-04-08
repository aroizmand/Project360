<?php
// Initialize the session
session_start();

// Connect to the database
require_once "config.php";

// Get the comment data from the form submission
$content = $_POST['content'];
$post_id = $_POST['post_id'];

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    // Get the user ID and username
    $user_id = $_SESSION['id'];
    $username = $_SESSION['username'];

    // Insert the comment into the database
    $insert_sql = "INSERT INTO comments (content, post_id, user_id) VALUES ('$content', '$post_id', '$user_id')";
} else {
    // Insert an anonymous comment into the database
    $insert_sql = "INSERT INTO comments (content, post_id) VALUES ('$content', '$post_id')";
}

// Execute the SQL query
if (mysqli_query($link, $insert_sql)) {
    // Select the new comment from the database and include the username
    $comment_sql = "SELECT comments.*, users.username FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.id = LAST_INSERT_ID()";
    $comment_result = mysqli_query($link, $comment_sql);
    $comment_row = mysqli_fetch_assoc($comment_result);

    // Return the new comment HTML
    $comment_html = "<div class='card mb-3'><div class='card-body'><p class='card-text'>" . $comment_row['content'] . "</p><p class='card-text'><small class='text-muted'>Posted by " . $comment_row['username'] . " on " . $comment_row['created_at'] . "</small></p></div></div>";
    echo $comment_html;
} else {
    // Handle the database error
    echo "Error: " . mysqli_error($link);
}

// Close the database connection
mysqli_close($link);
?>