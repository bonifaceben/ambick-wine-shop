<?php
// Hide errors in production (set to 1 only while testing)
ini_set('display_errors', 0);
error_reporting(0);

// Load PHPMailer
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitize form inputs (MATCHES YOUR FORM)
    $name    = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email   = htmlspecialchars(trim($_POST['email'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    $mail = new PHPMailer(true);

    try {

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'mail.k5hotel.com.ng';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@k5hotel.com.ng';
        $mail->Password   = '@k5hotel@123';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Sender & Recipient
        $mail->setFrom('info@k5hotel.com.ng', 'K5 Hotel Website');
        $mail->addAddress('info@k5hotel.com.ng');
        $mail->addReplyTo($email, $name);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Message from K5 Hotel Website";

        $mail->Body = "
            <h3>New Contact Message</h3>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Subject:</strong> {$subject}</p>
            <p><strong>Message:</strong><br>{$message}</p>
        ";

        $mail->AltBody = 
            "Name: {$name}\n" .
            "Email: {$email}\n" .
            "Subject: {$subject}\n\n" .
            "Message:\n{$message}";

        $mail->send();

        echo "OK";
        exit;

    } catch (Exception $e) {
        echo "Message could not be sent.";
        exit;
    }

} else {
    echo "Invalid Request.";
}
?>
