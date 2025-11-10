<?php
declare(strict_types=1);
ob_start();

define('IN_APP', true);
require '../cnx/cnx_info.php';
include '../fonctions/fonction.php';

// Configuration erreurs
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');

session_start();

header('Content-Type: application/json');
header('Cache-Control: no-store');

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
    if (empty($_POST['csrf_token_register']) || empty($_SESSION['csrf_token'])) {
        throw new Exception('Token de sécurité manquant', 403);
    }
    // Vérification CSRF
    if (empty($_POST['csrf_token_register']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token_register'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        throw new Exception('Session expirée, veuillez réessayer');
    }


    // Validation des données
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (empty($token)) {
        throw new Exception('Token invalide', 400);
    }

    if (empty($password)) {
        throw new Exception('Mot de passe requis', 400);
    }

    if ($password !== $password2) {
        throw new Exception('Les mots de passe ne correspondent pas', 400);
    }

    // Vérification complexité mot de passe
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+]).{8,}$/', $password)) {
        throw new Exception('Le mot de passe ne respecte pas les exigences de sécurité', 400);
    }

    // Connexion DB
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
    $options = unserialize(DB_OPTIONS);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Trouver l'utilisateur par son token
    $stmt = $pdo->prepare("SELECT id FROM jdr_elric_user WHERE re_password_session = ? LIMIT 1");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception('Token invalide ou expiré', 404);
    }

    // Hachage du nouveau mot de passe
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    if (!$hashedPassword) {
        throw new Exception('Erreur lors du hachage du mot de passe', 500);
    }

    // Mise à jour du mot de passe et invalidation du token
    $update = $pdo->prepare("UPDATE jdr_elric_user SET password = ?, re_password_session = NULL WHERE id = ?");
    $update->execute([$hashedPassword, $user['id']]);

    if ($update->rowCount() === 0) {
        throw new Exception('Échec de la mise à jour du mot de passe', 500);
    }

    $response = [
        'success' => true,
        'message' => 'Votre mot de passe a été modifié avec succès'
    ];

} catch (PDOException $e) {
    error_log("PDO Error: " . $e->getMessage());
    $response['message'] = 'Erreur base de données';
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    if ($e->getCode() >= 500) {
        error_log("Server Error: " . $e->getMessage());
    }
} finally {
    ob_end_clean();
    echo json_encode($response);
    exit;
}
