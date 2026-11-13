<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="Job Application Form">
  <meta name="keywords" content="HTML, Form, tags">
  <meta name="author" content="Danial, Ryan">
  <title>Job Application Form</title>
  <link href="Styles.css" rel="stylesheet">

  <style>
    .form-section { 
      transition: transform 0.3s ease-in-out; 
    }

    .form-section:hover { 
      transform: scale(1.1); background-color: lightcyan; 
    }
  </style>
</head>

<body>

<header class="top_area">
  <a href="#" class="logo">
    <img src="images/FINTECH_LOGO.jpeg" alt="Fintech Logo" height="65rem" width="250rem">
  </a>

  <nav class="navigation">
    <a href="index.php">Home</a>
    <a href="jobs.php">Jobs</a>
    <a href="about.php">About</a>
    <a href="manage.php">Manage</a>
  </nav>

  <div class="searchbar">
    <input type="text" placeholder="Search...">
    <button type="submit"><i class="fa fa-search"></i></button>
  </div>
</header>

<h1 class="h1forapply">JOB APPLICATION FORM</h1>

<!-- dont touch form methods  -->
<form method="post" action="process_eoi.php" enctype="multipart/form-data" novalidate>
  <div class="form-container">

    <div class="left-column">

      <fieldset class="form-section">
        <legend>Personal Information</legend>

        <label for="Ref_ID">Job Reference ID:</label>
        <select name="Ref_ID" id="Ref_ID" required>
          <option value="">Please Select</option>
          <option value="JN023">JN023 - Front-End Developer</option>
          <option value="JN024">JN024 - Back-end Developer</option>
          <option value="JN025">JN025 - Vulnerability Analyst</option>
          <option value="JN026">JN026 - Helpdesk Technician</option>
        </select>

        <label for="First_Name">First Name:</label>
        <input type="text" name="First_Name" id="First_Name"
               pattern="[a-zA-Z]{2,20}" required>

        <label for="Last_Name">Last Name:</label>
        <input type="text" name="Last_Name" id="Last_Name"
               pattern="[a-zA-Z]{2,20}" required>

        <label for="Date_Of_Birth">Date of Birth:</label>
        <input type="date" name="Date_Of_Birth" id="Date_Of_Birth" required>

        <div class="gender-group">
          <p class="field-label">Gender</p>
          <label class="input-option">
            <input type="radio" name="gender" value="male"> Male
          </label>
          <label class="input-option">
            <input type="radio" name="gender" value="female"> Female
          </label>
        </div>
        <br>

        <label for="Street_Address">Street Address:</label>
        <input type="text" name="Street_Address" id="Street_Address"
               pattern="[a-zA-Z0-9\s]{5,40}" required>

        <label for="Suburb">Suburb/Town:</label>
        <input type="text" name="Suburb" id="Suburb"
               pattern="[a-zA-Z\s]{5,40}" required>

        <label for="State">State:</label>
        <select name="State" id="State" required>
          <option value="">Please Select</option>
          <option value="VIC">Victoria</option>
          <option value="NSW">New South Wales</option>
          <option value="QLD">Queensland</option>
          <option value="NT">Northern Territory</option>
          <option value="WA">Western Australia</option>
          <option value="SA">South Australia</option>
          <option value="TAS">Tasmania</option>
          <option value="ACT">Australian Capital Territory</option>
        </select>

        <label for="Postcode">Postcode:</label>
        <input type="text" name="Postcode" id="Postcode"
               pattern="[0-9]{4}" placeholder="Eg. 3000" required>

        <label for="Email">Email:</label>
        <input type="email" name="Email" id="Email"
               placeholder="Eg. example@email.com" required>

        <label for="Phone_Number">Phone Number:</label>
        <input type="text" name="Phone_Number" id="Phone_Number"
               pattern="[0-9]{8,12}" placeholder="Enter phone number" required>

      </fieldset>

      <div class="desired-column">
        <fieldset class="form-section">
          <legend>Desired Role:</legend>

          <label class="input-option">
            <input type="radio" name="Desired_Role" value="Front-End Developer" required>
            <span>Front-End Developer</span>
          </label>
          <label class="input-option">
            <input type="radio" name="Desired_Role" value="Back-end Developer" required>
            <span>Back-end Developer</span>
          </label>
          <label class="input-option">
            <input type="radio" name="Desired_Role" value="Vulnerability Analyst" required>
            <span>Vulnerability Analyst</span>
          </label>
          <label class="input-option">
            <input type="radio" name="Desired_Role" value="Helpdesk Technician" required>
            <span>Helpdesk Technician</span>
          </label>
        </fieldset>
      </div>

    </div>

    <div class="right-column">
      <fieldset class="form-section">
        <legend>Soft/Technical Skills:</legend>

        <label class="input-option">
          <input type="checkbox" name="Skill_List[]" value="Communication" checked>
          <span>Communication</span>
        </label>
        <label class="input-option">
          <input type="checkbox" name="Skill_List[]" value="Teamwork">
          <span>Teamwork</span>
        </label>
        <label class="input-option">
          <input type="checkbox" name="Skill_List[]" value="Problem_Solving">
          <span>Problem Solving</span>
        </label>
        <label class="input-option">
          <input type="checkbox" name="Skill_List[]" value="Adaptability">
          <span>Adaptability</span>
        </label>
        <label class="input-option">
          <input type="checkbox" name="Skill_List[]" value="Computer_Literacy">
          <span>Computer Literacy</span>
        </label>
        <label class="input-option">
          <input type="checkbox" name="Skill_List[]" value="Spreadsheet_Modelling_Master">
          <span>Spreadsheet and Modelling Mastery</span>
        </label>
        <label class="input-option">
          <input type="checkbox" name="Skill_List[]" value="Programming">
          <span>Programming</span>
        </label>
        <label class="input-option">
          <input type="checkbox" name="Skill_List[]" value="Cybersecurity">
          <span>Cybersecurity</span>
        </label>
        <label class="input-option">
          <input type="checkbox" name="Skill_List[]" value="Data_Science_Analytics">
          <span>Data Science and Analytics</span>
        </label>

        <label for="Other_Skills">Other Skills or previous work experience:</label>
        <textarea placeholder="Please specify any other relevant skills..."
                  name="Other_Skills" id="Other_Skills" rows="25" cols="40"></textarea>

        <label for="file-upload">Upload Qualifications or Certificates of Achievement (max 5 MB):</label>
        <!-- dont change this either, it's how a candidate uploads their credentials -->
        <input type="file"
               id="file-upload"
               name="uploaded_file"
               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
               class="file-button">
      </fieldset>
    </div>

    <div class="submit-button-container">
      <input type="submit" value="Submit" class="submit-button">
    </div>

  </div>
</form>

<footer>
  <p style="font-weight: bold; color: darkblue">
    My Sources:<br>MADCAP<br>Indeed<br>OrgChart<br>Fortinet<br>Unihackers<br>Interview Kickstart<br>Gemini<br>
    <a href="https://ryanstothard.atlassian.net/jira/software/projects/WEB/boards/2/backlog" target="_blank">
      <img src="images/jira.webp" alt="Jira" title="Jira" width="35" height="35">
    </a>
    <a href="https://github.com/Paveteran69/Applied-Web-Project.git" target="_blank">
      <img src="images/github.webp" alt="GitHub" title="GitHub" width="35" height="35">
    </a><br>
    Contact us: <a href="mailto:info@fintech.com">info@fintech.com</a><br>
    &copy;2026 FinTech. All rights reserved.
  </p>
</footer>

</body>
</html>