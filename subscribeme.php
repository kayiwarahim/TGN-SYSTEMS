<?php
// Load Composer's autoloader for PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Set the content type to JSON for the response
header('Content-Type: application/json');

// Initialize the response array to capture status and messages
$response = array();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email address from the POST request
    $email = $_POST['email'];

    // Create a new instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings for SMTP
        $mail->SMTPDebug = 0;                                  // Disable verbose debug output
        $mail->isSMTP();                                       // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                        // Specify the SMTP server
        $mail->SMTPAuth = true;                                // Enable SMTP authentication
        $mail->Username = 'tgnsystemslimited@gmail.com';       // SMTP username
        $mail->Password = 'eeiw ctky fugd wqha';               // SMTP password (Ensure this is secure)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;    // Enable TLS encryption
        $mail->Port = 587;                                     // TCP port to connect to

        // Set the sender's email and name
        $mail->setFrom('tgnsystemslimited@gmail.com', 'TGN SYSTEMS');
        
        // Add recipients
        $mail->addAddress('sales@tgnsystems.org', 'Sales');    // Primary recipient
        $mail->addBCC('kayiwa.rahim@tgnsystems.org', 'Kayiwa Rahim'); // BCC recipients
        $mail->addBCC('kayiwarahim@gmail.com', 'Kayiwa Rahim');
        $mail->addAddress($email);                             // Send confirmation to the subscribing user's email

        // Set the email content
        $mail->isHTML(true);                                   // Set email format to HTML
        $mail->Subject = 'Clients Newsletter Subscription';    // Email subject
        $mail->Body    = "<b>Thank you for subscribing to our newsletters!</b>";  // Email body content

        // Send the email
        $mail->send();

        // Set success response
        $response['status'] = 'success';
        $response['message'] = 'Thank you for subscribing to our newsletter!';

    } catch (Exception $e) {
        // Set error response if email sending fails
        $response['status'] = 'error';
        $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // Output the response as JSON
    echo json_encode($response);
    exit();

} else {
    // Handle requests that are not POST
    header('HTTP/1.0 405 Method Not Allowed');               // Set HTTP status code 405
    $response['status'] = 'error';
    $response['message'] = 'Method Not Allowed';             // Error message for non-POST requests
    echo json_encode($response);
    exit();
}
?>
