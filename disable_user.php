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

// Retrieve the user ID from the URL parameter
$user_id = $_GET["id"];

// Update the user's status to 0 (disabled) in the database
$sql = "UPDATE users SET status = 0 WHERE id = " . $user_id;
$link->query($sql);

// Redirect back to the Admin Panel
header("Location: admin.php");
exit();
?>
