

<?php

session_start();

require_once "settings.php";

// Connect to database
$conn = mysqli_connect($host, $user, $pwd, $dbname);

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check whether the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: login.php");
    exit();
}

// Get username and password
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Check if fields are empty
if ($username == "" || $password == "") {
    header("Location: login.php?error=empty");
    exit();
}

// Prepare SQL statement
$sql = "SELECT user_id, username, password
        FROM users
        WHERE username = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $username);

mysqli_stmt_execute($stmt);

// Get query result
$result = mysqli_stmt_get_result($stmt);

// Check if username exists
if (mysqli_num_rows($result) == 1) {

    $user = mysqli_fetch_assoc($result);

    // Verify the password
    if (password_verify($password, $user['password'])) {

        // Regenerate session ID
        session_regenerate_id(true);

        // Store admin information in session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];

        // Bring to manage.php
        header("Location: manage.php");
        exit();

    } else {

        header("Location: login.php?error=invalid");
        exit();
    }

} else {

    header("Location: login.php?error=invalid");
    exit();
}

// Close database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
