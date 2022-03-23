<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
if(!isset($_POST['raw_data'])) {
    //Not receiving a webhook
    die;
}

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $_ENV['MAILGUN_SMTP_SERVER'];           //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV['MAILGUN_SMTP_LOGIN'];            //SMTP username
    $mail->Password   = $_ENV['MAILGUN_SMTP_PASSWORD'];         //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = $_ENV['MAILGUN_SMTP_PORT'];             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('hcs.notifications@'.$_ENV['MAILGUN_DOMAIN'], 'HCS Notifications');
    $mail->addAddress($_ENV['YOUR_EMAIL']);              

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    
    $mail->Subject = 'New Event: '.ucwords(str_replace("_"," ",$_POST['raw_data']['action_type']));

    //HTML email
    $mail->Body    = $_POST['raw_data']['event_html'];

    //Raw text email, for email clients that don't support HTML
    $mail->AltBody = strip_tags($_POST['raw_data']['event_html'])."\n\nURL: https://hackcyber.space/events.php?search=".$_POST['raw_data']['id'];

    $mail->send();
    error_log('Message has been sent');
} catch (Exception $e) {
    error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
}

?>