
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

<!-- To list all the eois -->

<?php
$sql = "SELECT * FROM eoi";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<table border="1">
    <tr>
        <th>EOI Number</th>
        <th>Job Reference</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Status</th>
    </tr>

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

    mysqli_free_result($result);
    ?>
</table>


<!-- to search eois by job ref num-->
<h2>Search EOIs by Job Reference</h2>

<form method="get" action="manage.php">
    <label for="ref_id">Job Reference:</label>
    <input type="text" name="ref_id" id="ref_id" required>
    <input type="submit" name="search_ref" value="Search">
</form>

<?php
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
        echo "No applicants found for this job reference.";
    }

    mysqli_stmt_close($stmt);
}
?>


<!-- to search eois from first name and last name -->
<h2>Search EOIs by Applicant Name</h2>

<form method="get" action="manage.php">
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" id="first_name">

    <br><br>

    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" id="last_name">

    <br><br>

    <input type="submit" name="search_name" value="Search">
</form>

<?php
if (isset($_GET['search_name'])) {

    $first_name = trim($_GET['first_name'] ?? '');
    $last_name = trim($_GET['last_name'] ?? '');

    if ($first_name == '' && $last_name == '') {

        echo "<p>Please enter a first name or last name.</p>";

    } else {

        if ($first_name != '' && $last_name != '') {

            $sql = "SELECT * FROM eoi
                    WHERE First_Name LIKE ? AND Last_Name LIKE ?";

            $stmt = mysqli_prepare($conn, $sql);

            $first_name = "%" . $first_name . "%";
            $last_name = "%" . $last_name . "%";

            mysqli_stmt_bind_param($stmt, "ss", $first_name, $last_name);

        } elseif ($first_name != '') {

            $sql = "SELECT * FROM eoi WHERE First_Name LIKE ?";

            $stmt = mysqli_prepare($conn, $sql);

            $first_name = "%" . $first_name . "%";

            mysqli_stmt_bind_param($stmt, "s", $first_name);

        } else {

            $sql = "SELECT * FROM eoi WHERE Last_Name LIKE ?";

            $stmt = mysqli_prepare($conn, $sql);

            $last_name = "%" . $last_name . "%";

            mysqli_stmt_bind_param($stmt, "s", $last_name);
        }

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        echo "<h3>Search Results</h3>";

        if (mysqli_num_rows($result) > 0) {

            while ($row = mysqli_fetch_assoc($result)) {

                echo "EOI Number: " . htmlspecialchars($row['EOInumber']) . "<br>";
                echo "Name: " . htmlspecialchars($row['First_Name']) . " " . htmlspecialchars($row['Last_Name']) . "<br>";
                echo "Job Reference: " . htmlspecialchars($row['Ref_ID']) . "<br>";
                echo "Email: " . htmlspecialchars($row['Email']) . "<br>";
                echo "Status: " . htmlspecialchars($row['Status']) . "<br><hr>";
            }

        } else {

            echo "No applicants found.";

        }

        mysqli_stmt_close($stmt);
    }
}
?>



<h2>Delete EOIs by Job Reference</h2>

<form method="post" action="manage.php"
      onsubmit="return confirm('Confirm delete?');">

    <label for="delete_ref">Job Reference:</label>
    <input type="text" name="delete_ref" id="delete_ref" required>

    <input type="submit" name="delete_eoi" value="Delete EOIs">

</form>

<br>
<br>

<!-- For deleting the eois -->
<?php
if (isset($_POST['delete_eoi'])) {

    $delete_ref = trim($_POST['delete_ref']);

    $sql = "DELETE FROM eoi WHERE Ref_ID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $delete_ref);

    if (mysqli_stmt_execute($stmt)) {

        $deleted = mysqli_stmt_affected_rows($stmt);

        if ($deleted > 0) {
            echo "<p>Successfully deleted " . $deleted . " applicant.</p>";
        } else {
            echo "<p>No applicants found for that job reference.</p>";
        }

    } else {
        echo "<p>Unable to delete applicant.</p>";
    }

    mysqli_stmt_close($stmt);
}
?>

<form method="post" action="manage.php">

    <label for="eoi_number">EOI Number:</label>
    <input type="number" name="eoi_number" id="eoi_number" required>

    <br><br>

    <label for="status">New Status:</label>

    <select name="status" id="status" required>
        <option value="New">New</option>
        <option value="Current">Current</option>
        <option value="Final">Final</option>
    </select>

    <br><br>

    <input type="submit" name="update_status" value="Update Status">

</form>

<!-- Update the status of application -->
<?php
if (isset($_POST['update_status'])) {

    $eoi_number = $_POST['eoi_number'];
    $status = $_POST['status'];

    $sql = "UPDATE eoi SET Status = ? WHERE EOInumber = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "si", $status, $eoi_number);

    if (mysqli_stmt_execute($stmt)) {

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "<p>EOI status updated successfully!</p>";
        } else {
            echo "<p>No EOI found, or the status is already the same.</p>";
        }

    } else {
        echo "<p>Can't update EOI status.</p>";
    }

    mysqli_stmt_close($stmt);
}
?>


<h2>Sort the EOIs</h2>

<form method="get" action="manage.php">

    <label for="sort">Sort By:</label>

    <select name="sort" id="sort">
        <option value="EOInumber">EOI Number</option>
        <option value="First_Name">First Name</option>
        <option value="Last_Name">Last Name</option>
        <option value="Ref_ID">Job Reference</option>
        <option value="Status">Status</option>
    </select>

    <input type="submit" name="sort_eoi" value="Sort">

</form>

<!-- Sorting eois -->
<?php
if (isset($_GET['sort_eoi'])) {

    $sort = $_GET['sort'];

    // Allow only these columns to be sorted
    $allowed_fields = [
        "EOInumber",
        "First_Name",
        "Last_Name",
        "Ref_ID",
        "Status"
    ];

    if (in_array($sort, $allowed_fields)) {

        $sql = "SELECT * FROM eoi ORDER BY $sort ASC";

        $result = mysqli_query($conn, $sql);

        echo "<h3>Sorted Results</h3>";

        if (mysqli_num_rows($result) > 0) {

            echo "<table border='1'>";
            echo "<tr>";
            echo "<th>EOI Number</th>";
            echo "<th>Job Reference</th>";
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Email</th>";
            echo "<th>Status</th>";
            echo "</tr>";

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

            echo "</table>";

        } else {
            echo "No applications found.";
        }

        mysqli_free_result($result);

    } else {
        echo "Invalid sorting field.";
    }
}
?>

<br>
<br>


<a href="logout.php">Logout</a>
</body>
</html>

<?php
mysqli_close($conn);
?>
