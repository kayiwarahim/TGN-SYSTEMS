<?php   
    // Load Composer's autoloader
    require 'vendor/autoload.php';
    
    // Use the necessary PHPMailer classes
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Set the header to indicate JSON response
    header('Content-Type: application/json');

    // Retrieve form data from POST request
    $name = $_POST["name"];
    $phone = $_POST['phone'];
    $email = $_POST["email"];
    $applyfor = $_POST["status"];
    $experience = $_POST["experience"];
    $otherdetails = $_POST["details"];

    // Retrieve file details from the form submission
    $filename = $_FILES["fileToUpload"]["name"];
    $filetype = $_FILES["fileToUpload"]["type"];
    $filesize = $_FILES["fileToUpload"]["size"];
    $tempfile = $_FILES["fileToUpload"]["tmp_name"];

    // Directory to save the uploaded CV
    $uploadDir = "cv-uploads/";
    $filenameWithDirectory = $uploadDir . $name . ".pdf";  // Save file with the applicant's name as the filename

    // Create the upload directory if it does not exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Initialize the response array to store the status and message
    $response = [];

    // Construct the email body with applicant's details
    $body = "<ul>
                <li>Name: $name</li>
                <li>Phone: $phone</li>
                <li>Email: $email</li>
                <li>Apply For: $applyfor</li>
                <li>Experience: $experience Yrs.</li>
                <li>Resume: Attached Below</li>
             </ul>";

    // Move the uploaded file to the specified directory
    if (move_uploaded_file($tempfile, $filenameWithDirectory)) {
        $mail = new PHPMailer(true); // Instantiate PHPMailer

        try {
            // Server settings for sending email via SMTP
            $mail->isSMTP();                                            // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                             // Specify main SMTP server
            $mail->SMTPAuth = true;                                     // Enable SMTP authentication
            $mail->Username = 'tgnsystemslimited@gmail.com';            // SMTP username
            $mail->Password = 'eeiw ctky fugd wqha';                    // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
            $mail->Port = 587;                                          // TCP port to connect to

            // Recipients
            $mail->setFrom('tgnsystemslimited@gmail.com', 'TGN SYSTEMS'); // Sender email
            $mail->addAddress('sales@tgnsystems.org', 'Sales');           // Primary recipient
            $mail->addBCC('kayiwa.rahim@tgnsystems.org', 'Kayiwa Rahim'); // Add BCC recipients
            $mail->addBCC('kayiwarahim@gmail.com', 'Kayiwa Rahim');

            // Attachments
            $mail->addAttachment($filenameWithDirectory);                // Attach the uploaded CV file

            // Content
            $mail->isHTML(true);                                         // Set email format to HTML
            $mail->Subject = 'Job Application: ' . $applyfor;            // Email subject
            $mail->Body    = $body;                                      // Email body content

            // Send the email
            $mail->send();

            // Set success response
            $response['status'] = 'success';
            $response['message'] = 'Application and CV have been sent successfully!';
        } catch (Exception $e) {
            // Set error response if email could not be sent
            $response['status'] = 'error';
            $response['message'] = "Application and CV could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Set error response if file upload fails
        $response['status'] = 'error';
        $response['message'] = 'Error uploading file! Please try again.';
    }

    // Output the response as JSON
    echo json_encode($response);
    exit(); // Terminate script execution
?>
