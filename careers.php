<?php   
    require 'vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    header('Content-Type: application/json'); // Add this to ensure the response is JSON

    $name = $_POST["name"];
    $phone = $_POST['phone'];
    $email = $_POST["email"];
    $applyfor = $_POST["status"];
    $experience = $_POST["experience"];
    $otherdetails = $_POST["details"];

    $filename = $_FILES["fileToUpload"]["name"];
    $filetype = $_FILES["fileToUpload"]["type"];
    $filesize = $_FILES["fileToUpload"]["size"];
    $tempfile = $_FILES["fileToUpload"]["tmp_name"];
    $uploadDir = "cv-uploads/";
    $filenameWithDirectory = $uploadDir . $name . ".pdf";  // specify the correct path to the tmp-uploads directory

    // Create directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $response = []; // Initialize the response array

    $body = "<ul>
                <li>Name: $name</li>
                <li>Phone: $phone</li>
                <li>Email: $email</li>
                <li>Apply For: $applyfor</li>
                <li>Experience: $experience Yrs.</li>
                <li>Resume: Attached Below</li>
             </ul>";

    if (move_uploaded_file($tempfile, $filenameWithDirectory)) {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'tgnsystemslimited@gmail.com'; // SMTP username
            $mail->Password = 'eeiw ctky fugd wqha'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;                                   // TCP port to connect to, use 465 for SSL

            //Recipients
            $mail->setFrom('tgnsystemslimited@gmail.com', 'TGN SYSTEMS');
            $mail->addAddress('sales@tgnsystems.org', 'Sales'); // Add the first recipient
            $mail->addBCC('kayiwa.rahim@tgnsystems.org', 'Kayiwa Rahim');
            $mail->addBCC('kayiwarahim@gmail.com', 'Kayiwa Rahim');                 // Add a recipient

            // Attachments
            $mail->addAttachment($filenameWithDirectory);               // Add the uploaded file as an attachment

            // Content
            $mail->isHTML(true);                                        // Set email format to HTML
            $mail->Subject = 'Job Application: ' . $applyfor;
            $mail->Body    = $body;

            $mail->send();
            $response['status'] = 'success';
            $response['message'] = 'Application and CV have been sent successfully!';
        } catch (Exception $e) {
            $response['status'] = 'error';
            $response['message'] = "Application and CV could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error uploading file! Please try again.';
    }

    echo json_encode($response); // Send the response as JSON
    exit();
?>
