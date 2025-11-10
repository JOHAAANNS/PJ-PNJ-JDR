<?php
session_start();
header('Content-Type: application/json');

$response = [
    'success' => false,
    'error' => 'Code CAPTCHA incorrect. Veuillez regénérer un nouveau CAPTCHA <i class="bi bi-arrow-clockwise"></i>',
    'message' => ''
];

// Vérification
if (!empty($_POST['captcha']) && 
    isset($_SESSION['captcha']) && 
    strtolower($_POST['captcha']) === strtolower($_SESSION['captcha'])) {
    
    $response['success'] = true;
    $response['message'] = 'Validation réussie !';
    $response['error'] = '';
    
    // Ici: Traitement du formulaire (email, etc.)
    // Ex: $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    
    // Régénération du CAPTCHA
    unset($_SESSION['captcha']);
}

echo json_encode($response);
?>