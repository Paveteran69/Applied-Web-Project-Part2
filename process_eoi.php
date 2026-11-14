<?php
/* database credentials in settings.php */
require_once "settings.php"; 
/* 1. block direct url access */
$required_fields = [
    "Ref_ID", "First_Name", "Last_Name", "Date_Of_Birth",
    "Street_Address", "Suburb", "State", "Postcode",
    "Email", "Phone_Number"
];

$is_post = (($_SERVER["REQUEST_METHOD"] ?? "") == "POST");
if ($is_post == false) {
    header("Location: apply.php");
    exit();
}
foreach ($required_fields as $field) {
    if (isset($_POST[$field]) == false) {
        header("Location: apply.php");
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

    if (isset($ranges[$state]) == false) 
        return false;
    foreach ($ranges[$state] as $r) {
        if ($pc >= $r[0] && $pc <= $r[1]) 
            return true;
    }
    return false;
}

/*  3. get input from form and clean whitespace,duplicates, prevent user from adding their own script */
$ref_id   = clean_input($_POST["Ref_ID"]);
$fname    = clean_input($_POST["First_Name"]);
$lname    = clean_input($_POST["Last_Name"]);
$dob      = clean_input($_POST["Date_Of_Birth"]);
$gender   = isset($_POST["gender"]) ? clean_input($_POST["gender"]): "";
$street   = clean_input($_POST["Street_Address"]);
$suburb   = clean_input($_POST["Suburb"]);
$state    = clean_input($_POST["State"]);
$postcode = clean_input($_POST["Postcode"]);
$email    = clean_input($_POST["Email"]);
$phone    = clean_input($_POST["Phone_Number"]);
$role     = isset($_POST["Desired_Role"]) ? clean_input($_POST["Desired_Role"]) : "";
$other    = isset($_POST["Other_Skills"]) ? clean_input($_POST["Other_Skills"]) : "";

$allowed_skills = [
    "Communication", "Teamwork", "Problem_Solving", "Adaptability",
    "Computer_Literacy", "Spreadsheet_Modelling_Master",
    "Programming", "Cybersecurity", "Data_Science_Analytics"
];

$skills = [];
$skills_invalid = false;
if (isset($_POST["Skill_List"]) && is_array($_POST["Skill_List"])) {
    foreach ($_POST["Skill_List"] as $s) {
        $s = clean_input($s);
        if (in_array($s, $allowed_skills, true)) {
            $skills[] = $s;
        } else {
            $skills_invalid = true;
        }
    }
}

$skills = array_values(array_unique($skills));
$skills_str = implode(", ", $skills);

/* 4. server does its thing and validates every field*/
$errors = [];

$valid_ref_ids = ["JN023", "JN024", "JN025", "JN026"];
if (in_array($ref_id, $valid_ref_ids, true) == false) {
    $errors[] = "Job Reference Number must be one of: " . implode(", ", $valid_ref_ids) . ".";
}

if (preg_match("/^[a-zA-Z]{2,20}$/", $fname) == 0) {
    $errors[] = "First name must be 2-20 letters only.";
}

if (preg_match("/^[a-zA-Z]{2,20}$/", $lname) == 0) {
    $errors[] = "Last name must be 2-20 letters only.";
}

$d = DateTime::createFromFormat("Y-m-d", $dob);
if ($d == false) {
    $errors[] = "Date of birth is missing or not a valid date.";
} else {
    if ($d->format("Y-m-d") == $dob) {
        $today = new DateTime("today");
        $age   = $d->diff($today)->y;
        if ($d > $today || $age < 18 || $age > 80) {
            $errors[] = "Applicant age must be between 18 and 80.";
        }
    } else {
        $errors[] = "Date of birth is missing or not a valid date.";
    }
}

if (in_array($gender, ["male", "female"], true) == false) {
    $errors[] = "Please select a gender.";
}

if (preg_match("/^[a-zA-Z0-9\s]{5,40}$/", $street) == 0) {
    $errors[] = "Street address must be 5-40 characters (letters, numbers, spaces).";
}

if (preg_match("/^[a-zA-Z\s]{2,40}$/", $suburb) == 0) {
    $errors[] = "Suburb/Town must be 2-40 letters or spaces.";
}

$valid_states = ["VIC","NSW","QLD","NT","WA","SA","TAS","ACT"];
if (in_array($state, $valid_states, true) == false) {
    $errors[] = "Please select a valid state.";
}
if (preg_match("/^[0-9]{4}$/", $postcode) == 0) {
    $errors[] = "Postcode must be exactly 4 digits.";
} elseif (in_array($state, $valid_states, true) == true &&
          postcode_matches_state($state, $postcode) == false) {
    $errors[] = "Postcode $postcode does not match the selected state ($state).";
}

if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
    $errors[] = "Please enter a valid email address.";
}
if (preg_match("/^[0-9]{8,12}$/", $phone) == 0) {
    $errors[] = "Phone number must be 8-12 digits.";
}

