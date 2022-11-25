<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer();
$mail->IsSMTP();

$mensaje = 'hola';

$mail->SMTPAuth = true;
$mail->SMTPSecure = "STARTTLS";
$mail->Host = "smtp-mail.outlook.com";
$mail->Port = 587;
$mail->Username = "SanatorioModelosaWeb@outlook.com";
$mail->Password = "Acreta123";


$mail->From = "SanatorioModelosaWeb@outlook.com";

$mail->FromName = "SanatorioModelosaWeb@outlook.com";

$mail->Subject = "SanatorioModelosaWeb@outlook.com";

$mail->Body = $mensaje;

$mail->AddAddress("oscarguerrero@sanatoriomodelosa.com.ar");

$mail->IsHTML(true);
if(!$mail->Send()) {
    echo "Error: " . $mail->ErrorInfo;
} else {
    echo "Mensaje enviado!";
}

