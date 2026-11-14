<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "settings.php";

$conn = mysqli_connect($host, $user, $pwd, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

// Retrieve all EOIs
$sql = "SELECT * FROM eoi";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
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

<h2>All Expressions of Interest</h2>

<table border="1">
    <tr>
        <th>EOI Number</th>
        <th>Job Reference</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Status</th>
    </tr>


<h2>Search EOIs by Job Reference</h2>

<form method="get" action="manage.php">
    <label for="ref_id">Job Reference:</label>
    <input type="text" name="ref_id" id="ref_id" required>

    <input type="submit" name="search_ref" value="Search">
</form>


<h2>Search EOIs by Applicant Name</h2>

<form method="get" action="manage.php">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name">

    <br>
    <br>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name">
    <br>
    <br>
    <input type="submit" name="search_name" value="Search">
</form>

<br>
<br>


    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['EOInumber']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Ref_ID']) . "</td>";
        echo "<td>" . htmlspecialchars($row['First_Name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Last_Name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
        echo "</tr>";
    }

    if (isset($_GET['search_ref'])) {

    $ref_id = trim($_GET['ref_id']);

    $sql = "SELECT * FROM eoi WHERE Ref_ID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $ref_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    echo "<h3>Search Results</h3>";

    if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
            echo "EOI Number: " . htmlspecialchars($row['EOInumber']) . "<br>";
            echo "Job Reference: " . htmlspecialchars($row['Ref_ID']) . "<br>";
            echo "Name: " . htmlspecialchars($row['First_Name']) . " " . htmlspecialchars($row['Last_Name']) . "<br>";
            echo "Email: " . htmlspecialchars($row['Email']) . "<br>";
            echo "Status: " . htmlspecialchars($row['Status']) . "<br><hr>";
        }

    } else {
        echo "No applications found for this job reference.";
    }

    mysqli_stmt_close($stmt);
}
    ?>

</table>

</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($conn);
?>