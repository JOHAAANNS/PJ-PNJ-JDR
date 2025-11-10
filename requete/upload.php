<?php
header('Content-Type: application/json; charset=utf-8');

// Configuration
$uploadDir = '../images/avatars/';
$maxFileSize = 2 * 1024 * 1024; // 2MB
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$targetWidth = 250;
$targetHeight = 250;
$quality = 80;
$prefix = 'avatar_';

$response = ['success' => false, 'error' => ''];

try {
    // Vérifications de base
    if (!isset($_FILES['image'])) {
        throw new Exception('Aucun fichier reçu');
    }

    $file = $_FILES['image'];

    // Gestion des erreurs d'upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors = [
            UPLOAD_ERR_INI_SIZE => 'Le fichier dépasse la taille maximale autorisée',
            UPLOAD_ERR_FORM_SIZE => 'Le fichier dépasse la taille maximale spécifiée',
            UPLOAD_ERR_PARTIAL => 'Le fichier n\'a été que partiellement uploadé',
            UPLOAD_ERR_NO_FILE => 'Aucun fichier n\'a été uploadé',
            UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant',
            UPLOAD_ERR_CANT_WRITE => 'Échec de l\'écriture du fichier sur le disque',
            UPLOAD_ERR_EXTENSION => 'Une extension PHP a arrêté l\'upload du fichier'
        ];
        throw new Exception($errors[$file['error']] ?? 'Erreur d\'upload inconnue');
    }

    // Vérification taille
    if ($file['size'] > $maxFileSize) {
        throw new Exception('Fichier trop volumineux (max 2MB)');
    }

    // Vérification type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowedTypes)) {
        throw new Exception('Type de fichier non autorisé. Formats acceptés: JPG, PNG, GIF, WEBP');
    }

    // Création répertoire si besoin
    if (!file_exists($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            throw new Exception('Impossible de créer le dossier de destination');
        }
    }

    // Génération du nom de fichier
    $randomNumber = str_pad(mt_rand(1, 1000), 4, '0', STR_PAD_LEFT);
    $filename = $prefix . $randomNumber . '_' . time() . '.jpg';
    $filepath = $uploadDir . $filename;

    // Traitement image
    switch ($mime) {
        case 'image/jpeg': $source = imagecreatefromjpeg($file['tmp_name']); break;
        case 'image/png': $source = imagecreatefrompng($file['tmp_name']); break;
        case 'image/gif': $source = imagecreatefromgif($file['tmp_name']); break;
        case 'image/webp': $source = imagecreatefromwebp($file['tmp_name']); break;
        default: throw new Exception('Type d\'image non supporté');
    }

    if (!$source) {
        throw new Exception('Impossible de créer l\'image à partir du fichier uploadé');
    }

    // Dimensions originales
    $origWidth = imagesx($source);
    $origHeight = imagesy($source);

    // Création image temporaire avec fond noir
    $temp = imagecreatetruecolor($targetWidth, $targetHeight);
    $black = imagecolorallocate($temp, 0, 0, 0);
    imagefill($temp, 0, 0, $black);

    // Calcul du ratio et positionnement
    $ratio = min($targetWidth/$origWidth, $targetHeight/$origHeight);
    $newWidth = (int)($origWidth * $ratio);
    $newHeight = (int)($origHeight * $ratio);
    $dstX = ($targetWidth - $newWidth) / 2;
    $dstY = ($targetHeight - $newHeight) / 2;

    // Redimensionnement avec fond noir sur les bords
    imagecopyresampled($temp, $source, $dstX, $dstY, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

    // Sauvegarde
    if (!imagejpeg($temp, $filepath, $quality)) {
        throw new Exception('Échec de la sauvegarde de l\'image');
    }

    // Nettoyage
    imagedestroy($source);
    imagedestroy($temp);

    // Réponse succès
    $response = [
        'success' => true,
        'filepath' => str_replace('../', '', $filepath),
        'filename' => $filename
    ];

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    http_response_code(400);
}

echo json_encode($response, JSON_UNESCAPED_SLASHES);
exit;
?>