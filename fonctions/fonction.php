<?php


function random_noms_perso()
{
	$array_nom = array(
		"Aelric", "Balaric", "Caldric", "Draegon", "Elderan", "Falderin", "Galathor", "Haldric", "Iridan",
		"Jorvik", "Keldorn", "Lorien", "Malthor", "Nerathis", "Odrik", "Peregrin", "Quorath", "Ragnor",
		"Sylas", "Thalion", "Ulric", "Valdric", "Wolfram", "Xyron", "Yvander", "Zorlan", "Aedan", "Brennar",
		"Corwin", "Drake", "Eldrin", "Fendric", "Garrick", "Havrik", "Iskander", "Jareth", "Kylan", "Lysander",
		"Malric", "Nolan", "Orin", "Padrig", "Quintus", "Rohar", "Soren", "Talon", "Ulfgar", "Viron", "Wendric",
		"Xarion", "Yorik", "Zarek", "Adalric", "Belgarath", "Caldor", "Duren", "Eorik", "Feron", "Gorlan", "Haldor",
		"Indor", "Jorlan", "Krogan", "Lorik", "Marek", "Nirak", "Odran", "Pryntar", "Quindor", "Rylas", "Skarin",
		"Thaldor", "Ugrin", "Varek", "Wulfric", "Xiran", "Yven", "Zorath", "Aethor", "Basil", "Cayden", "Duron",
		"Eiric", "Finn", "Grath", "Helder", "Ilmar", "Joric", "Kael", "Leif", "Merek", "Nalon", "Owyn", "Padrin",
		"Quiric", "Ronan", "Searil", "Taryn", "Ulf", "Varek", "Wendin", "Xylas", "Yannic", "Zyler", "Aldran", "Borin",
		"Cadric", "Draegonis", "Elenar", "Fioran", "Garion", "Halderic", "Ilanor", "Jarlath", "Krisan", "Luran",
		"Malon", "Nyran", "Oren", "Padran", "Rovan", "Saldor", "Tharan", "Urix", "Valkar", "Wyran", "Xylo", "Yron",
		"Zenar", "Aegir", "Baradin", "Caelum", "Dorran", "Elvandar", "Fendris", "Grivon", "Haldir", "Ithar", "Kellorn",
		"Lirian", "Mavric", "Nyril", "Orran", "Quorath", "Rovak", "Sondar", "Tyran", "Uthon", "Xalor", "Yorath", "Zalor",
		"Aldaron", "Bramar", "Cenric", "Draegar", "Eldron", "Fingal", "Gorath", "Hadrik", "Ingram", "Joren", "Keldrin",
		"Lathan", "Marek", "Neldor", "Othar", "Phelyx", "Qorwin", "Rionar", "Sylvan", "Taldor", "Udrik", "Varnor",
		"Wolric", "Xarion", "Yvenar", "Zarros", "Aenar", "Bendrik", "Calthor", "Damaric", "Eithan", "Faldor", "Gravik",
		"Haldros", "Ithrak", "Jolric", "Korlan", "Lelgar", "Mavrik", "Nevel", "Ostion", "Phaeron", "Rylor", "Sevrik",
		"Talonar", "Ulthar", "Varric", "Wynmar", "Xanor", "Yarith", "Zinlor", "Altor", "Branok", "Ciaran", "Dorian",
		"Elgar", "Fennor", "Gennar", "Hovik", "Imrath", "Jareth", "Kelmar", "Lyonar", "Merric", "Noras", "Pelor", "Qaleth",
		"Raelith", "Seylan", "Thalor", "Uldar", "Viron", "Wolfric", "Xynar", "Yren", "Zorion", "Alathor", "Calyth", "Durik",
		"Eldric", "Fenric", "Halvor", "Ivoran", "Jadric", "Krogan", "Larnak", "Morath", "Orik", "Pevan", "Quirin", "Rilan",
		"Soren", "Tirin", "Ulgor", "Valrin");

	$array_prenom = array(
		"Adrian", "Baldric", "Cedric", "Dorian", "Edric", "Faelan", "Gareth", "Hadrian", "Ivar", "Jareth",
		"Kael", "Lorien", "Maeron", "Nolan", "Orin", "Peregrin", "Quentin", "Ronan", "Soren", "Thelric",
		"Ulrich", "Varek", "Wulfric", "Xander", "Yvain", "Zane", "Alden", "Brandt", "Cassian", "Draven",
		"Eldon", "Finnian", "Galen", "Hector", "Isaac", "Julius", "Kieran", "Leander", "Magnus", "Nathaniel",
		"Oberon", "Phineas", "Quillon", "Roderic", "Silas", "Tiberius", "Urian", "Victor", "Wesley", "Xerxes",
		"York", "Zephyr", "Arthur", "Bennett", "Caleb", "Damien", "Emrys", "Felix", "Gideon", "Harlan", "Ignatius",
		"Jasper", "Killian", "Lucian", "Marcus", "Nevin", "Osmund", "Percival", "Rufus", "Samuel", "Talon",
		"Ulysses", "Vaughn", "Warren", "Xenos", "Yorick", "Zavier", "Axel", "Balthazar", "Conrad", "Darius",
		"Everett", "Fabian", "Gannon", "Hugo", "Ingram", "Jericho", "Klaus", "Lysander", "Maddox", "Nestor",
		"Octavius", "Prescott", "Remus", "Sullivan", "Thaddeus", "Upton", "Vince", "Wallace", "Xavian",
		"Yarden", "Zoltan", "Aeliana", "Berenice", "Calyndra", "Dalia", "Elysia", "Faelana", "Gwyneth", "Helya", "Ishara", "Jorva",
		"Kaela", "Lira", "Mirella", "Nerissa", "Oriana", "Phedra", "Quinna", "Rilana", "Selene", "Thalina",
		"Ursa", "Verenia", "Wynne", "Xara", "Ysolde","Alaric", "Bastien", "Corwin", "Damon", "Ezekiel", "Florian", "Garrick", "Hawke", "Ishmael", "Jorvik",
		"Kendrick", "Lucius", "Matthias", "Norbert", "Oberyn", "Pyrrhus", "Quirin", "Reinhardt", "Stellan", "Tristan",
		"Ulfred", "Valentin", "Zoran", "Anwen", "Briony", "Celestia", "Daphne", "Elowen", "Fiora", "Giselle","Gwanael", "Jem","Uldéric","Johannes","Siegdfried","Sigismond","Sigmar","Sigurd","Sigwald","Sigwulf", "Ludwig", "Ludovic","Liv","Stéfania");


	// Choisir un prénom aléatoire
    $prenom = $array_prenom[array_rand($array_prenom)];

    // Choisir un nom aléatoire
    $nom = $array_nom[array_rand($array_nom)];

    // Formater le prénom et le nom
    $prenom_formate = ucfirst(strtolower($prenom));
    $nom_formate = strtoupper($nom);

    // Retourner le nom complet formaté
    return $prenom_formate . " " . $nom_formate;
}

