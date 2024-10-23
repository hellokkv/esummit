<?php
// expo.php (handling form submission)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root"; // Change if needed
    $password = ""; // Change if needed
    $dbname = "esummit";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Capture form data
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $year_of_study = $_POST['year_of_study'];
    $team_lead_name = $_POST['team_lead'];
    $startup_domain = $_POST['startup_domain'];
    $booth_preference = $_POST['booth_preference'];

    // Prepare SQL query to insert data into the expo table
    $sql = "INSERT INTO expo (phone_number, email, department, year_of_study, team_lead_name, startup_domain, booth_preference)
            VALUES ('$phone_number', '$email', '$department', '$year_of_study', '$team_lead_name', '$startup_domain', '$booth_preference')";

    // Execute query and check if successful
    if ($conn->query($sql) === TRUE) {
        // Redirect to success page after successful insertion
        header("Location: success.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>
