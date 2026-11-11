<?php
$pdo = new PDO('mysql:host=localhost;dbname=fintech_db', 'root', '');
$ref = $_GET['ref'];

$stmt = $pdo->prepare("SELECT reporting_line FROM jobs WHERE reference_number = ?");
$stmt->execute([$ref]);
$row = $stmt->fetch();

header("Content-Type: image/png");
echo $row['reporting_line'];
?>   