/************TAILLE et POIDS***********/
function calculerTailleEtPoids($tai) {
    // Tableau associatif : TAI mappé à la plage de tailles et poids
    $tableau_tai = [
        6  => ['taille' => [145, 155], 'poids' => [45, 55]],
        7  => ['taille' => [150, 160], 'poids' => [50, 60]],
        8  => ['taille' => [155, 165], 'poids' => [55, 65]],
        9  => ['taille' => [160, 170], 'poids' => [60, 70]],
        10 => ['taille' => [165, 175], 'poids' => [65, 75]],
        11 => ['taille' => [170, 180], 'poids' => [70, 80]],
        12 => ['taille' => [175, 185], 'poids' => [75, 85]],
        13 => ['taille' => [180, 190], 'poids' => [80, 90]],
        14 => ['taille' => [185, 195], 'poids' => [85, 95]],
        15 => ['taille' => [190, 200], 'poids' => [90, 100]],
        16 => ['taille' => [195, 205], 'poids' => [95, 105]],
        17 => ['taille' => [200, 210], 'poids' => [100, 110]],
        18 => ['taille' => [205, 215], 'poids' => [105, 115]],
        19 => ['taille' => [210, 220], 'poids' => [110, 120]],
        20 => ['taille' => [215, 225], 'poids' => [115, 125]],
        21 => ['taille' => [220, 230], 'poids' => [120, 130]],
        22 => ['taille' => [225, 235], 'poids' => [125, 135]],
        23 => ['taille' => [230, 240], 'poids' => [130, 140]],
        24 => ['taille' => [235, 245], 'poids' => [135, 145]],
        25 => ['taille' => [240, 250], 'poids' => [140, 150]],
    ];

    // Vérifie que le TAI est dans le tableau
    if (!isset($tableau_tai[$tai])) {
        throw new Exception("Score TAI invalide ou hors limite (entre 6 et 25).");
    }

    // Récupère les plages correspondantes
    $plage_taille = $tableau_tai[$tai]['taille'];
    $plage_poids = $tableau_tai[$tai]['poids'];

    // Génère des valeurs aléatoires dans les plages
    $taille = rand($plage_taille[0], $plage_taille[1]); // Taille en cm
    $poids = rand($plage_poids[0], $plage_poids[1]);   // Poids en kg

    // Retourne les résultats
    return [
        'taille' => $taille,
        'poids' => $poids
    ];
}


