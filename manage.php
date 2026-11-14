
<?php
session_start();

// Check if user logged in 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HR Manager</title>
</head>
<body>

    <h1>HR Manager Dashboard</h1>

    <p>
        Welcome,
        <?php echo htmlspecialchars($_SESSION['username']); ?>
    </p>

    <h2>EOI Management</h2>

    <p>Here you will eventually be able to:</p>

    <ul>
        <li>View all EOIs</li>
        <li>Search EOIs by job reference</li>
        <li>Search EOIs by applicant name</li>
        <li>Delete EOIs by job reference</li>
        <li>Update EOI status</li>
        <li>Sort EOI records</li>
    </ul>

    <a href="logout.php">Log out</a>

</body>
</html>