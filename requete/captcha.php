<?php
session_start();

// Configuration
$width = 200;
$height = 70; // Augmenté la hauteur
$length = 6;
$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

// Génération du code (en majuscules)
$code = substr(str_shuffle($chars), 0, $length);
// Stockez en majuscules dans la session
$_SESSION['captcha'] = strtoupper($code);

// Création de l'image
$image = imagecreatetruecolor($width, $height);

// Couleurs
$bg = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);
$noiseColor = imagecolorallocate($image, 200, 200, 200);

// Remplissage du fond
imagefilledrectangle($image, 0, 0, $width, $height, $bg);

// Ajout de bruit
for ($i = 0; $i < 500; $i++) {
    imagesetpixel($image, rand(0, $width), rand(0, $height), $noiseColor);
}

// Ajout de lignes parasites
for ($i = 0; $i < 5; $i++) {
    imageline($image, 0, rand(0, $height), $width, rand(0, $height), $noiseColor);
}

// Dessin du texte avec une police plus grande
for ($i = 0; $i < $length; $i++) {
    $fontSize = rand(10, 14); // Augmenté la taille de police
    $angle = rand(-15, 15);
    $x = 15 + ($i * 32) + rand(-5, 5);
    $y = 45 + rand(-5, 5);
    
    // Utilisation de imagestring avec une police plus grande (5 est la plus grande police interne)
    imagestring(
        $image,
        5,
        $x,
        $y - 15, // Ajustement vertical
        $code[$i],
        $textColor
    );
}

// Contour
imagerectangle($image, 0, 0, $width-1, $height-1, $noiseColor);

// En-tête et sortie
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>