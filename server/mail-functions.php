<?php
function sendMail($receiver, $mailSubject, $mailBody) {
    require("../server/PHPMailer/src/PHPMailer.php");
    require("../server/PHPMailer/src/SMTP.php");
    require("../server/PHPMailer/src/Exception.php");

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";
    $mail->CharSet= "UTF-8";
    $mail->Host = "smtp.poczta.onet.pl";
    $mail->SMTPDebug = 0;
    $mail->Port = 465 ;
    $mail->SMTPSecure = 'ssl';
    $mail->SMTPAuth = true;
    $mail->Username = "jobsearch.website@op.pl"; // we using 'onet.poczta.pl' server
    $mail->Password = "HardPassword123_"; // yes you can log in this is temporary client
    $mail->setFrom('jobsearch.website@op.pl', 'Job Search Website Bot');
    $mail->AddAddress($receiver);
    $mail->Subject = $mailSubject;
    $mail->Body = $mailBody;
    $mail->IsHTML(true);

    return $mail->Send();
}

?>