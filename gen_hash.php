<?php
require_once "settings.php";

$conn = mysqli_connect($host, $user, $pwd, $dbname);

if (!$conn) {
    die("Database connection failed.");
}

// Choose your new password
$new_password = "admin";

// Convert password into a secure hash
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update the admin account
$sql = "UPDATE users SET password = ? WHERE username = ?";

$stmt = mysqli_prepare($conn, $sql);

$username = "admin";

mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $username);

if (mysqli_stmt_execute($stmt)) {
    echo "Admin password reset successfully!";
} else {
    echo "Password reset failed.";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>