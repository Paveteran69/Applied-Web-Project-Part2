<?php
$pdo = new PDO('mysql:host=localhost;dbname=fintech_db', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$folder = __DIR__ . '/Reporting Line';

// Map job reference numbers to their respective image filenames
$images = [
    'JN023' => 'FED.png',
    'JN024' => 'BED.png',
    'JN025' => 'VA.png',
    'JN026' => 'HDT.png'
];

$stmt = $pdo->prepare("UPDATE jobs SET reporting_line = ? WHERE reference_number = ?");

foreach ($images as $ref => $name) {
    $file = "$folder/$name";
    if (file_exists($file)) {
        $imageData = file_get_contents($file);
        $stmt->execute([$imageData, $ref]);
    }
}

echo count($images) . " images successfully updated.";
?>