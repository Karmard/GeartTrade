<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoload file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "tomkarma13@gmail.com";
    $email = $_POST["email"];
    $message = $_POST["message"];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your@gmail.com'; // Your Gmail address
        $mail->Password   = 'your_password'; // Your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom($email);
        $mail->addAddress($to);
        $mail->isHTML(false);
        $mail->Subject = 'New Email from Gear Trade Hub';
        $mail->Body    = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
