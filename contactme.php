<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0; 
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tgnsystemslimited@gmail.com';
        $mail->Password = 'eeiw ctky fugd wqha';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('tgnsystemslimited@gmail.com', 'TGN SYTEMS');
        $mail->addAddress('sales@tgnsystems.org', 'Sales');
        $mail->addBCC('kayiwa.rahim@tgnsystems.org', 'Kayiwa Rahim');
        $mail->addBCC('kayiwarahim@gmail.com', 'Kayiwa Rahim');
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Clients contact submission';
        $mail->Body    = "<b>Name      </b>    : $name<br>
                          <b>Contact Number</b> : $phone<br>
                          <b>Email     </b>     : $email<br>
                          <b>Message  </b>      : $message";

        $mail->send();
        $response['status'] = 'success';
        $response['message'] = 'Message has been sent successfully!';

    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    echo json_encode($response);
    exit();
} else {
    header('HTTP/1.0 405 Method Not Allowed');
    $response['status'] = 'error';
    $response['message'] = 'Method Not Allowed';
    echo json_encode($response);
    exit();
}
