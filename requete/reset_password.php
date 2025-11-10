<?php
declare(strict_types=1);
ob_start();

// Constante de sécurité
define('IN_APP', true);

// Connexion DB
require '../cnx/cnx_info.php';
include '../fonctions/fonction.php';

// Configuration des erreurs
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');

session_start();

// Header JSON doit être le premier output
header('Content-Type: application/json');
header('Cache-Control: no-store');

// Initialisation réponse
$response = [
    'success' => false,
    'message' => '',
    'new_token' => null
];

try {
    // Vérification méthode HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Méthode non autorisée', 405);
    }

    // Vérification CSRF
    if (empty($_POST['csrf_token_lost']) || empty($_SESSION['csrf_token'])) {
        throw new Exception('Token de sécurité manquant', 403);
    }

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token_lost'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $response['new_token'] = $_SESSION['csrf_token'];
        throw new Exception('Session expirée, veuillez réessayer', 403);
    }

    // Validation email
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    if (empty($email)) {
        throw new Exception('Adresse email requise', 400);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Format email invalide', 400);
    }

    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
    $options = unserialize(DB_OPTIONS);
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérification existence email - CORRECTION ICI
    $stmt = $pdo->prepare("SELECT id, re_password_session FROM jdr_elric_user WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
     
     if (!$user) { // Correction: vérifier $user au lieu de refetch()
         throw new Exception('Aucun compte associé à cet email', 404);
     }

    // Récupération de la valeur depuis le résultat de la requête
    $re_password_session = $user['re_password_session'];

    $randommrg = random_int(1, 99);
    $urlreinit = "https://".$_SERVER['SERVER_NAME']."/?p=reinit&mrg=".$randommrg."&token=".$re_password_session;
    // Construction du message HTML
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Réinitialisation du mot de passe</title>
    </head>
    <body>
        <p>Bonjour,</p>
        <p>Vous pouvez réinitialiser votre mot de passe ici : <a href="'.$urlreinit.'">Lien de réinitialisation</a></p>
        <p>A bientôt.<br>JOHAAANNS.</p>
    </body>
    </html>';

    $subject = "PJ-PNJ-JDR : Mot de passe perdu";

    // Envoi de l'email
    if (envoyerEmail($email, $subject, $message)) {
        $response = [
            'success' => true,
            'message' => 'Un nouveau mot de passe a été envoyé à votre adresse email'
        ];
    } else {
        throw new Exception('Échec de l\'envoi de l\'email', 500);
    }

} catch (PDOException $e) {
    error_log("PDO Error: " . $e->getMessage());
    $response['message'] = 'Erreur base de données';
} catch (Exception $e) {
    $code = $e->getCode();
    $response['message'] = $e->getMessage();
    
    // Log seulement les erreurs serveur (500+)
    if ($code >= 500) {
        error_log("Server Error {$code}: " . $e->getMessage());
    }
} finally {
    // Nettoyage buffer et envoi JSON
    ob_end_clean();
    echo json_encode($response);
    exit;
}

