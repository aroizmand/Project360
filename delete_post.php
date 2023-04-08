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

// Check if the post ID is set
if (!isset($_GET["id"])) {
    error_log("Post ID not set in delete_post.php");
    header("location: admin.php");
    exit;
}

// Sanitize and validate the post ID
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) {
    error_log("Invalid post ID in delete_post.php");
    header("location: admin.php");
    exit;
}

// Delete the post from the database
$sql = "DELETE FROM posts WHERE id = ?";
$stmt = $link->prepare($sql);
$stmt->bind_param("i", $id);
if ($stmt->execute()) {
    // Success
    $stmt->close();
    $link->close();
    header("location: admin.php");
    exit;
} else {
    // Failure
    error_log("Error deleting post in delete_post.php: " . $stmt->error);
    $stmt->close();
    $link->close();
    header("location: admin.php");
    exit;
}
?>
