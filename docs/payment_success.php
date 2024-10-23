<?php
include 'db.php';  // Include database connection

// Capture transaction details sent by the payment gateway
if (isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];

    // Fetch the user based on the transaction_id
    $sql = "SELECT * FROM after_payment WHERE transaction_id='$transaction_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Update the payment status to 'completed'
        $update_sql = "UPDATE after_payment SET payment_status='completed' WHERE transaction_id='$transaction_id'";
        if ($conn->query($update_sql) === TRUE) {
            // Redirect to the invoice generation page
            header("Location: generate_invoice.php?transaction_id=$transaction_id");
        } else {
            echo "Error updating payment status: " . $conn->error;
        }
    } else {
        echo "Transaction not found.";
    }
}
$conn->close();
?>
