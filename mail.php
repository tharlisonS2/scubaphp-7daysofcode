<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMailConfirmation($email, $username, $url)
{
    $recipients = [
        "email" => $email,
        "username" => $username,
    ];

    $content = [
        "subject" => "Confirmação de email na ScubaPHP",
        "body" => "<a href='$url' >confirmar email</a>",
        "altBody" => "Copie e acesse o link para confirmar seu email: $url"
    ];
    sendEmail($recipients, $content);
}
function sendEmail(array $recipients, array $content)
{
    $mail = new PHPMailer(true);
    try {
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = HOST_ADDRESS;                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = GMAIL_USERNAME;                     //SMTP username
        $mail->Password = GMAIL_PASSWORD;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = STMP_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->CharSet = 'utf-8';
        //Recipients
        $mail->setFrom(GMAIL_USERNAME, EMAIL_TEAM_NAME);
        $mail->addAddress($recipients["email"], $recipients["username"]);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        $mail->isHTML(true);
        $mail->Subject = $content["subject"];
        $mail->Body = $content["body"];
        $mail->AltBody = $content["altBody"] ?? '';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

    }
}