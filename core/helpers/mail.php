<?php

use PHPMailer\PHPMailer\PHPMailer;

function sendMail($email, $subject, $html)
{
    if ($email == "" || strlen($email) < 6)
        return;
    $mail = new PHPMailer();
    // configure an SMTP
    /*
    $mail->isSMTP();
    $mail->Host = 'smtps.aruba.it';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@domain.com';
    $mail->Password = '';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465; // */
    //$mail->SMTPDebug = 2;

    $mail->setFrom('info@domain.it', TITLE);
    $mail->addAddress($email);
    //$mail->addBCC("andryu89@gmail.com");
    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->Body = $html;
    $mail->Subject = $subject;

    if (!$mail->send()) {
        return $mail->ErrorInfo;
    } else {
        return "OK";
    }
}

function warningMail($mail, $info, $type, $messages = [])
{
    if (!MAIL_ENABLED) {
        //echo "mail disabilitata!";
        return;
    }
    require_once BASE_PATH . "app/views/warning.view.php";
    $msg = getMail($info, $messages, $type);
    return sendMail($mail, "Sentinel " . $type, $msg);
}

function sendTestSms($number, $info, $type)
{
    if (!SMS_ENABLED) {
        //echo "sms disabilitato!";
        return;
    }
    if ($number == "")
        return;

    $url = "https://www.ovh.com/cgi-bin/sms/http2sms.cgi";

    $account = "sms-";
    $login = "test";
    $password = "";
    $from = "aaa";
    $message = $type . " sullo strumento %s! Accedi a %s per verificare la situazione!";
    $message = sprintf($message, $info["strmnt_desc"], SITE_URL);

    $res = curl_get($url, [], [
        "account" => $account,
        "login" => $login,
        "password" => $password,
        "to" => $number,
        "from" => $from,
        "message" => $message
    ]);
    //print_r($res);
}
