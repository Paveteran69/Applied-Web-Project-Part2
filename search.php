<?php
    $pages = [
        "about"       => "about.php",
        "company"     => "about.php",
        "team"        => "about.php",
        "member"      => "about.php",
        "hire"        => "apply.php",
        "hiring"      => "apply.php",
        "apply"       => "apply.php",
        "application" => "apply.php",
        "form"        => "apply.php",
        "jobs"        => "jobs.php",
        "job"         => "jobs.php",
        "career"      => "jobs.php",
        "vacancy"     => "jobs.php",
        "work"        => "jobs.php"
    ];

    $query = isset($_GET["q"]) ? strtolower(trim($_GET["q"])) : "";

    if ($query !== "") {
        foreach ($pages as $keyword => $destination) {
            if (strpos($query, $keyword) !== false) {
                header("Location: " . $destination);
                exit;
            }
        }
    }
    header("Location: index.php");
    exit;
?>