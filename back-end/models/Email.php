<?php
require_once(__DIR__ . "/../PHPMailer-6.10.0/init.php");
require_once(__DIR__ . "/../config/config.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.hostinger.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'no-reply@melonmind.app';
            $this->mail->Password = $_ENV["email_password"];
            $this->mail->SMTPSecure = 'ssl';
            $this->mail->Port = 465;
            
            // Configuración de codificación UTF-8
            $this->mail->CharSet = PHPMailer::CHARSET_UTF8;
            $this->mail->Encoding = 'base64';

            // Remitente predeterminado
            $this->mail->setFrom('no-reply@melonmind.app', 'Melon Mind');

        } catch (Exception $e) {
            throw new Exception("Error al configurar PHPMailer: " . $e->getMessage());
        }
    }

    public function send($toEmail, $toName, $subject, $body) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($toEmail, $toName);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            throw new Exception("Error al enviar correo: " . $this->mail->ErrorInfo);
        }
    }
}