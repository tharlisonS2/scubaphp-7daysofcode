<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader

//Create an instance; passing `true` enables exceptions

function sendMailConfirmation($token)
{

        $mail->addAddress($email, "username");     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Confirmação de email na ScubaPHP";
        $mail->Body = "<a href='http://localhost:8000?page=mail-validation&token='" . $token . ">confirmar email</a>";
        $mail->AltBody = "Copie e acesse o link para confirmar seu email: http://localhost:8000?page=mail-validation&token=" . $token;

        $mail->send();
        echo 'Message has been sent';
}
function sendEmail($token)
{
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
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
        $mail->addAddress($email, "username");     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');


        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Confirmação de email na ScubaPHP";
        $mail->Body = "<a href='http://localhost:8000?page=mail-validation&token='" . $token . ">confirmar email</a>";
        $mail->AltBody = "Copie e acesse o link para confirmar seu email: http://localhost:8000?page=mail-validation&token=" . $token;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

    }
}