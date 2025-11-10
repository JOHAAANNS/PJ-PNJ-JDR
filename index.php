<?php session_start(); ?>
<!DOCTYPE html>
<html data-bs-theme="dark">
    <head>
        <title>PJ PNJ JDR</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="images/LOGO-PJ.ico" rel="icon" type="image/x-icon">

        <!-- Compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="css/style.css">

        <!-- Compiled and minified JavaScript -->
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
        <script src="jquery/jquery.js"></script>
        <script src="jquery/captcha.js"></script>


    </head>
    <body class="dark-mode">

<?php
define('IN_APP', true);
require 'cnx/cnx_info.php';
include 'fonctions/fonction.php';

// Ne générer le token QUE s'il n'existe pas déjà
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_token_time'] = time(); // Optionnel : timestamp du token
}

// Token valable 1 heure (optionnel)
if (!empty($_SESSION['csrf_token_time']) && (time() - $_SESSION['csrf_token_time'] > 3600)) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['csrf_token_time'] = time();
}

// Détermine la page actuelle en vérifiant l'URL
$page = $_GET['p'] ?? 'home';

?>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white p-3 position-fixed h-100">
        <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none">
            <img src="images/petit-LOGO-PJ.png" class="img-fluid rounded-start me-2" alt="JDR - Elric" style="height: 45px;">
            <span class="logo-text fs-4">Menu JDR</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column">

            <?php


            // Dans la partie menu
                $resultats_menu = []; // Initialisation

                try {
                    $dsn_menu = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                    $options_menu = unserialize(DB_OPTIONS);
                    $pdo_menu = new PDO($dsn_menu, DB_USER, DB_PASS, $options_menu);

                    $stmt_menu = $pdo_menu->prepare("
                        SELECT *
                        FROM jdr_elric_accueil
                        ORDER BY jdr_onglet ASC,
                        jdr_id DESC");

                    $stmt_menu->execute();
                    $resultats_menu = $stmt_menu->fetchAll();

                    // Génération du menu (votre boucle foreach existante)
                    foreach ($resultats_menu as $row_menu) {
                        $isActive = ($page == $row_menu['jdr_url']) ? 'active' : '';
                        $epingleHome = ($row_menu['jdr_id'] == '1') ? '<i class="bi bi-house-fill me-2"></i>' : '<i class="bi bi-book-fill me-2"></i>';

                        echo '<li class="nav-item">
                                <a href="/?p='.$row_menu['jdr_url'].'" class="nav-link text-white '.$isActive.'">
                                    '.$epingleHome.' <span>'.htmlspecialchars($row_menu['jdr_onglet']).'</span>
                                </a>
                            </li>';
                    }


                } catch (PDOException $e) {
                    echo '<li class="nav-item"><a href="#" class="nav-link text-white">Erreur de chargement</a></li>';
                }
           ?>
        </ul>
        <hr>



        <form class="form-inline mb-2">
            <div class="d-grid gap-2">
                <input class="form-control" type="search" placeholder="Rechercher..." aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Rechercher</button>
            </div>
        </form>


<?php

if (isset($_SESSION['user_id']))
{ ?>
    <div class="badge text-bg-success fs-5 mb-2 container-fluid p-2"><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?></div>

    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <i class="bi bi-person-fill-gear me-2"></i>
            <span class="logo-text">Mon compte</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="/?p=dashboard"><i class="bi bi-gear-fill"></i> Paramètres</a></li>
            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Se déconnecter</a></li>
        </ul>
    </div>
<?php
}
else
{ ?>

    <br>
    <ul class="text-small">
        <li><a class="dropdown-item" href="?p=login">Se connecter - S'enregistrer</a></li>
    </ul>

<?php
}
?>



    </div>
    <!-- Fin Sidebar -->

    <!-- Contenu principal -->
    <div class="main-content flex-grow-1">
        <div class="container-fluid p-4">
            <?php
            // 1. Pages fixes à inclure
                $pages_manuelles = [
                    'login' => 'login.php',
                    'dashboard'      => 'dashboard.php',
                    'profil'      => 'profil.php',
                    'reinit'    => 'login.php'
                ];

                // 2. Construction des pages dynamiques (CORRECTION ICI)
                $pages_dynamiques = [];
                foreach ($resultats_menu as $row_menu) {
                    if (!empty($row_menu['jdr_url'])) {
                        $pages_dynamiques[$row_menu['jdr_url']] = 'jdr/' . $row_menu['jdr_url'] . '.php';
                        //                         ↑ Crochet ajouté ici
                    }
                }

                // 3. Fusion des tableaux
                $toutes_pages = array_merge($pages_manuelles, $pages_dynamiques);

                // 4. Inclusion sécurisée
                $page_incluse = false;
                if (isset($toutes_pages[$page]) && is_string($toutes_pages[$page])) {
                    $chemin = $toutes_pages[$page];
                    if (file_exists($chemin) && is_file($chemin)) {
                        include $chemin;
                        $page_incluse = true;
                    } else {
                        error_log("Fichier introuvable: " . $chemin);
                    }
                }

                if (!$page_incluse) {
                    include 'jdr/home.php';
                }
            ?>



            <div class="card text-bg-dark mt-4">
                <div class="card-header text-center"><i class="bi bi-cup-hot-fill"></i> Vous pouvez m'offrir un café ;)</div>
                <div class="card-body text-center">
                    <p class="card-text">
                        <form action="https://www.paypal.com/donate" method="post" target="_blank">
                            <input type="hidden" name="business" value="893BD8QD84FYJ" />
                            <input type="hidden" name="no_recurring" value="0" />
                            <input type="hidden" name="currency_code" value="EUR" />
                            <input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="Faites un don avec PayPal" alt="Faites un don avec PayPal" />
                            <img alt="" border="0" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1" />
                        </form>
                    </p>
                </div>
            </div>


            <!-- FOOTER -->
            <footer class="bg-dark text-white border-top border-end border-start py-4 mt-1">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="images/LOGO-PJ.png" alt="PJ PNJ JDR" class="img-fluid mt-4 ms-5">

                        </div>
                        <div class="col-md-6">
                            <h5 class="mt-5"><i class="bi bi-c-circle"></i> JOHAAANNS | <span class="badge rounded-pill text-bg-warning">PJ-PNJ-JDR Version 1.0.0 (Avril - 2025)</span></h5>
                            <ul class="list-unstyled">
                                <li><a href="https://www.facebook.com/JOHAAANNS/" target="_blank" class="btn btn-warning mt-2" role="button"><i class="bi bi-facebook"></i> Facebook</a></li>
                                <li><a href="https://x.com/JOHAAANNS" target="_blank" class="btn btn-warning mt-2" rrole="button"><i class="bi bi-twitter-x"></i> X</a></li>
                                <li><a href="https://mastodon.social/@JOHAAANNS" target="_blank" class="btn btn-warning mt-2" rrole="button"><i class="bi bi-mastodon"></i> Mastodon</a></li>
                                <li><a href="https://www.johaaanns.fr" target="_blank" class="btn btn-warning mt-2" rrole="button"><i class="bi bi-browser-chrome"></i> Site web</a></li>
                                <li><a href="mailto:info@johaaanns.fr" target="_blank" class="btn btn-warning mt-2">Contactez-moi !</a>
                            </ul>
                        </div>


                    </div>

                </div>
            </footer>
        </div>
    </div>
</div>

</body>
</html>
