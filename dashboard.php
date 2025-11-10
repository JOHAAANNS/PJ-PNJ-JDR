<?php
/************************************************/
/************************************************/
/*********************ELRIC***********************/
/************************************************/
/************************************************/

if (!isset($_SESSION['user_id'])) {
    
    echo '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> Si vous souhaitez enregistrer voq personnages, vous devez d\'abord vous connecter.
        </div>';
}
else {
    echo '<div class="alert alert-success" role="alert">
            <i class="bi bi-check-circle-fill"></i> Dashboard :  Vous êtes connecté en tant que ' . htmlspecialchars($_SESSION['user_name']) . '.
        </div>';
}
?>