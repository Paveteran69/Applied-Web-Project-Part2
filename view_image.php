<?php
// 1. Validate that 'ref' exists in the URL request
if (!isset($_GET['ref']) || empty($_GET['ref'])) {
    http_response_code(400);
    exit('Error: Missing job reference number.');
}

$ref = $_GET['ref'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=fintech_db', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Query the image binary from the database
    $stmt = $pdo->prepare("SELECT reporting_line FROM jobs WHERE reference_number = ?");
    $stmt->execute([$ref]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //See Image using this http://localhost/Applied-Web-Project-Part2/view_image.php?ref=JN023

    // 3. Verify image data exists
    if ($row && !empty($row['reporting_line'])) {
        header("Content-Type: image/png");
        echo $row['reporting_line'];
    } else {
        http_response_code(404);
        exit('Image not found for reference: ' . htmlspecialchars($ref));
    }
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database error: ' . $e->getMessage());
}
?>