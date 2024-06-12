<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

        require 'phpmailer/src/Exception.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';

            function sendEmail($to, $subject, $message) 
            {
                $mail = new PHPMailer(true);

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'tomkarma13@gmail.com';
                    $mail->Password = 'qjfjzcqryvwklqka';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                        $mail->setFrom('tomkarma13@gmail.com');
                        $mail->addAddress($to);

                        $mail->isHTML(true);

                    $mail->Subject = $subject;
                    $mail->Body = nl2br($message);

                    $mail->send();
                    return true;
                } 
                catch (Exception $e) 
                {
                    return false;
                }
            }

