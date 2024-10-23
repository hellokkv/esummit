<?php
include 'db.php';  // Database connection
require 'vendor/autoload.php';  // Autoload for the QR code and PDF libraries

use Endroid\QrCode\QrCode;
use Dompdf\Dompdf;
use Endroid\QrCode\Writer\PngWriter;

if (isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];

    // Fetch user details from the database
    $sql = "SELECT * FROM after_payment WHERE transaction_id='$transaction_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $name = $user['name'];
        $email = $user['email'];
        $registration_id = $user['registration_id'];

        // Generate QR Code for the registration ID
        $qrCode = new QrCode($registration_id);
        $writer = new PngWriter();
        $qrCodeImage = $writer->write($qrCode);

        // Save the QR code image to the server
        $qrCodePath = 'qrcodes/' . $registration_id . '.png';
        file_put_contents($qrCodePath, $qrCodeImage->getString());

        // Generate the HTML for the invoice
        ob_start();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Invoice</title>
            <style>
                .invoice-box {
                    max-width: 800px;
                    margin: auto;
                    padding: 30px;
                    border: 1px solid #eee;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
                    font-size: 16px;
                    line-height: 24px;
                }
                .qr-code {
                    width: 150px;
                    height: 150px;
                }
            </style>
        </head>
        <body>
            <div class="invoice-box">
                <h2>Invoice</h2>
                <p><strong>Name:</strong> <?php echo $name; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
                <p><strong>Transaction ID:</strong> <?php echo $transaction_id; ?></p>
                <p><strong>Registration ID:</strong> <?php echo $registration_id; ?></p>
                <img src="<?php echo $qrCodePath; ?>" alt="QR Code" class="qr-code"><br>
                <p>Scan this QR code for verification at the event.</p>
            </div>
        </body>
        </html>
        <?php
        $html = ob_get_clean();

        // Create a PDF from the HTML using Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Output the generated PDF to the browser
        $dompdf->stream("invoice_$registration_id.pdf", ["Attachment" => 0]);
    } else {
        echo "Transaction not found.";
    }
}
$conn->close();
?>
