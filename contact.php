<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load PHPMailer classes
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and sanitize input
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'mail.npgestateandhomes.com.ng'; // SMTP host from your hosting
        $mail->SMTPAuth = true;
        $mail->Username = 'info@npgestateandhomes.com.ng'; // Your email
        $mail->Password = '@NPGestate@123'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL encryption
        $mail->Port = 465;

        // Sender and recipient
        $mail->setFrom('info@npgestateandhomes.com.ng', 'Baba Lawan Empowerment');
        $mail->addAddress('info@npgestateandhomes.com.ng'); // Receiver (same as sender here)

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Message from Website";
        $mail->Body = "
            <h3>New Contact Message</h3>
            <p><strong>Name:</strong> {$first_name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone:</strong> {$phone}</p>
            <p><strong>Subject:</strong> {$subject}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";

        $mail->AltBody = "Name: {$first_name}\nEmail: {$email}\nPhone: {$phone}\nSubject: {$subject}\nMessage:\n{$message}";

        // Send email
        $mail->send();

        // Show success message and redirect back or to thank-you page
        echo "<script>alert('Thank you! Your message has been sent successfully.'); window.location.href='index.html';</script>";
        exit;

    } catch (Exception $e) {
        // Show error message
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.history.back();</script>";
        exit;
    }
} else {
    // If someone opens contact.php directly
    echo "Access Denied.";
}
?>