function before_pipe($contenu)
{

    $out_contenu = explode("|", $contenu);
    $last_contenu = $out_contenu[0];

    return $last_contenu;
}

function formatWithLineBreaks($text) {
    // Divise la chaîne en morceaux en utilisant `/`
    $parts = explode("/", $text);
    $formattedText = [];

    foreach ($parts as $part) {
        // Vérifie si un `|` est présent dans la partie
        if (strpos($part, "|") !== false) {
            // Sépare le texte avant et après le `|`
            list($before, $after) = explode("|", $part, 2);
            $formattedText[] = "<h4>" . htmlspecialchars(trim($before)) . "</h4>" . htmlspecialchars(trim($after));
        } else {
            $formattedText[] = htmlspecialchars(trim($part));
        }
    }

    // Assemble le tout avec des sauts de ligne
    return implode("<br>", $formattedText);
}


function purify_html($dirty_html) {
    // Liste des balises autorisées
    $allowed_tags = '<p><a><strong><em><ul><ol><li><h2><h3><h4><br><hr><iframe>';

    // Nettoie le HTML
    $clean_html = strip_tags($dirty_html, $allowed_tags);

    // Protection supplémentaire contre les attributs dangereux
    $clean_html = preg_replace('/<([a-z][a-z0-9]*)[^>]*?(on[a-z]+="[^"]*")/i', '<$1', $clean_html);

    return $clean_html;
}



