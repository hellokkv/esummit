<?php
// Database configuration
$host = 'localhost';
$db_name = 'esummit';
$username = 'root';
$password = '';

// Create a database connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form inputs and sanitize them
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $email = $conn->real_escape_string($_POST['email']);
    $department = $conn->real_escape_string($_POST['department']);
    $year_of_study = $conn->real_escape_string($_POST['year_of_study']);
    $team_lead = $conn->real_escape_string($_POST['team_lead']);
    $startup_domain = $conn->real_escape_string($_POST['startup_domain']);

    // Prepare SQL statement to insert form data into the marketing_participants table
    $sql = "INSERT INTO marketing_participants (phone_number, email, department, year_of_study, team_lead, startup_domain)
            VALUES ('$phone_number', '$email', '$department', '$year_of_study', '$team_lead', '$startup_domain')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to Razorpay payment page after successful insertion
        header("Location: https://rzp.io/rzp/ikshiGenai");
        exit(); // Always exit after a redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Handle SQL error
    }
}

$conn->close();
?>
