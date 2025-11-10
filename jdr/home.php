<?php
/************************************************/
/********************** Home ********************/
/************************************************/

// Configuration de la pagination
$items_par_page = 10; // Nombre d'articles par page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_par_page;

try {
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
    $options = unserialize(DB_OPTIONS);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
    // Requête pour compter le nombre total d'articles
    $count_stmt = $pdo->query("SELECT COUNT(*) FROM jdr_elric_accueil");
    $total_items = $count_stmt->fetchColumn();
    $total_pages = ceil($total_items / $items_par_page);
    
    // Requête paginée avec priorité aux épinglés + récents
    $stmt = $pdo->prepare("
        SELECT * 
        FROM jdr_elric_accueil 
        ORDER BY 
            jdr_epingle DESC,
            jdr_date DESC,
            jdr_id DESC
        LIMIT :limit OFFSET :offset");
    
    $stmt->bindValue(':limit', $items_par_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $resultats = $stmt->fetchAll();
    
    // Affichage des articles
    foreach ($resultats as $row) {
        $epingleClass = $row['jdr_epingle'] ? 'epingle' : '';
        $epingleIcone = $row['jdr_epingle'] ? '<i class="bi bi-pin-fill pin_epingle"></i>' : '<i class="bi bi-book-half"></i>';
        $BadgeEpingle = $row['jdr_epingle'] ? ' <span class="badge bg-warning text-dark">Épinglé</span>' : '';
        
        echo '<div class="card mb-3 '.$epingleClass.' d-flex flex-column h-100">
            <div class="row g-0">
                <div class="col-md-4">
                    <a href="/?p='.$row['jdr_url'].'"><img src="images/'.htmlspecialchars($row['jdr_image']).'" class="img-fluid rounded-start" alt="'.htmlspecialchars($row['jdr_titre']).'"></a>
                </div>
                <div class="col-md-8 d-flex flex-column">
                    <div class="card-body">
                        <h5 class="card-title">
                            '.$epingleIcone.' 
                            '.$BadgeEpingle .'
                            '.purify_html($row['jdr_titre']).'
                        </h5>
                        <div class="card-text">'.purify_html($row['jdr_texte']).'</div>
                    </div>
                        <div class="card-footer mt-auto text-end"> <i class="bi bi-calendar-fill"></i> '.formatDateFrench($row['jdr_date']).' - <i class="bi bi-person-circle"></i> '.afficherNomUtilisateur($row['jdr_user_id']).'</div>
                </div>
                </div>
            </div>';
    }
    
    // Affichage de la pagination
    echo '<nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">';
    
    // Bouton Précédent
    if ($page > 1) {
        echo '<li class="page-item">
                <a class="page-link" href="?page='.($page - 1).'">Précédent</a>
              </li>';
    } else {
        echo '<li class="page-item disabled">
                <span class="page-link">Précédent</span>
              </li>';
    }
    
    // Numéros de page
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo '<li class="page-item active" aria-current="page">
                    <span class="page-link">'.$i.'</span>
                  </li>';
        } else {
            echo '<li class="page-item">
                    <a class="page-link" href="?page='.$i.'">'.$i.'</a>
                  </li>';
        }
    }
    
    // Bouton Suivant
    if ($page < $total_pages) {
        echo '<li class="page-item">
                <a class="page-link" href="?page='.($page + 1).'">Suivant</a>
              </li>';
    } else {
        echo '<li class="page-item disabled">
                <span class="page-link">Suivant</span>
              </li>';
    }
    
    echo '</ul></nav>';
    
} catch (PDOException $e) {
    error_log("Erreur DB: ".$e->getMessage());
    echo '<div class="alert alert-danger">Une erreur est survenue. Veuillez réessayer plus tard.</div>';
}
?>