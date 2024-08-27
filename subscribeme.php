<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0; // Change this to 0 to hide the debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'tgnsystemslimited@gmail.com'; // SMTP username
        $mail->Password = 'eeiw ctky fugd wqha'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('tgnsystemslimited@gmail.com', 'TGN SYTEMS ');
        $mail->addAddress('sales@tgnsystems.org', 'Sales'); // Add the first recipient
        $mail->addBCC('kayiwa.rahim@tgnsystems.org', 'Kayiwa Rahim');
        $mail->addBCC('kayiwarahim@gmail.com', 'Kayiwa Rahim');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Clients News Letter Subscription';
        $mail->Body    = "<b>thank you for subscribing to our news letters</b>";

        $mail->send();
        $response['status'] = 'success';
        $response['message'] = 'Thank you for subscribing to our news letter!';

    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

    }
    echo json_encode($response);
    exit();

}
?>
