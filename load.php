<?php

define('IN_APP', true);
require '../cnx/cnx_info.php';
include '../fonctions/fonction.php';


if (isset($_GET['n']) & isset($_GET['id'])) {
    $nom_get = $_GET['n']; /*Le nom : ex nation */
    $id_get = $_GET['id']; /* l id ex : elric_1 */
}
else
{
    $nom_get = '';
    $id_get = 'id_0';
}


$n_id = explode("_", $id_get);
$name_of = $n_id[0];
$name_id = $n_id[1];

$id_get = explode("_", $nom_get);
$name_of_id = $id_get[0];


switch ($name_of) {
    case 'elric':
        if ($name_of_id == 'nations') {
            $myid = $n_id[1] ?? null; // Protection si $n_id[1] n'existe pas

            try {
                $dsn_nation = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                $options_nation = unserialize(DB_OPTIONS);
                $pdo_nation = new PDO($dsn_nation, DB_USER, DB_PASS, $options_nation);

                // Requête préparée pour récupérer les informations de nationalité
                $stmt_nation = $pdo_nation->prepare("SELECT nom, description, alignement FROM jdr_elric_info_nationalite WHERE id = :id");
                $stmt_nation->execute([':id' => $myid]);
                $nation_data = $stmt_nation->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() plutôt que fetchAll()

                if ($nation_data) {
                    echo '<div class="card dark">
                            <img src="images/elric_line.png" class="card-img-top" alt="Ligne décorative">
                            <div class="card-body text-justify dark">
                                <h4>'.htmlspecialchars($nation_data['nom']).'</h4>
                                <p class="card-text text-justify">'.purify_html($nation_data['description']).'</p>
                                <h4>Alignement</h4>
                                <p class="card-text text-justify">'.htmlspecialchars($nation_data['alignement']).'</p>
                            </div>
                          </div>';
                } else {
                    echo '<div class="alert alert-warning">Aucune information trouvée pour cette nationalité.</div>';
                }

            } catch (PDOException $e) {
                error_log("Erreur DB Nations: ".$e->getMessage());
                echo '<div class="alert alert-danger">Erreur lors du chargement des informations.</div>';
            }
        }
        if ($name_of_id == 'profession')
        {
            $myid = $n_id[1] ?? null; // Protection si $n_id[1] n'existe pas
            try {
                $dsn_profession = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                $options_profession = unserialize(DB_OPTIONS);
                $pdo_profession = new PDO($dsn_profession, DB_USER, DB_PASS, $options_profession);

                // Requête préparée pour récupérer les informations de nationalité
                $stmt_profession = $pdo_profession->prepare("SELECT * FROM jdr_elric_info_profession WHERE id = :id");
                $stmt_profession->execute([':id' => $myid]);
                $nation_profession = $stmt_profession->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() plutôt que fetchAll()

                if ($nation_profession) {
                    echo '<div class="card dark">
                    <img src="images/elric_line.png" class="card-img-top">
                    <div class="card-body text-justify dark">

                        <h4>'.htmlspecialchars($nation_profession['nom']).'</h4>
                        <p class="card-text text-justify">'.purify_html($nation_profession['description']).'</p>

                        <div class="badge text-bg-success fs-5 mb-2 container-fluid p-2">Compétences</div>
                            <p class="card-text text-left">'.purify_html($nation_profession['competences']).'</p>


                        <div class="badge text-bg-danger fs-5 mb-2 container-fluid p-2">Sorts optionnels</div>
                            <p class="card-text text-left">'.purify_html(nl2br($nation_profession['sorts_optionnels'])).'</p>


                        <div class="badge text-bg-warning fs-5 mb-2 container-fluid p-2">Argent supplémentaire</div>
                        <p class="card-text text-left ">'.purify_html($nation_profession['argent_supplementaire']).' Bronze(s) + (<i class="bi bi-dice-6-fill"></i> random 2D6)</p>

                    </div>
                </div>
                <div class="alert alert-warning text-justify m-2" role="alert">
                    <h4><i class="bi bi-info-square-fill"></i> Informations</h4>
                    <i class="bi bi-1-circle-fill"></i> Les 250 points sont à répartir dans les <b>compétences</b> en lien avec ta profession.<br>
                    Tu ne peux pas attribuer de point dans <b>Million de Sphères</b> et <b>Royaumes Inconnus</b><br>
                    <i class="bi bi-2-circle-fill"></i> Les <b>sorts optionnels</b> sont uniquement pour les personnages ayant un minimum de <b>16</b> en <b>POU</b>voir.<br>
                    <i class="bi bi-3-circle-fill"></i> Chaque sort ajoute <b>1 point</b> de <b>Chaos</b> (Voir onglet "Magie"). Tu n\'es pas obligé de prendre les <b>sorts optionels.</b>
                </div>';
                } else {
                    echo '<div class="alert alert-warning">Aucune information trouvée pour cette profession.</div>';
                }

            } catch (PDOException $e) {
                error_log("Erreur DB Profession: ".$e->getMessage());
                echo '<div class="alert alert-danger">Erreur lors du chargement des informations.</div>';
            }



        }
        /***************ARMES***************/
        if ($name_of_id == 'armes')
        {
           $myid = $n_id[1] ?? null;

            try {
                $dsn_armes = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                $options_armes = unserialize(DB_OPTIONS);
                $pdo_armes = new PDO($dsn_armes, DB_USER, DB_PASS, $options_armes);

                // Requête préparée pour récupérer les informations des armes //
                $stmt_armes = $pdo_armes->prepare("SELECT *  FROM jdr_elric_info_armes WHERE id = :id");
                $stmt_armes->execute([':id' => $myid]);
                $armes_data = $stmt_armes->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() plutôt que fetchAll()


                if ($armes_data)
                {
                    echo '<div class="card dark">
                    <img src="images/elric_armes.png" class="card-img-top">
                    <div class="card-body dark">
                        <h4>'.purify_html($armes_data['nom']).'</h4>
                        <ul>
                            <li><b>Pourcentage de base</b> : '.purify_html($armes_data['base']).'%</li>
                            <li><b>Dégats</b> : '.purify_html($armes_data['degats']).'</li>
                            <li><b>1 ou 2 mains</b> : '.purify_html($armes_data['main']).'</li>
                            <li><b>Structure</b> : '.purify_html($armes_data['structure']).'</li>
                            <li><b>Taille</b> : '.purify_html($armes_data['taille']).'</li>
                            <li><b>Empale</b> : '.purify_html($armes_data['empale']).'</li>
                            <li><b>Pare</b> : '.purify_html($armes_data['pare']).'</li>
                            <li><b>FOR/DEX minimum</b> : '.purify_html($armes_data['for_min']).'/'.purify_html($armes_data['dex_min']).'</li>
                            <li>Prix : '.purify_html($armes_data['prix']).'GB (Grande Bronze)</li>
                        </ul>
                        <p class="card-text text-justify">
                            <span class="badge text-bg-success">MD = Modificateur aux dégats</span>
                        </p>
                    </div>
                </div>';
                } else {
                    echo '<div class="alert alert-warning">Aucune information trouvée pour cette nationalité.</div>';
                }

            } catch (PDOException $e) {
                error_log("Erreur DB Armes: ".$e->getMessage());
                echo '<div class="alert alert-danger">Erreur lors du chargement des informations.</div>';
            }

        }

        /***************ARMURES***************/
        if ($name_of_id == 'armures')
        {
            $myid = $n_id[1] ?? null;

            try {
                $dsn_armes = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                $options_armes = unserialize(DB_OPTIONS);
                $pdo_armes = new PDO($dsn_armes, DB_USER, DB_PASS, $options_armes);

                // Requête préparée pour récupérer les informations des armes //
                $stmt_armes = $pdo_armes->prepare("SELECT *  FROM  jdr_elric_info_armures WHERE id = :id");
                $stmt_armes->execute([':id' => $myid]);
                $armes_data = $stmt_armes->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() plutôt que fetchAll()


                if ($armes_data)
                {

                    echo '<div class="card dark">
                    <img src="images/elric_armes.png" class="card-img-top">
                    <div class="card-body dark">
                        <h4>'.purify_html($armes_data['nom']).'</h4>
                        <ul>
                            <li><b>Absorbe</b> : '.purify_html($armes_data['absorbe']).'</li>
                            <li><b>Absorbe sans heaume</b> : '.purify_html($armes_data['absorbe_sans_heaume']).'</li>
                            <li><b>Encombrement</b> : '.purify_html($armes_data['Encombrement']).'</li>
                            <li><b>Compét. sans heaume</b> : '.purify_html($armes_data['Competence_sans_heaume']).'</li>
                            <li><b>Encombrement</b> : '.purify_html($armes_data['Encombrement']).'</li>
                            <li><b>rounds</b> : '.purify_html($armes_data['rounds']).'</li>
                            <li><b>prix</b> : '.purify_html($armes_data['prix']).'</li>
                        </ul>
                    </div>
                </div>';
                } else {
                    echo '<div class="alert alert-warning">Aucune information trouvée pour cette nationalité.</div>';
                }

            } catch (PDOException $e) {
                error_log("Erreur DB Armures: ".$e->getMessage());
                echo '<div class="alert alert-danger">Erreur lors du chargement des informations.</div>';
            }

        }

        /***************BOUCLIERS***************/
        if ($name_of_id == 'boucliers')
        {
            $myid = $n_id[1] ?? null;

            try {
                $dsn_armes = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                $options_armes = unserialize(DB_OPTIONS);
                $pdo_armes = new PDO($dsn_armes, DB_USER, DB_PASS, $options_armes);

                // Requête préparée pour récupérer les informations des armes //
                $stmt_armes = $pdo_armes->prepare("SELECT * FROM jdr_elric_info_boucliers WHERE id = :id");
                $stmt_armes->execute([':id' => $myid]);
                $armes_data = $stmt_armes->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() plutôt que fetchAll()


                if ($armes_data)
                {

                    echo '<div class="card dark">
                    <img src="images/elric_armes.png" class="card-img-top">
                    <div class="card-body dark">
                        <h4>'.purify_html($armes_data['nom']).'</h4>
                        <ul>
                            <li><b>Base</b> : '.purify_html($armes_data['base']).'%</li>
                            <li><b>Dégats</b> : '.purify_html($armes_data['degats']).'</li>
                            <li><b>Portée</b> : '.purify_html($armes_data['portee']).'</li>
                            <li><b>Structure</b> : '.purify_html($armes_data['structure']).'</li>
                            <li><b>FOR/DEX minimum</b> : '.purify_html($armes_data['for_dex']).'</li>
                            <li><b>prix</b> : '.purify_html($armes_data['prix']).'</li>
                        </ul>
                        <p class="card-text text-justify">
                            <span class="badge text-bg-success">MD = Modificateur aux dégats</span>
                        </p>
                    </div>
                </div>';
                } else {
                    echo '<div class="alert alert-warning">Aucune information trouvée pour cette nationalité.</div>';
                }

            } catch (PDOException $e) {
                error_log("Erreur DB Boucliers: ".$e->getMessage());
                echo '<div class="alert alert-danger">Erreur lors du chargement des informations.</div>';
            }

        }

        /***************ARMES DE JET***************/
        if ($name_of_id == 'armesjet')
        {
            $myid = $n_id[1] ?? null;

            try {
                $dsn_armes = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                $options_armes = unserialize(DB_OPTIONS);
                $pdo_armes = new PDO($dsn_armes, DB_USER, DB_PASS, $options_armes);

                // Requête préparée pour récupérer les informations des armes //
                $stmt_armes = $pdo_armes->prepare("SELECT * FROM jdr_elric_info_armes_jet WHERE id = :id");
                $stmt_armes->execute([':id' => $myid]);
                $armes_data = $stmt_armes->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() plutôt que fetchAll()


                if ($armes_data)
                {

                    echo '<div class="card dark">
                    <img src="images/elric_armes.png" class="card-img-top">
                    <div class="card-body dark">
                        <h4>'.purify_html($armes_data['nom']).'</h4>
                        <ul>
                            <li><b>Base</b> : '.purify_html($armes_data['base']).'%</li>
                            <li><b>Dégats</b> : '.purify_html($armes_data['degats']).'</li>
                            <li><b>Portée</b> : '.purify_html($armes_data['portee']).'</li>
                            <li><b>Structure</b> : '.purify_html($armes_data['structure']).'</li>
                            <li><b>Empale</b> : '.purify_html($armes_data['empale']).'</li>
                            <li><b>Pare</b> : '.purify_html($armes_data['pare']).'</li>
                            <li><b>FOR/DEX minimum</b> : '.purify_html($armes_data['for_dex']).'</li>
                            <li><b>prix</b> : '.purify_html($armes_data['prix']).'</li>
                        </ul>
                        <p class="card-text text-justify">
                            <span class="badge text-bg-success">MD = Modificateur aux dégats</span>
                        </p>
                    </div>
                </div>';
                } else {
                    echo '<div class="alert alert-warning">Aucune information trouvée pour cette nationalité.</div>';
                }

            } catch (PDOException $e) {
                error_log("Erreur DB Armes de jet: ".$e->getMessage());
                echo '<div class="alert alert-danger">Erreur lors du chargement des informations.</div>';
            }

        }




        /***************DIEUX***************/
        if ($name_of_id == 'dieu')
        {
            $myid = $n_id[1] ?? null;

            try {
                $dsn_armes = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                $options_armes = unserialize(DB_OPTIONS);
                $pdo_armes = new PDO($dsn_armes, DB_USER, DB_PASS, $options_armes);

                // Requête préparée pour récupérer les informations des armes //
                $stmt_armes = $pdo_armes->prepare("SELECT * FROM jdr_elric_info_dieux WHERE id = :id");
                $stmt_armes->execute([':id' => $myid]);
                $armes_data = $stmt_armes->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() plutôt que fetchAll()


                if ($armes_data)
                {

                    echo '<div class="card dark">
                    <img src="images/elric_armes.png" class="card-img-top">
                    <div class="card-body dark">
                        <h4>'.purify_html($armes_data['nom']).'</h4>
                        <ul>
                            <li><b>Nom</b> : '.purify_html($armes_data['nom']).'</li>
                            <li><b>Description</b> : '.purify_html($armes_data['description']).'</li>
                            <li><b>Alignement</b> : '.purify_html($armes_data['alignement']).'</li>
                        </ul>
                    </div>
                </div>';
                } else {
                    echo '<div class="alert alert-warning">Aucune information trouvée pour cette nationalité.</div>';
                }

            } catch (PDOException $e) {
                error_log("Erreur DB dieux: ".$e->getMessage());
                echo '<div class="alert alert-danger">Erreur lors du chargement des informations.</div>';
            }

        }





        /***************SORTS***************/
        if ($name_of_id == 'sorts')
        {
            $myid = $n_id[1] ?? null;

            try {
                $dsn_armes = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                $options_armes = unserialize(DB_OPTIONS);
                $pdo_armes = new PDO($dsn_armes, DB_USER, DB_PASS, $options_armes);

                // Requête préparée pour récupérer les informations des armes //
                $stmt_armes = $pdo_armes->prepare("SELECT * FROM jdr_elric_info_sorts WHERE id = :id");
                $stmt_armes->execute([':id' => $myid]);
                $armes_data = $stmt_armes->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() plutôt que fetchAll()


                if ($armes_data)
                {

                    echo '<div class="card dark">
                    <img src="images/elric_line.png" class="card-img-top">
                    <div class="card-body dark">
                        <h4>'.purify_html($armes_data['nom']).'</h4>
                        <ul>
                            <li><b>Points de magie</b> : ('.purify_html($armes_data['pts_magie']).')</li>
                            <li><b>Catégorie</b> : '.purify_html($armes_data['categorie']).'</li>
                            <li><b>Portée</b> : '.purify_html($armes_data['portee']).'</li>
                        </ul>
                        <b>Description</b> : '.purify_html($armes_data['description']).'
                        <p class="card-text text-justify">
                            <div class="alert alert-info" role="alert"><i class="bi bi-info-square-fill"></i> La durée d’un sort est égale au POU du sorcier exprimé sous forme de rounds de combat.
                            <br><b>Exemple</b> : un sorcier de <b>POU</b> 19 jette Rasoir infernal. Il faut un round pour le lancer, et le sort prend effet lors de la phase de magie du round suivant. Il dure 18 rounds de combat supplémentaires et prend fin lors de la phase de magie du 20ème round.
                            <br>Une fois jeté, il n’est nul besoin d’entretenir le sort, dont les effets perdurent que la cible se mette hors de portée ou non. Vous pouvez prolonger la durée d’un sort en le jetant une nouvelle fois quand bon vous semble. <br>Toutefois, cela n’augmente en rien l’intensité de ses effets.</div></p>


                    </div>
                </div>';
                } else {
                    echo '<div class="alert alert-warning">Aucune information trouvée pour cette nationalité.</div>';
                }

            } catch (PDOException $e) {
                error_log("Erreur DB nationalité: ".$e->getMessage());
                echo '<div class="alert alert-danger">Erreur lors du chargement des informations.</div>';
            }

        }
        break;

    default:
        /*$nations = array("Melniboné", "Melnibonéen", "Melnibonéenne", "Melnibonéens", "Melnibonéennes");
        $profession = array("Guerrier", "Mage", "Prêtre", "Marchand", "Voleur");*/
        break;
}


?>
