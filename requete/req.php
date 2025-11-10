<?php
session_start();
header('Content-Type: application/json');

define('IN_APP', true);
require '../cnx/cnx_info.php';
include '../fonctions/fonction.php';

// Récupération et normalisation
$userInput = strtoupper($_POST['captcha'] ?? '');
$captchaCode = strtoupper($_SESSION['captcha'] ?? '');

// ==============================================
// Vérification CSRF Token
// ==============================================
if (empty($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || 
    $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    
    echo json_encode([
        'success' => false,
        'message' => 'Token de sécurité invalide',
        'error' => 'csrf_failed'
    ]);
    exit;
}

// ==============================================
// Vérification CAPTCHA
// ==============================================
// Validation (ignore maintenant la casse)
if ($userInput === $captchaCode && !empty($captchaCode)) {
    // CAPTCHA valide
    echo "CAPTCHA correct!";
} else {
    // CAPTCHA invalide
    echo "CAPTCHA incorrect!";
}

// Suppression des données de vérification
unset($_SESSION['captcha']);
unset($_SESSION['csrf_token']);




        /**
         * Calcule les points d'alignement (Chaos/Loi) en fonction des sorts sélectionnés
         */
        function calculerPointsAlignement(PDO $dbh, array $sortsIds): array {
            $points = ['chaos' => 0, 'loi' => 0];
            
            // Filtrer les IDs valides (numériques et > 0)
            $sortsIds = array_filter($sortsIds, function($id) {
                return is_numeric($id) && $id > 0;
            });

            if (empty($sortsIds)) {
                return $points;
            }

            // Préparation de la requête avec des paramètres sécurisés
            $placeholders = implode(',', array_fill(0, count($sortsIds), '?'));
            $sql = "SELECT categorie FROM jdr_elric_info_sorts WHERE id IN ($placeholders)";
            $stmt = $dbh->prepare($sql);
            $stmt->execute(array_values($sortsIds));
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categorie = strtolower(trim($row['categorie'] ?? ''));
                
                if (strpos($categorie, 'chaotique') !== false) {
                    $points['chaos']++;
                } 
                elseif (strpos($categorie, 'loi') !== false) {
                    $points['loi']++;
                }
            }
            
            return $points;
        }

        /**
         * Nettoie et prépare les données reçues
         */
        function prepareData(array $data): array {
            return array_map(function($value) {
                if (is_string($value)) {
                    $value = preg_replace('/^elric_/i', '', $value);
                    return trim($value);
                }
                return $value;
            }, $data);
        }

        /**
         * Vérifie les points restants
         */
        function verifierPointsRestants(array $donnees): bool {
            $pointsInitiaux = 250;
            $pointsUtilises = 0;
            
            // Ici vous devrez implémenter la logique de calcul des points utilisés
            // selon votre système (compétences, sorts, etc.)
            // Exemple simplifié :
            $pointsUtilises += $donnees['pts_chaos'] ?? 0;
            $pointsUtilises += $donnees['pts_loi'] ?? 0;
            
            return ($pointsInitiaux - $pointsUtilises) >= 0;
        }

        try {
            // Connexion PDO avec transaction
            $dbh = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
                DB_USER, 
                DB_PASS, 
                unserialize(DB_OPTIONS)
            );
            $dbh->beginTransaction();

            // Récupération et nettoyage des données
            $rawData = file_get_contents('php://input');
            $donnees = prepareData(json_decode($rawData, true) ?: $_POST);
            
            // Validation des points restants
            if (!verifierPointsRestants($donnees)) {
                throw new Exception("Vous avez dépassé votre quota de points !");
            }
            
            // Validation du mot de passe (si fourni)
            if (!empty($donnees['password'])) {
                $password = $donnees['password'];
                if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/', $password)) {
                    throw new Exception("Le mot de passe ne respecte pas les critères de sécurité");
                }
            }

            // Liste des champs avec protection pour les mots-clés SQL /*Test1234*/
            $champsProteges = [
                'nom_joueur', 'nom_personnage', 'avatar', 'age', 'nations', 'profession', 'sexe', 
                '`force`', 'constitution', 'taille', 'intelligence', 'pouvoir', 'dexterite', 'apparence', 
                'mod_degats', 'pts_vie', 'pts_magie', 'pourc_idee', 'pourc_chance', 
                'pourc_dexterite', 'pourc_charisme', 'amorcer_piege', 'art', 'artisanat', 
                'baratin', 'chercher', 'crocheter', 'deguisement', 'depl_silencieux', 
                'dissimuler_objet', 'ecouter', 'eloquence', 'equitation', 'esquive', 
                'evaluer', 'grimper', 'jeunes_royaumes', 'lancer', 'langue_etrangere', 
                'langue_maternelle', 'marchander', 'medecine', 'million_spheres', 
                'monde_naturel', 'natation', 'navigation', 'orientation', 'pister', 'potions', 
                'reparer_concevoir', 'royaumes_inconnus', 'sagacite', 'sauter', 'scribe', 
                'se_cacher', 'sentir_gouter', 'nom_autre_1', 'autre_1', 'nom_autre_2', 
                'autre_2', 'nom_autre_3', 'autre_3', 'nom_autre_4', 'autre_4', 'nom_autre_5', 
                'autre_5', 'nom_autre_6', 'autre_6', 'bagarre', 'lutte', 'armes_1', 
                'armes_pourc_1', 'armes_2', 'armes_pourc_2', 'armes_3', 'armes_pourc_3', 
                'armes_4', 'armes_pourc_4', 'armes_5', 'armes_pourc_5', 'armures_1', 
                'boucliers_1', 'boucliers_pourc_1', 'armes_jet_1', 'armes_jet_pourc_1', 
                'armes_jet_2', 'armes_jet_pourc_2', 'dieu', 'sorts_1', 'sorts_2', 'sorts_3', 
                'pts_chaos', 'pts_balance', 'pts_loi', 'style', 'background', 'argent', 'date_creation', 'user_id'                
            ];

             // Préparation des paramètres en EXCLUANT csrf_token et captcha
            // Correction : Définition correcte de $champsBinding
            $champsBinding = array_map(function($field) {
                return str_replace('`', '', $field);
            }, $champsProteges);
            
            // Exclusion des champs csrf_token et captcha
            $donneesFiltrees = array_diff_key($donnees, array_flip(['csrf_token', 'captcha']));
            $donneesFiltrees = array_intersect_key($donneesFiltrees, array_flip($champsBinding));

            // Préparation des paramètres
            $params = [];
            foreach ($champsProteges as $field) {
                $cleanField = str_replace('`', '', $field);
                $params[':'.$cleanField] = $donneesFiltrees[$cleanField] ?? null;
            }

            // Insertion du personnage
            $sqlInsert = sprintf(
                "INSERT INTO jdr_elric_personnages (%s) VALUES (%s)",
                implode(', ', $champsProteges),
                implode(', ', array_map(fn($c) => ":".str_replace('`', '', $c), $champsProteges))
            );
            
            $stmt = $dbh->prepare($sqlInsert);
            if (!$stmt->execute($params)) {
                throw new PDOException(implode(' ', $stmt->errorInfo()));
            }
            
            $idPersonnage = $dbh->lastInsertId();

            // Récupération des sorts sélectionnés
            $sortsIds = [];
            for ($i = 1; $i <= 3; $i++) {
                if (!empty($donnees["sorts_$i"]) && is_numeric($donnees["sorts_$i"])) {
                    $sortsIds[] = (int)$donnees["sorts_$i"];
                }
            }

            // Calcul des points d'alignement
            $pointsAlignement = calculerPointsAlignement($dbh, $sortsIds);

            // Mise à jour des points d'alignement du personnage
            $sqlUpdate = "UPDATE jdr_elric_personnages 
                        SET pts_chaos = COALESCE(pts_chaos, 0) + :chaos, 
                            pts_loi = COALESCE(pts_loi, 0) + :loi
                        WHERE id = :id";
            
            $stmtUpdate = $dbh->prepare($sqlUpdate);
            $stmtUpdate->execute([
                ':chaos' => $pointsAlignement['chaos'],
                ':loi' => $pointsAlignement['loi'],
                ':id' => $idPersonnage
            ]);

            $dbh->commit();

            // Calcul des totaux pour la réponse
            $ptsChaosInit = (int)($donnees['pts_chaos'] ?? 0);
            $ptsLoiInit = (int)($donnees['pts_loi'] ?? 0);
            $pointsRestants = 250 - ($ptsChaosInit + $ptsLoiInit + $pointsAlignement['chaos'] + $pointsAlignement['loi']);

            echo json_encode([
                'success' => true,
                'id' => $idPersonnage,
                'points_chaos' => $ptsChaosInit + $pointsAlignement['chaos'],
                'points_loi' => $ptsLoiInit + $pointsAlignement['loi'],
                'points_restants' => $pointsRestants,
                'message' => 'Personnage créé avec succès'
            ]);

        } catch (PDOException $e) {
            $dbh->rollBack();
            error_log("Erreur PDO: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Erreur technique lors de la création du personnage',
                'debug' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            $dbh->rollBack();
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'error_type' => get_class($e)
            ]);
        }

