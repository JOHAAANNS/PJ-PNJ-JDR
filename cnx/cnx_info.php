<?php

if (!defined('IN_APP')) {
    exit('Accès interdit');
}
define('DB_HOST', 'LOCALHOST');
define('DB_NAME', 'NOM_BASE_DONNEES');
define('DB_USER', 'ROOT');
define('DB_PASS', 'PASSWORD');
define('DB_CHARSET', 'utf8mb4');

// Options PDO communes (sans connexion active)
define('DB_OPTIONS', serialize([
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
]));


?>
