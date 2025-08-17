<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


$fromEmail = filter_var($_POST['fromEmail'], FILTER_VALIDATE_EMAIL);
$toEmail   = filter_var($_POST['toEmail'], FILTER_VALIDATE_EMAIL);
$fromName  = htmlspecialchars(strip_tags($_POST['fromName']));
$toName    = htmlspecialchars(strip_tags($_POST['toName']));
$subject   = htmlspecialchars(strip_tags($_POST['subject']));
$body      = $_POST['body']; 

if (!$fromEmail || !$toEmail || empty($fromName) || empty($toName) || empty($subject) || empty($body)) {
    die('<p style="color:red; text-align:center;">Invalid input. Please fill all fields correctly.</p>');
}

$mail = new PHPMailer(true);

try {
   
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host       = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth   = true;
    $mail->Username   = '5c27d4d58d838e';
    $mail->Password   = '28f0c3b68f201d';
    $mail->Port       = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => true,
            'verify_peer_name' => true,
            'allow_self_signed' => false
        ]
    ];

   
    $mail->setFrom($fromEmail, $fromName);
    $mail->addAddress($toEmail, $toName);

   
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = strip_tags($body);

    $mail->send();
    echo '<p style="color:green; text-align:center;">Message has been sent successfully!</p>';
} catch (Exception $e) {
    echo "<p style='color:red; text-align:center;'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>";
}