$valid_roles = [
    "Front-End Developer", "Back-end Developer",
    "Vulnerability Analyst", "Helpdesk Technician"
];

if (in_array($role, $valid_roles, true) == false) {
    $errors[] = "Please select a desired role.";
}

if ($skills_invalid == true) {
    $errors[] = "An invalid skill was submitted.";
}

$skills_provided = (count($skills) > 0);
$other_provided  = (strlen($other) > 0);

if ($skills_provided == false && $other_provided == false) {
    $errors[] = "Select at least one skill or describe your skills in 'Other Skills'.";
}

if (strlen($other) > 1000) {
    $errors[] = "Describe your other skills with less than a 1000 characters.";
}

// upload validation, the upload file isnt moved at all, when completed validated here, it moves on

$allowed_extensions = ["pdf", "doc", "docx", "jpg", "jpeg", "png"];
$allowed_mimes = [
    "application/pdf",
    "application/msword",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    "image/jpeg",
    "image/png"
];

$max_file_size = 5 * 1024 * 1024;   // 5 MB

$pending_upload_tmp = null;         // temp path from PHP 
$pending_upload_ext = null;         // validated lowercase extension

if (isset($_FILES["uploaded_file"]) &&
    $_FILES["uploaded_file"]["error"] != UPLOAD_ERR_NO_FILE) {

    $file = $_FILES["uploaded_file"];

    if ($file["error"] == UPLOAD_ERR_OK) {

        $original_name = basename($file["name"]);
        $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

        if (in_array($ext, $allowed_extensions, true) == false) {
            $errors[] = "File type ." . h($ext) . " is not allowed. "
                      . "Allowed: " . implode(", ", $allowed_extensions) . ".";
        } elseif ($file["size"] > $max_file_size) {
            $errors[] = "File is too large. Maximum size is 5 MB.";
        } else {
            // find out real MIME/media type from file content causeee extension can be spoofed
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $file["tmp_name"]);
            

            if (in_array($mime, $allowed_mimes, true) == false) {
                $errors[] = "File content does not match an allowed type.";
            } else {
                $pending_upload_tmp = $file["tmp_name"];
                $pending_upload_ext = $ext;
            }
        }
    } elseif ($file["error"] == UPLOAD_ERR_INI_SIZE ||
              $file["error"] == UPLOAD_ERR_FORM_SIZE) {
        $errors[] = "File is too large.";
    } else {
        $errors[] = "File upload failed (error code " . (int)$file["error"] . ").";
    }
}

//5. show the user the errors when form isnt right
function page_start($title) {
    echo "<!DOCTYPE html><html lang='en'><head><meta charset='utf-8'>
          <title>$title</title><link href='Styles.css' rel='stylesheet'></head><body>
          <h1 class='h1forapply'>$title</h1>";
}

function page_end() { echo "</body></html>"; }

if (count($errors) > 0) {
    page_start("Application Error");
    echo "<p>Please fix the following and try again:</p><ul>";
    foreach ($errors as $e) {
        echo "<li>" . h($e) . "</li>";
    }
    echo "</ul><p><a href='apply.php'>&laquo; Back to application form</a></p>";
    page_end();
    exit();
}

//6. mysql table for connection, creation, insert, whatever etc 
mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect($host, $user, $pwd, $dbname);
if ($conn == false) {
    page_start("Database Error"); //check the database at myphpadmin, either delete the current table or make a new one with the same name fintech_db
    echo "<p>Sorry, we could not connect to the database. Please try again later.</p>";
    page_end();
    exit();
}
mysqli_set_charset($conn, "utf8mb4");

