<?php
define('IN_APP', true);
require '../cnx/cnx_info.php';

header('Content-Type: application/json');

if (!isset($_POST['email'])) {
    echo json_encode(['exists' => false]);
    exit;
}
try {
    $chk_email = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
    $options_email = unserialize(DB_OPTIONS);
    $pdo = new PDO($chk_email, DB_USER, DB_PASS, $options_email);
    
    // Requête préparée pour récupérer les informations des armes //
    $email = trim($_POST['email']);
$stmt = $pdo->prepare("SELECT COUNT(*) FROM jdr_elric_user WHERE email = ?");
$stmt->execute([$email]);
$count = $stmt->fetchColumn();

} catch (PDOException $e) {
    error_log("Erreur DB Armes: ".$e->getMessage());
    echo '<div class="alert alert-danger">Erreur lors du chargement des informations.</div>';
}


echo json_encode(['exists' => $count > 0]);
?>