function formatDateFrench($compactDate) {
    // Valider le format d'entrée (8 chiffres)
    if (!preg_match('/^\d{8}$/', $compactDate)) {
        return "Date invalide";
    }

    // Extraire les composants de la date
    $year = substr($compactDate, 0, 4);
    $month = substr($compactDate, 4, 2);
    $day = substr($compactDate, 6, 2);

    // Créer un objet DateTime
    $date = DateTime::createFromFormat('Y-m-d', "$year-$month-$day");
    if (!$date) {
        return "Date invalide";
    }

    // Tableaux de traduction française
    $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
    $mois = [1 => 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

    // Formater la date
    $nomJour = $jours[(int)$date->format('w')];
    $numeroJour = $date->format('j'); // 'j' pour éviter les zéros initiaux
    $nomMois = $mois[(int)$date->format('n')];
    $annee = $date->format('Y');

    return "$nomJour $numeroJour $nomMois $annee";
}


/****Select***/
function generateDynamicSelects($table, $fields, $base, $selectName, $selectValue, $degats_absorbe, $count = 5, $colspan = 1, $colspan2 = 1, $required = '', $non_input = 'No', $defaultLabel = "Choisissez une option") {
    try {
        // Validation des paramètres numériques
        $count = max(1, (int)$count);
        $colspan = max(1, (int)$colspan);
        $colspan2 = max(1, (int)$colspan2);

        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
        $options = unserialize(DB_OPTIONS);
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

        // Vérification et nettoyage des noms de champs/table
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
        $cleanFields = array_map(function($field) {
            return preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        }, $fields);

        // Construction de la requête (version sécurisée alternative)
        $fieldList = implode(", ", $cleanFields);
        $orderField = $cleanFields[1] ?? $cleanFields[0]; // Fallback au premier champ si le second n'existe pas

        $query = "SELECT ".$fieldList." FROM ".$table." ORDER BY ".$orderField." ASC";
        $stmt = $pdo->query($query);

        if ($stmt === false) {
            throw new PDOException("Erreur dans la requête SQL");
        }

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Génération des selects
        $output = '';
        for ($i = 1; $i <= $count; $i++) {
            $selectId = htmlspecialchars($selectName)."_".$i;
            $output .= '<tr>';
            $output .= '<td colspan="'.$colspan.'">';
            $output .= '<select class="form-select load_select_weapon mb-1" name="'.htmlspecialchars($selectName).'_'.$i.'" id="'.$selectId.'" '.htmlspecialchars($required).'>';
            $output .= '<option value="" selected>'.htmlspecialchars($defaultLabel).'</option>';

            foreach ($items as $item) {
                $id = htmlspecialchars($item['id'] ?? '');
                $nom = htmlspecialchars($item['nom'] ?? '');
                $pourc_base = htmlspecialchars($item[$base] ?? '');
                $degats = htmlspecialchars($item[$degats_absorbe] ?? '');
                if ($base == 'base')
                {
                    $pourc_base_aff = ' : '.$pourc_base.'%';
                    $add_plus = ' <div class="d-flex align-items-center gap-2"><i class="bi bi-plus-circle"></i>';
                    $add_plus_fin ='</div>';
                } else {
                    $pourc_base_aff = $pourc_base;
                    $add_plus = '';
                    $add_plus_fin ='';
                };
                $output .= '<option value="'.htmlspecialchars($selectValue).'_'.$id.'">'.$nom.' '.$pourc_base_aff.' - '.$degats.'</option>';
            }
            $output .= '</select>';
            $output .= '</td>';

            if ($non_input === 'Yes') {
                $output .= '<td colspan="'.$colspan2.'"  class="align-middle">'.$add_plus.' ';
                $output .= '<input type="number" class="form-control" name="'.htmlspecialchars($selectName).'_pourc_'.$i.'" id="'.$selectId.'_pourc" value="0"  data-bs-toggle="tooltip" title="Prendre en compte le pourcentage de base">'.$add_plus_fin;
                $output .= '</td>';
            }
            $output .= '</tr>';
        }

        return $output;

    } catch (PDOException $e) {
        error_log("Erreur DB dans generateDynamicSelects: ".$e->getMessage());
        return '<tr><td colspan="'.max($colspan, $colspan2).'"><select class="form-select"><option value="">Erreur de chargement</option></select></td></tr>';
    }
}


/******* Affiche Nation **************** */
function AffNation($nation_id, $pdo = null) {
    // Si aucune connexion PDO n'est fournie, on en crée une
    $shouldCloseConnection = false;
    if ($pdo === null) {
        try {
            $options = unserialize(DB_OPTIONS);
            $pdo = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
                DB_USER,
                DB_PASS,
                $options
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $shouldCloseConnection = true;
        } catch(PDOException $e) {
            return "Erreur de connexion";
        }
    }

    try {
        $stmt = $pdo->prepare("SELECT nom FROM jdr_elric_info_nationalite WHERE id = :id");
        $stmt->bindParam(':id', $nation_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['nom'])) {
            return htmlspecialchars($result['nom']);
        }

        return "Inconnue";

    } catch(PDOException $e) {
        error_log("Erreur lors de la récupération de la nation: " . $e->getMessage());
        return "Erreur";
    } finally {
        // On ferme la connexion seulement si on l'a créée ici
        if ($shouldCloseConnection) {
            $pdo = null;
        }
    }
}

