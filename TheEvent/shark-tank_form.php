<?php
// Connect to the MySQL database
$servername = "localhost";
$username = "root"; // Use your MySQL username
$password = ""; // Use your MySQL password
$dbname = "esummit";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $phone_number = filter_var(trim($_POST['phone_number']), FILTER_SANITIZE_NUMBER_INT);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $team_lead = filter_var(trim($_POST['team_lead']), FILTER_SANITIZE_STRING);
    $domain = filter_var(trim($_POST['startup_domain']), FILTER_SANITIZE_STRING);

    // File upload handling
    $target_dir = "sharktank-uploads/"; // Folder where the uploaded files will be saved
    $file_name = basename($_FILES["file_upload"]["name"]);
    $target_file = $target_dir . uniqid() . "_" . $file_name; // Rename file to avoid conflicts
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Allow only PDF and PPT files
    if (!in_array($file_type, ['pdf', 'ppt', 'pptx'])) {
        echo "Sorry, only PDF, PPT, and PPTX files are allowed.";
        exit;
    }

    // Move the uploaded file to the "uploads" directory
    if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $target_file)) {
        // File uploaded successfully

        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO registrations (phone_number, email, team_lead, domain, uploaded_file) 
                                 VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $phone_number, $email, $team_lead, $domain, $target_file);

        if ($stmt->execute()) {
            // Redirect to a success page after successful registration
            header("Location: success.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Close the connection
$conn->close();
?>
