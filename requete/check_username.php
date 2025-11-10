<?php
define('IN_APP', true);
require_once '../cnx/cnx_info.php';

header('Content-Type: application/json');

$response = [
    'exists' => false,
    'error' => false,
    'message' => ''
];

if (!isset($_POST['username'])) {
    $response['error'] = true;
    $response['message'] = 'Username not provided';
    echo json_encode($response);
    exit;
}

try {
    // Création explicite de la connexion PDO
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
    $options = unserialize(DB_OPTIONS);
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    // Vérification supplémentaire de la connexion
    if (!$pdo) {
        throw new PDOException('Failed to connect to database');
    }

    $username = trim($_POST['username']);
    
    // Requête préparée plus sécurisée
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM jdr_elric_user WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $response['exists'] = ($result['count'] > 0);

} catch (PDOException $e) {
    $response['error'] = true;
    $response['message'] = 'Database error: ' . $e->getMessage();
    error_log("PDO Error in check_username: " . $e->getMessage());
} catch (Exception $e) {
    $response['error'] = true;
    $response['message'] = 'System error: ' . $e->getMessage();
    error_log("General Error in check_username: " . $e->getMessage());
}

echo json_encode($response);
?>