/************AffProfession*************/
function AffProfession($profession_id, $pdo = null) {
    // Si aucune connexion PDO n'est fournie, on en crée une
    $shouldCloseConnection = false;
    if ($pdo === null) {
        try {
            $options = unserialize(DB_OPTIONS);
            $pdo = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
                DB_USER,
                DB_PASS,
                $options
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $shouldCloseConnection = true;
        } catch(PDOException $e) {
            return "Erreur de connexion";
        }
    }

    try {
        $stmt = $pdo->prepare("SELECT nom FROM jdr_elric_info_profession WHERE id = :id");
        $stmt->bindParam(':id', $profession_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['nom'])) {
            return htmlspecialchars($result['nom']);
        }

        return "Inconnue";

    } catch(PDOException $e) {
        error_log("Erreur lors de la récupération de la nation: " . $e->getMessage());
        return "Erreur";
    } finally {
        // On ferme la connexion seulement si on l'a créée ici
        if ($shouldCloseConnection) {
            $pdo = null;
        }
    }
}


/*******Affiche le nom d'utilisateur ********/
function afficherNomUtilisateur($user_id, $pdo = null) {
    try {
        // Gestion de la connexion PDO
        if ($pdo === null) {
            //require_once('../cnx/cnx_info.php'); // Chemin à adapter
            $pdo = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
                DB_USER,
                DB_PASS,
                unserialize(DB_OPTIONS)
            );
        }

        // Requête préparée pour la sécurité
        $stmt = $pdo->prepare("SELECT username FROM jdr_elric_user WHERE id = :user_id LIMIT 1");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && !empty($result['username'])) {
            return htmlspecialchars($result['username'], ENT_QUOTES, 'UTF-8');
        } else {
            return "[Utilisateur inconnu]";
        }

    } catch (PDOException $e) {
        error_log("Erreur récupération utilisateur ID ".$user_id." : ".$e->getMessage());
        return "[Erreur de chargement]";
    }
}


ini_set('display_errors', 1);
error_reporting(E_ALL);

function envoyerEmail($to, $subject, $message, $from = "webmaster@darkness-knives.fr") {
    // Headers pour email HTML
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $from . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    return mail($to, $subject, $message, $headers);
}


// Exemple d'utilisation
/*
$to = "johaaanns@mailo.com";
$subject = "Vérification PHP Mail";
$message = "PHP mail marche";

envoyerEmail($to, $subject, $message);*/

/**
 * Génère un mot de passe sécurisé
 */
function generateStrongPassword(int $length = 12): string
{
    $sets = [
        'ABCDEFGHJKLMNPQRSTUVWXYZ',
        'abcdefghjkmnpqrstuvwxyz',
        '23456789',
        '!@#$%&*?'
    ];

    $password = '';
    foreach ($sets as $set) {
        $password .= $set[random_int(0, strlen($set) - 1)];
    }

    while (strlen($password) < $length) {
        $randomSet = $sets[random_int(0, count($sets) - 1)];
        $password .= $randomSet[random_int(0, strlen($randomSet) - 1)];
    }

    return str_shuffle($password);
}


?>
