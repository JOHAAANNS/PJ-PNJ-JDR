<?php
header('Content-Type: application/json');
session_start();

define('IN_APP', true);
require '../cnx/cnx_info.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require '../vendor/autoload.php';
require '../fonctions/fonction.php';
require_once '../config/config.php'; // Charge la configuration

$mail = new PHPMailer(true);
$mail->setLanguage('fr', 'language/');
// ==============================================
// Initialisation
// ==============================================
$response = [
    'success' => false,
    'message' => '',
    'redirect' => '/index.php' // Valeur par défaut
];

/****Envoi mail**/
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
        /*echo "✅ Email envoyé avec succès !";*/
        return true;

    } catch (Exception $e) {
        error_log("Erreur envoi email: " . $e->getMessage());
        return false;
    }
}
// ==============================================
// Protection CSRF Renforcée
// ==============================================
if (empty($_POST['csrf_token_login']) || empty($_SESSION['csrf_token'])) {
    die("Token CSRF manquant");
}

if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token_login'])) {
    // Recréer un token au lieu de bloquer
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Message d'erreur spécifique
    $response = [
        'success' => false,
        'message' => 'Session expirée, veuillez réessayer',
        'new_token' => $_SESSION['csrf_token'] // Envoyer le nouveau token
    ];
    echo json_encode($response);
    exit;
}


// Destruction du token après utilisation
unset($_SESSION['csrf_token']);

// ==============================================
// Protection contre le Bruteforce
// ==============================================
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SESSION['login_attempts'] >= 5) {
    $response['message'] = 'Trop de tentatives. Veuillez réessayer plus tard.';
    echo json_encode($response);
    exit;
}

// ==============================================
// Traitement du Formulaire
// ==============================================
try {
    // 1. Validation des champs
    if (empty($_POST['email']) || empty($_POST['password'])) {
        throw new Exception('Tous les champs sont obligatoires');
    }

    // 2. Nettoyage et validation
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Adresse email invalide');
    }

    if (strlen($password) < 8) {
        throw new Exception('Le mot de passe doit contenir au moins 8 caractères');
    }

    // 3. Connexion DB
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
    $options = unserialize(DB_OPTIONS);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 4. Recherche utilisateur (avec prévention contre le timing attack)
    $stmt = $pdo->prepare("SELECT id, username, password FROM jdr_elric_user WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 5. Vérifications
    if (!$user) {
        throw new Exception('Identifiants incorrects');
    }
    /*
    if (!$user['is_active']) {
        throw new Exception('Compte désactivé. Contactez l\'administrateur.');
    }*/

    if (!password_verify($password, $user['password'])) {
        $_SESSION['login_attempts']++;
        throw new Exception('Identifiants incorrects');
    }

    /*Envoi d'un mail*/
    sendLoginNotification(SMTP_USER, $_SERVER['REMOTE_ADDR']);
    // 6. Connexion réussie
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $user['username'];
    $_SESSION['last_login'] = time();

    // Réinitialisation des tentatives
    unset($_SESSION['login_attempts']);


    // 7. Préparation réponse
    $response['success'] = true;
    $response['message'] = 'Connexion réussie';
    $response['redirect'] = $_SESSION['redirect_url'] ?? '/?p=dashboard';



    // Nettoyage de l'URL de redirection
    unset($_SESSION['redirect_url']);

} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    $response['message'] = 'Erreur de base de données';
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

// Délai artificiel pour prévenir le timing attack
usleep(random_int(100000, 300000));

echo json_encode($response);
?>
