<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class MailService {

    public static function send($to, $subject, $html) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['GMAIL_USER'];
            $mail->Password   = $_ENV['GMAIL_APP_PASS'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom($_ENV['GMAIL_USER'], 'GroupFour Library');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $html;

            $mail->send();

            return [
                "success" => true,
                "message" => "Email sent successfully"
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "message" => $mail->ErrorInfo
            ];
        }
    }
}