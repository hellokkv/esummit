<?php
include 'db.php';  // Include database connection

// Capture the registration ID from the QR code URL
if (isset($_GET['registration_id'])) {
    $registration_id = $_GET['registration_id'];

    // Query the database for the registration ID
    $sql = "SELECT * FROM after_payment WHERE registration_id='$registration_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo "<h2>Verification Successful</h2>";
        echo "Welcome, " . $user['name'] . ". Your registration is verified.";
    } else {
        echo "Invalid QR code.";
    }
}
$conn->close();
?>
