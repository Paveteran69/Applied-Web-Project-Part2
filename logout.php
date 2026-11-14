<?php
session_start();

// Clear all the session information
$_SESSION = [];

// Destroy the session
session_destroy();

// Return to login page
header("Location: login.php");
exit();
?>