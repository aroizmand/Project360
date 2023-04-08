<?php
// Start the session
session_start();

// Include the database connection file
require_once "config.php";

// Retrieve the user ID from the URL parameter
$user_id = $_GET["id"];

// Update the user's status to 1 (enabled) in the database
$sql = "UPDATE users SET status = 1 WHERE id = " . $user_id;
$link->query($sql);

// Redirect back to the Admin Panel
header("Location: admin.php");
exit();
?>
