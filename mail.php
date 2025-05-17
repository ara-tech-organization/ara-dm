<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "vendor/autoload.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Sanitize and validate form data
    $name = !empty($_POST["name"]) ? $_POST["name"] : '';
    $email = !empty($_POST["email"]) ? filter_var($_POST["email"], FILTER_SANITIZE_EMAIL) : '';
    $phone = !empty($_POST["phone"]) ? $_POST["phone"] : '';
    $message = !empty(trim($_POST["message"])) ? $_POST["message"] : '';

    // Check if all required fields are present
    if ($name == '' || $email == '' || $phone == '' || $message == '') {
        echo "All fields are required!";
    } else {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'aradiscovermarketing@gmail.com';  // Your email
            $mail->Password = 'ncnd pfku hxhl nkul';  // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Sender and recipient settings
            $mail->setFrom($email, $name);
            $mail->addAddress('aradiscovermarketing@gmail.com', 'Ara Discoveries Pvt Ltd');  // Change to recipient's email

            // Email content
            $mail->Subject = 'Ara Website - Contact Form Mail';
            $mail->Body = "Name: $name\n" .
                "Email: $email\n" .
                "Phone: $phone\n" .
                "Message: $message\n";

            // Send the email to your inbox
            if ($mail->send()) {
                // Auto-reply email to the sender
                $autoReply = new PHPMailer(true);
                try {
                    $autoReply->isSMTP();
                    $autoReply->Host = 'smtp.gmail.com';
                    $autoReply->SMTPAuth = true;
                    $autoReply->Username = 'aradiscovermarketing@gmail.com';  // Your email
                    $autoReply->Password = 'ncnd pfku hxhl nkul';  // App password
                    $autoReply->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $autoReply->Port = 587;

                    // Set sender and recipient for the auto-reply
                    $autoReply->setFrom('aradiscovermarketing@gmail.com', 'Ara Discoveries Pvt Ltd');  // Sender details
                    $autoReply->addAddress($email, $name);  // Send auto-reply to the sender

                    // Auto-reply content
                    $autoReply->Subject = "Thank you for contacting Ara Discoveries Pvt Ltd";
                    $autoReply->Body = "Thanks for reaching out to us. Our team will contact you within the next 24 hours.\n\n" .
                        "Best regards,\n" .
                        "Team - Ara Discoveries Pvt Ltd";

                    // Send the auto-reply
                    $autoReply->send();

                    // Redirect to contact.html page after successful form submission
                    header("Location: contact.html");
                    exit();
                } catch (Exception $e) {
                    echo "Auto-reply could not be sent. Error: " . $e->getMessage();
                }
            } else {
                echo "Message could not be sent. Error: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Exception Error: " . $e->getMessage();
        }
    }
}
?>


<!-- aradiscovermarketing@gmail.com - app password : ncnd pfku hxhl nkul  -->
<!-- yuvayogi.ara@gmail.com - app password : obdu jfei kvwu gnxa  -->