<?php
// Active l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'config/config.php'; // Charge la configuration

function sendLoginNotification($userEmail, $userIP) {
    $mail = new PHPMailer(true);

    try {
        // Récupère l'URL principale
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $baseUrl = $protocol . '://' . $_SERVER['HTTP_HOST'];

        // Configuration SMTP depuis le fichier config
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;

        // Destinataires
        $mail->setFrom(SMTP_USER, 'Site Vitrine - JOHAAANNS');
        $mail->addAddress(SMTP_USER);

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "Nouvelle connexion sur " . $_SERVER['HTTP_HOST'];
        $mail->Body = "
            <h2>Nouvelle connexion sur votre site</h2>
            <p><strong>Domaine :</strong> " . $_SERVER['HTTP_HOST'] . "</p>
            <p><strong>URL :</strong> $baseUrl</p>
            <p><strong>Utilisateur :</strong> $userEmail</p>
            <p><strong>IP :</strong> $userIP</p>
            <p><strong>Date :</strong> " . date('d/m/Y H:i:s') . "</p>
        ";

        $mail->send();
        echo "✅ Email envoyé avec succès !";
        return true;

    } catch (Exception $e) {
        error_log("Erreur envoi email: " . $e->getMessage());
        return false;
    }
}

// Test
sendLoginNotification(SMTP_USER, $_SERVER['REMOTE_ADDR']);
?>
