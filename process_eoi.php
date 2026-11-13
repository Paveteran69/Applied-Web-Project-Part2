<?php
/* 1. block direct url access */
$required_fields = [
    "Ref_ID", "First_Name", "Last_Name", "Date_Of_Birth",
    "Street_Address", "Suburb", "State", "Postcode",
    "Email", "Phone_Number"
];

if (($_SERVER["REQUEST_METHOD"] ?? "") !== "POST") {
    header("Location: apply.html");
    exit();
}
foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
        header("Location: apply.html");
        exit();
    }
}



/* 2. data sanitisation, security, validation */
function clean_input($data) {
    return stripslashes(trim((string)$data));
}
function h($data) {
    return htmlspecialchars((string)$data, ENT_QUOTES, "UTF-8");
}

function postcode_matches_state($state, $pc) {
    $pc = (int)$pc;
    $ranges = [
        "VIC" => [[3000, 3999], [8000, 8999]],
        "NSW" => [[1000, 1999], [2000, 2599], [2619, 2899], [2921, 2999]],
        "QLD" => [[4000, 4999], [9000, 9999]],
        "NT"  => [[800, 999]],
        "WA"  => [[6000, 6999]],
        "SA"  => [[5000, 5999]],
        "TAS" => [[7000, 7999]],
        "ACT" => [[200, 299], [2600, 2618], [2900, 2920]],
    ];
    if (!isset($ranges[$state])) return false;
    foreach ($ranges[$state] as $r) {
        if ($pc >= $r[0] && $pc <= $r[1]) return true;
    }
    return false;
}


?>