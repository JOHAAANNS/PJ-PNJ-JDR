<?php
define('IN_APP', true);
require '../cnx/cnx_info.php';
include '../fonctions/fonction.php';
header('Content-Type: application/json');

session_start();

$response = ['success' => false, 'message' => ''];

try {
    // Vérification CAPTCHA
    $userInput = strtoupper($_POST['captcha'] ?? '');
    $captchaCode = strtoupper($_SESSION['captcha'] ?? '');
    
    if ($userInput !== $captchaCode || empty($captchaCode)) {
        throw new Exception('CAPTCHA incorrect');
    }

    // Vérification CSRF
    if (empty($_POST['csrf_token_register']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token_register'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        throw new Exception('Session expirée, veuillez réessayer');
    }

    // Connexion PDO
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
    $options = unserialize(DB_OPTIONS);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération données
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        throw new Exception('Tous les champs sont obligatoires');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Adresse email invalide');
    }

    // Vérification existence
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM jdr_elric_user WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    if ($stmt->fetchColumn() > 0) {
        throw new Exception('Email ou nom d\'utilisateur déjà utilisé');
    }

    // Hachage mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    if (!$hashedPassword) throw new Exception('Erreur lors du hachage');

    // Insertion
    $re_password_session = sha1($username . $email . time());
    $stmt = $pdo->prepare("INSERT INTO jdr_elric_user (username, password, email, created_at, re_password_session, admin)  VALUES (?, ?, ?, NOW(), ?,0)");
    $stmt->execute([$username, $hashedPassword, $email, $re_password_session]);

    // Envoi email
    $message = "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Inscription à PJ-PNJ-JDR</title>
        </head>
        <body>
            <p>Bonjour $username,<br>
            Votre inscription sur [PJ PNJ JDR] a été validée.<br>
            Email : $email<br>
            Merci de votre confiance !<br>
            JOHAAANNS<br>
            https://".$_SERVER['SERVER_NAME']."<br></p>
            <p><br>A bientôt.<br>JOHAAANNS.</p>
        </body>
        </html>";

    $subject = "Inscription à PJ-PNJ-JDR";

    if (!envoyerEmail($email, $subject, $message)) {
        throw new Exception('Échec envoi email');
    }

    $response = ['success' => true, 'message' => 'Inscription réussie'];
    
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

unset($_SESSION['captcha'], $_SESSION['csrf_token']);
echo json_encode($response);
?>