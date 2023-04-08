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

// Check if the comment ID was passed via GET
if (isset($_GET['id'])) {
    // Sanitize the comment ID
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Prepare and execute the SQL query to delete the comment
    $stmt = $link->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Check if the comment was successfully deleted
    if ($stmt->affected_rows > 0) {
        // Redirect back to the admin panel
        header("Location: admin.php");
        exit();
    } else {
        // Display an error message
        echo "Error: Failed to delete comment.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$link->close();
?>
