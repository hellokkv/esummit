<?php
// Database configuration
$host = 'localhost'; // Change if your database is hosted elsewhere
$db_name = 'esummit';
$username = 'root'; // Change to your database username
$password = ''; // Change to your database password

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure correct array keys
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $email = $conn->real_escape_string($_POST['email']);
    $department = $conn->real_escape_string($_POST['department']); // Ensure this matches the HTML form field name
    $year_of_study = $conn->real_escape_string($_POST['year_of_study']);
    $team_lead = $conn->real_escape_string($_POST['team_lead']);
    $startup_domain = $conn->real_escape_string($_POST['startup_domain']);
    
    // Handle file upload
    $file_upload = $_FILES['file_upload']['name'];
    $file_tmp = $_FILES['file_upload']['tmp_name'];
    $file_destination = 'ideathon-uploads/' . $file_upload; // Adjust the upload path as necessary

    // Check if the file was uploaded successfully
    if (!empty($file_upload) && move_uploaded_file($file_tmp, $file_destination)) {
        // Prepare SQL statement
        $sql = "INSERT INTO ideathon_participants (phone_number, email, department, year_of_study, team_lead, startup_domain, file_upload)
                VALUES ('$phone_number', '$email', '$department', '$year_of_study', '$team_lead', '$startup_domain', '$file_upload')";
        
        if ($conn->query($sql) === TRUE) {
            // Redirect to Razorpay payment gateway after successful registration
            header("Location: https://rzp.io/rzp/ikshigen");
            exit(); // Ensure no further code is executed after redirection
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload file.";
    }
}

// Close the connection
$conn->close();
?>
