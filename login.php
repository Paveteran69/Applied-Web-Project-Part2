<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HR Manager Login</title>
</head>
<body>

    <h1>HR Manager Login</h1>

    <?php
if (isset($_GET['error']) && $_GET['error'] == "invalid") {
    echo "<p style='color:red;'>Incorrect username or password. Please try again.</p>";
}
?>

    <form action="process_login.php" method="post">

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <br><br>

        <input type="submit" value="Login">

    </form>

</body>
</html>