$create_sql = "CREATE TABLE IF NOT EXISTS eoi (
    EOInumber      INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Ref_ID         VARCHAR(5)   NOT NULL,
    First_Name     VARCHAR(20)  NOT NULL,
    Last_Name      VARCHAR(20)  NOT NULL,
    Date_Of_Birth  DATE         NOT NULL,
    Gender         VARCHAR(10)  NOT NULL,
    Street_Address VARCHAR(100) NOT NULL,
    Suburb         VARCHAR(100) NOT NULL,
    State          VARCHAR(3)   NOT NULL,
    Postcode       CHAR(4)      NOT NULL,
    Email          VARCHAR(255) NOT NULL,
    Phone_Number   VARCHAR(12)  NOT NULL,
    Desired_Role   VARCHAR(50)  NOT NULL,
    Skills         VARCHAR(255) NOT NULL DEFAULT '',
    Other_Skills   TEXT,
    Uploaded_File  VARCHAR(255) DEFAULT NULL,
    Status         ENUM('New','Current','Final') NOT NULL DEFAULT 'New',
    Submitted_At   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (mysqli_query($conn, $create_sql) == false) {
    page_start("Database Error");
    echo "<p>Could not prepare the database table.</p>";
    page_end();
    mysqli_close($conn);
    exit();
}

//move file uploaded (if any)
$uploaded_file = null;
$uploaded_abspath = null;

if ($pending_upload_tmp !== null) {
    $upload_dir = __DIR__ . "/uploads/";
    if (is_dir($upload_dir) == false) {
        mkdir($upload_dir, 0755, true);
    }

    // dont use user's file name to keep uploads, make new file name for user uploads for securityt
    $safe_name = uniqid("eoi_", true) . "." . $pending_upload_ext;
    $uploaded_abspath = $upload_dir . $safe_name;

    if (move_uploaded_file($pending_upload_tmp, $uploaded_abspath) == false) {
        page_start("Upload Error");
        echo "<p>Could not save the uploaded file. Please try again.</p>";
        echo "<p><a href='apply.php'>&laquo; Back to application form</a></p>";
        page_end();
        mysqli_close($conn);
        exit();
    }
    $uploaded_file = $safe_name;
}

//Prepare INSERT (15 placeholders)
$stmt = mysqli_prepare($conn,
    "INSERT INTO eoi (Ref_ID, First_Name, Last_Name, Date_Of_Birth, Gender,
        Street_Address, Suburb, State, Postcode, Email, Phone_Number,
        Desired_Role, Skills, Other_Skills, Uploaded_File)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt == false) {
    // delete user uploads when mysqli_prepare fails to reference user upload to database row
    if ($uploaded_abspath !== null && file_exists($uploaded_abspath)) {
        @unlink($uploaded_abspath);
    }
    page_start("Database Error");
    echo "<p>Sorry, your application could not be saved. Please try again later.</p>";
    page_end();
    mysqli_close($conn);
    exit();
}

mysqli_stmt_bind_param($stmt, "sssssssssssssss",
    $ref_id, $fname, $lname, $dob, $gender, $street, $suburb, $state,
    $postcode, $email, $phone, $role, $skills_str, $other, $uploaded_file);

if (mysqli_stmt_execute($stmt) == true) {
    $eoi_number = mysqli_insert_id($conn);

    page_start("Application Submitted");
    echo "<p>Thank you, <strong>" . h($fname) . "</strong>. Your Submittion has been received.</p>";
    echo "<p>Your EOI number is: <strong>" . h($eoi_number) . "</strong></p>";
    if ($uploaded_file !== null) {
        echo "<p>Your uploaded file has been saved as <code>" . h($uploaded_file) . "</code>.</p>";
    }
    echo "<p>Please do keep EOI number for reference.</p>";
    echo "<p><a href='index.php'>Return to Home</a></p>";
    page_end();
} else {
    // statement valid but failed to INSERT row due to constrait violation or Database disk space full etc so delete user uploadd
    if ($uploaded_abspath !== null && file_exists($uploaded_abspath)) {
        @unlink($uploaded_abspath);
    }
    page_start("Database Error");
    echo "<p>Something went wrong, the application isn't properly submitted. Try again next time.</p>";
    page_end();
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>