<?php
/*session_start();*/
/************************************************/
/************************************************/
/*********************ELRIC***********************/
/************************************************/
/************************************************/

if (!isset($_SESSION['user_id'])) {

    echo '<div class="alert alert-danger" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> Si vous souhaitez enregistrer votre personnage, vous devez d\'abord vous connecter.
        </div>';
  $val_prenom = '';
}
else {
  $val_prenom = htmlspecialchars($_SESSION['user_name']);
}
?>
        <!-- 250 points bg-success -->
        <div id="pointsRestants" class="badge text-bg-success fs-4 text-center" role="alert">
            <i class="bi bi-info-square-fill"></i> Points :<br><span id="points">250</span>
        </div>


        <!-- Modal Bootstrap 250pts -->
        <div class="modal fade" id="pointsModal" tabindex="-1" aria-labelledby="pointsModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pointsModalLabel">Limite atteinte</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenu dynamique -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Compris</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal erreur -->
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Oups !</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Contenu dynamique -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Compris</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Modal succes -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Terminé</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <i class="bi bi-person-check-fill"></i> Création du personnage réussie !
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Compris</button>
                </div>
                </div>
            </div>
        </div>


        <form id="FormElric" name="FormElric" enctype="multipart/form-data"><!-- FORMULAIRE --->
        <div class="row g-0 justify-content-center"><!-- Ligne principale qui contient les deux colonnes -->
            <div class="col-md-8"><!-- PREMIERE COLONNE -->

                    <!-- TABS -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="nom_caract">
                            <button class="nav-link active" id="nom_caract-tab" data-bs-toggle="tab" data-bs-target="#nom_caract-tab-pane" type="button" role="tab" aria-controls="nom_caract-tab-pane" aria-selected="true"><i class="bi bi-dice-1-fill"></i> Caractéristiques</button>
                        </li>
                        <li class="nav-item" role="competences">
                            <button class="nav-link" id="competences-tab" data-bs-toggle="tab" data-bs-target="#competences-tab-pane" type="button" role="tab" aria-controls="competences-tab-pane" aria-selected="false"><i class="bi bi-dice-2-fill"></i> Compétences</button>
                        </li>
                        <li class="nav-item" role="armes_armures">
                            <button class="nav-link" id="armes_armures-tab" data-bs-toggle="tab" data-bs-target="#armes_armures-tab-pane" type="button" role="tab" aria-controls="armes_armures-tab-pane" aria-selected="false"><i class="bi bi-dice-3-fill"></i> Armes/armures</button>
                        </li>
                        <li class="nav-item" role="magie">
                            <button class="nav-link" id="magie-tab" data-bs-toggle="tab" data-bs-target="#magie-tab-pane" type="button" role="tab" aria-controls="magie-tab-pane" aria-selected="false"><i class="bi bi-dice-4-fill"></i> Magie</button>
                        </li>

                        <li class="nav-item" role="background">
                            <button class="nav-link" id="background-tab" data-bs-toggle="tab" data-bs-target="#background-tab-pane" type="button" role="tab" aria-controls="background-tab-pane" aria-selected="false"><i class="bi bi-dice-5-fill"></i> Background</button>
                        </li>

                        <li class="nav-item" role="liste_pjs">
                            <button class="nav-link bg-warning bg-opacity-10 text-warning" id="liste_pjs-tab" data-bs-toggle="tab" data-bs-target="#liste_pjs-tab-pane" type="button" role="tab" aria-controls="liste_pjs-tab-pane" aria-selected="false"><i class="bi bi-person-square"></i> Héros disponibles</button>
                        </li>
                    </ul>
                    <!-- Fin TABS -->

                    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="nom_caract-tab-pane" role="tabpanel" aria-labelledby="nom_caract-tab" tabindex="0">

            <h5 class="mt-4"><i class="bi bi-dice-1-fill"></i> Création d'un personnage pour Elric!</h5>

                <div class="row"><!-- Début ligne 1 -->

                    <div class="col">
                        <label for="nom_joueur" class="form-label">Prénom du joueur</label>
                        <input type="text" class="form-control" name="nom_joueur" id="nom_joueur" value="<?php echo $val_prenom; ?>" required>



                        <label for="nom_personnage" class="form-label">Nom du personnage</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nom_personnage" id="nom_personnage" value="<?php echo random_noms_perso(); ?>" required>
                            <button class="btn btn-outline-secondary" type="button" id="generer_nom" data-bs-toggle="tooltip" title="Clique ici pour un nom aléatoire">
                                <i class="bi bi-dice-4-fill jaune"></i> <span class="jaune">Aléatoire</span>
                            </button>
                        </div>

                        <label for="age" class="form-label">Age</label>
                        <select class="form-select" name="age" id="age" required>
                            <option value="" disabled selected>Choisissez votre age</option>
                            <?php for ($age=16; $age <= 60; $age++) { ?>
                                <option value="<?php echo $age; ?>"><?php echo $age; ?></option>
                            <?php } ?>
                        </select>

                    </div>

                    <div class="col">
                        <label for="nations" class="form-label">Choisissez une nation</label>
                        <select class="form-select load_select" name="nations" id="nations" required>
                            <option value="" disabled selected>Choisissez une nation</option>
                            <?php
                            try {
                                $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                                $options = unserialize(DB_OPTIONS);
                                $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

                                // Requête pour récupérer les professions
                                $stmt = $pdo->query("SELECT id, nom FROM jdr_elric_info_nationalite ORDER BY nom ASC");
                                $nation = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // Format [id => nom]

                                // Génération des options
                                foreach ($nation as $id => $nom) {
                                    echo '<option value="elric_'.$id.'">'.htmlspecialchars($nom).'</option>';
                                }

                            } catch (PDOException $e) {
                                error_log("Erreur DB professions: ".$e->getMessage());
                                echo '<option value="">Erreur de chargement</option>';
                            }
                            /*foreach ($elric_nations as $key_n => $value_n) { echo '<option value="elric_'.$key_n.'">'.$value_n.'</option>'; } */
                            ?>
                        </select>

                        <!--Menu déroiulant Profession avant -->

                            <label for="Sexe" class="form-label">Sexe</label>
                            <select class="form-select" name="sexe" id="sexe">
                                <option value="homme">Homme</option>
                                <option value="femme">Femme</option>
                            </select>
                    </div>

                </div><!-- Fin ligne 1 -->

                <!-- CARACTERISTIQUES -->
            <h5 class="mt-4"><i class="bi bi-dice-2-fill"></i> Caractéristiques</h5>


                <div class="row"><!-- Début ligne 2 -->

                    <div class="col">

                        <label for="force" class="form-label"><b>FOR</b>ce</label>
                        <div class="input-group">
                            <input type="text" class="form-control"  name="force"  id="force" readonly required>
                            <button class="btn btn-outline-secondary" type="button" id="rollForce" data-bs-toggle="tooltip" title="3x max" alt="3x max">🎲</button>
                        </div>

                        <label for="constitution" class="form-label"><b>CON</b>stitution</label>
                        <div class="input-group">
                            <input type="text" class="form-control"  name="constitution"  id="constitution" readonly required>
                            <button class="btn btn-outline-secondary" type="button" id="rollConstitution" data-bs-toggle="tooltip" title="3x max" alt="3x max">🎲</button>
                        </div>

                        <label for="taille" class="form-label"><b>TAI</b>lle</label>
                        <div class="input-group">
                            <input type="text" class="form-control"  name="taille"  id="taille" readonly required>
                            <button class="btn btn-outline-secondary" type="button" id="rollTaille" data-bs-toggle="tooltip" title="3x max" alt="3x max">🎲</button>
                        </div>

                        <label for="intelligence" class="form-label"><b>INT</b>elligence</label>
                        <div class="input-group">
                            <input type="text" class="form-control"  name="intelligence" id="intelligence" readonly required>
                            <button class="btn btn-outline-secondary" type="button" id="rollIntelligence" data-bs-toggle="tooltip" title="3x max" alt="3x max">🎲</button>
                        </div>

                        <label for="pouvoir" class="form-label"><b>POU</b>voir</label>
                        <div class="input-group">
                            <input type="text" class="form-control"  name="pouvoir" id="pouvoir" readonly required>
                            <button class="btn btn-outline-secondary" type="button" id="rollPouvoir" data-bs-toggle="tooltip" title="3x max" alt="3x max">🎲</button>
                        </div>

                        <label for="dexterite" class="form-label"><b>DEX</b>térité</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="dexterite" id="dexterite" readonly required>
                            <button class="btn btn-outline-secondary" type="button" id="rollDexterite" data-bs-toggle="tooltip" title="3x max" alt="3x max">🎲</button>
                        </div>

                        <label for="apparence" class="form-label"><b>APP</b>arence</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="apparence" id="apparence" readonly required>
                            <button class="btn btn-outline-secondary" type="button" id="rollApparence" data-bs-toggle="tooltip" title="3x max" alt="3x max">🎲</button>
                        </div>

                    </div>
                    <!-- Colonne a cote des caracteristiques -->
                    <div class="col">

                            <label for="mod_degats" class="form-label">Modificateur aux dégâts</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="mod_degats"  id="mod_degats" readonly required>
                            </div>

                            <label for="pts_vie" class="form-label">Points de vie (De -2 à 49)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pts_vie"  id="pts_vie" readonly required>
                            </div>

                            <label for="pts_magie" class="form-label">Points de magie (De 0 à 85)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pts_magie"  id="pts_magie" readonly required>
                            </div>

                            <label for="pourc_idee" class="form-label">Idée</label>
                            <div class="input-group">
                                <input type="text" class="form-control"  name="pourc_idee" id="pourc_idee" readonly required>
                            </div>

                            <label for="pourc_chance" class="form-label">Chance</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pourc_chance"  id="pourc_chance" readonly required>
                            </div>

                            <label for="pourc_dexterite" class="form-label">Dextérité</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pourc_dexterite"  id="pourc_dexterite" readonly required>
                            </div>

                            <label for="pourc_charisme" class="form-label">Charisme</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="pourc_charisme"  id="pourc_charisme" readonly required>
                            </div>
                    </div>

                </div><!-- Fin  ligne 2 --><!-- FIN CARACTERISTIQUES-->

    </div><!-- Fin 1 CONTAINER Tabs -->

        <div class="tab-pane fade" id="competences-tab-pane" role="tabpanel" aria-labelledby="competences-tab" tabindex="0">




            <h5 class="mt-4"><i class="bi bi-dice-1-fill"></i> Compétences</h5>

            <div class="row">
                  <div class="col-6">
                    <label for="profession" class="form-label">Choisissez une profession</label>
                    <select class="form-select load_select" name="profession" id="profession" required>
                        <option value="" disabled selected>Choisissez une profession</option>
                        <?php
                        try {
                            $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET;
                            $options = unserialize(DB_OPTIONS);
                            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

                            // Requête pour récupérer les professions
                            $stmt = $pdo->query("SELECT id, nom FROM jdr_elric_info_profession ORDER BY nom ASC");
                            $professions = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // Format [id => nom]

                            // Génération des options
                            foreach ($professions as $id => $nom) {
                                echo '<option value="elric_'.$id.'">'.htmlspecialchars($nom).'</option>';
                            }

                        } catch (PDOException $e) {
                            error_log("Erreur DB professions: ".$e->getMessage());
                            echo '<option value="">Erreur de chargement</option>';
                        }
                        ?>
                    </select>
                  </div>
                    <div class="col-6">
                      <label class="form-label">Argent</label>
                      <input type="text" class="form-control competence-input" name="argent" id="argent" value="" readonly>
                    </div>
            </div>
            <hr>

                <div class="row"><!-- Début ligne 3 -->
                    <div class="col">

                        <label class="form-label">Amorcer Piège <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Grâce à la compétence Amorcer/Désamorcer un Piège, un aventurier peut créer et désamorcer un système mécanique libérant la chute d'un poids sur une personne, un mécanisme à ressort, un bloc coulissant, une chausse-trappe, etc."></i></label>
                        <input type="number" class="form-control competence-input" name="amorcer_piege" id="amorcer_piege" value="5" required>

                        <label class="form-label">Art <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="La compétence Art permet de créer des œuvres esthétiques dans diverses disciplines : peinture, sculpture, dessin, musique, poésie, etc."></i></label>
                        <input type="number" class="form-control competence-input" name="art" id="art" value="5" required>

                        <label class="form-label">Artisanat <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="L'Artisanat représente la maîtrise d'un métier manuel spécifique comme la menuiserie, la forge, la poterie, la couture, ou tout autre travail de fabrication."></i></label>
                        <input type="number" class="form-control competence-input" name="artisanat" id="artisanat"  value="5" required>

                        <label class="form-label">Baratin <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Le Baratin est l'art d'utiliser la parole pour tromper, embobiner ou convaincre rapidement quelqu'un par des flatteries ou des mensonges."></i></label>
                        <input type="number" class="form-control competence-input" name="baratin" id="baratin"  value="15" required>

                        <label class="form-label">Chercher <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Chercher permet de fouiller méthodiquement une zone pour y découvrir des éléments cachés, comme des objets dissimulés, des passages secrets ou des indices."></i></label>
                        <input type="number" class="form-control competence-input" name="chercher" id="chercher"  value="20" required>

                        <label class="form-label">Crocheter <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Crocheter est la compétence qui permet d'ouvrir des serrures sans leur clé originale à l'aide d'outils spécifiques comme un passe-partout ou un crochet."></i></label>
                        <input type="number" class="form-control competence-input" name="crocheter" id="crocheter"  value="5" required>

                        <label class="form-label">Déguisement <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Le Déguisement permet de modifier son apparence à l'aide de costumes, de maquillage et d'accessoires pour se faire passer pour une autre personne."></i></label>
                        <input type="number" class="form-control competence-input" name="deguisement" id="deguisement"  value="15" required>

                        <label class="form-label">Déplacement silencieux <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Le Déplacement silencieux est l'art de se déplacer sans produire de bruit, essentiel pour se faufiler sans être détecté."></i></label>
                        <input type="number" class="form-control competence-input" name="depl_silencieux"  id="depl_silencieux" value="20" required>

                        <label class="form-label">Dissimuler objet <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Dissimuler objet permet de cacher un objet sur soi ou dans son environnement immédiat de manière à ce qu'il passe inaperçu lors d'une fouille."></i></label>
                        <input type="number" class="form-control competence-input" name="dissimuler_objet" id="dissimuler_objet"  value="20" required>

                        <label class="form-label">Ecouter <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Écouter représente la capacité à tendre l'oreille et à percevoir des sons faibles ou lointains, comme des chuchotements ou des pas discrets."></i></label>
                        <input type="number" class="form-control competence-input" name="ecouter"  id="ecouter" value="25" required>

                        <label class="form-label">Eloquence <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="L'Éloquence est l'art de bien parler, de persuader, de négocier ou de débattre de manière convaincante et structurée."></i></label>
                        <input type="number" class="form-control competence-input" name="eloquence" id="eloquence" value="5" required>

                        <label class="form-label">Equitation <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="L'Équitation est la compétence de monter et de contrôler un cheval ou une autre monture, ainsi que d'en prendre soin."></i></label>
                        <input type="number" class="form-control competence-input" name="equitation" id="equitation"  value="35" required>

                        <label class="form-label">Esquive (DEX x2) <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="L'Esquive permet d'éviter une attaque, un projectile ou tout autre danger en effectuant un mouvement rapide et précis."></i></label>
                        <input type="number" class="form-control competence-input" name="esquive" id="esquive"  value="" required>

                        <label class="form-label">Evaluer <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Évaluer permet d'estimer la valeur marchande d'un objet, son origine, son âge, ou son authenticité."></i></label>
                        <input type="number" class="form-control competence-input" name="evaluer" id="evaluer"  value="15" required>

                        <label class="form-label">Grimper <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Grimper représente la capacité à escalader des parois rocheuses, des arbres, des murs ou toute autre surface verticale ou inclinée."></i></label>
                        <input type="number" class="form-control competence-input" name="grimper" id="grimper"  value="40" required>

                        <label class="form-label">Jeunes Royaumes <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Jeunes Royaumes est une compétence de connaissances qui couvre l'histoire, la géographie, la politique et les coutumes des nations récentes et civilisées."></i></label>
                        <input type="number" class="form-control competence-input" name="jeunes_royaumes"  id="jeunes_royaumes" value="15" required>

                        <label class="form-label">Lancer <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Lancer permet de projeter un objet avec précision, que ce soit une pierre, une arme de jet ou tout autre projectile."></i></label>
                        <input type="number" class="form-control competence-input" name="lancer" id="lancer"  value="25" required>

                        <label class="form-label">Langue étrangère <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Langue étrangère représente la maîtrise orale et écrite d'une langue autre que sa langue maternelle."></i></label>
                        <input type="number" class="form-control competence-input" name="langue_etrangere"  id="langue_etrangere" value="0" required>


                    </div>

                    <div class="col">

                        <label class="form-label">Langue maternelle (INT x5) <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Langue maternelle est la parfaite maîtrise de sa langue native, incluant la lecture, l'écriture et l'expression orale."></i></label>
                        <input type="number" class="form-control competence-input" name="langue_maternelle"  id="langue_maternelle" value="0" required>

                        <label class="form-label">Marchander <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Marchander est l'art de négocier les prix, les termes d'un accord ou d'un contrat pour obtenir un avantage commercial."></i></label>
                        <input type="number" class="form-control competence-input" name="marchander" id="marchander" value="15" required>

                        <label class="form-label">Médecine <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="La Médecine permet de soigner les blessures, de diagnostiquer des maladies et de préparer des remèdes."></i></label>
                        <input type="number" class="form-control competence-input" name="medecine" id="medecine"  value="30" required>

                        <label class="form-label">Million de sphères <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Les Jeunes Royaumes savent peu de choses sur les autres plans. Là-bas, l'existence d’autres mondes est un mythe pour tous hormis les érudits et les sages. Un aventurier pourra augmenter sa connaissance du Million de Sphères en conversant avec d’éminents sorciers, en interrogeant les habitants d’autres plans, et en pratiquant des voyages astraux. Le mieux consiste encore à entreprendre des études académiques à l’aide de grimoires et d’autres livres détenteurs de savoir. Nombre de questions restent sans réponse ou sont le privilège d'une poignée de gens. Un jet de Million de Sphères réussi pourra donc ne fournir aucune information. Un succès critique pourrait révéler des informations décisives. Une maladresse pourrait indiquer qu’une chose est impossible ou n'existe pas quand elle est bien réelle en vérité."></i></label>
                        <input type="number" class="form-control competence-input" name="million_spheres" id="million_spheres"  value="0" required>

                        <label class="form-label">Monde naturel <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Le Monde naturel représente la connaissance des plantes, des animaux, des écosystèmes et des phénomènes naturels."></i></label>
                        <input type="number" class="form-control competence-input" name="monde_naturel" id="monde_naturel"  value="25" required>

                        <label class="form-label">Natation <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="La Natation est la capacité à se déplacer dans l'eau sans couler et à survivre à des dangers aquatiques."></i></label>
                        <input type="number" class="form-control competence-input" name="natation" id="natation"  value="25" required>

                        <label class="form-label">Navigation <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="La Navigation permet de se repérer et de guider un navire en mer, de lire des cartes marines et d'utiliser des instruments nautiques."></i></label>
                        <input type="number" class="form-control competence-input" name="navigation"  id="navigation" value="15" required>

                        <label class="form-label">Orientation <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="L'Orientation est la capacité à se repérer dans l'espace, à lire une carte, à utiliser une boussole et à ne pas se perdre en terrain inconnu."></i></label>
                        <input type="number" class="form-control competence-input" name="orientation" id="orientation"  value="10" required>

                        <label class="form-label">Pister <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Pister permet de suivre et d'interpréter les traces laissées par le passage d'êtres vivants : empreintes, restes de campement, indices divers."></i></label>
                        <input type="number" class="form-control competence-input" name="pister" id="pister"  value="10" required>

                        <label class="form-label">Potions <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Les Potions représentent la connaissance des ingrédients et des techniques pour créer des breuvages magiques ou aux effets spéciaux."></i></label>
                        <input type="number" class="form-control competence-input" name="potions" id="potions"  value="0" required>

                        <label class="form-label">Réparer/Concevoir (DEX x4) <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Réparer/Concevoir permet de fabriquer, modifier ou remettre en état des objets techniques, des mécanismes ou des outils."></i></label>
                        <input type="number" class="form-control competence-input" name="reparer_concevoir" id="reparer_concevoir"  value="0" required>

                        <label class="form-label">Royaumes Inconnus <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Royaumes Inconnus est une compétence de connaissances sur les terres lointaines, les cultures étrangères et les mystères des contrées inexplorées."></i></label>
                        <input type="number" class="form-control competence-input" name="royaumes_inconnus" id="royaumes_inconnus"  value="0" required>

                        <label class="form-label">Sagacité <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="La Sagacité représente la perspicacité intellectuelle, la capacité à résoudre des énigmes, à déduire des informations et à faire preuve de jugement."></i></label>
                        <input type="number" class="form-control competence-input" name="sagacite" id="sagacite"  value="15" required>

                        <label class="form-label">Sauter <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Sauter permet de franchir un obstacle en effectuant un bond, qu'il soit en hauteur ou en longueur, avec agilité et précision."></i></label>
                        <input type="number" class="form-control competence-input" name="sauter" id="sauter"  value="25" required>

                        <label class="form-label">Scribe <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Le Scribe est la maîtrise de l'écriture, de la lecture et de la copie de textes, ainsi que la connaissance des documents officiels et des archives."></i></label>
                        <input type="number" class="form-control competence-input" name="scribe" id="scribe"  value="0" required>

                        <label class="form-label">Se cacher <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Se cacher est l'art de se rendre invisible aux regards en utilisant le couvert de l'environnement, comme l'ombre ou la végétation."></i></label>
                        <input type="number" class="form-control competence-input" name="se_cacher" id="se_cacher"  value="20" required>

                        <label class="form-label">Sentir/Goûter <i class="bi bi-info-square-fill" data-bs-toggle="tooltip" title="Sentir/Goûter est la capacité à identifier des odeurs, des parfums ou des saveurs, et à détecter des poisons ou des ingrédients particuliers."></i></label>
                        <input type="number" class="form-control competence-input" name="sentir_gouter" id="sentir_gouter"  value="15" required>
                    </div>
                </div><!-- Fin ligne 3 -->


            <h5 class="mt-4"><i class="bi bi-dice-2-fill"></i> Compétences supplémentaires</h5>
                <div class="row"><!-- Début ligne 4 -->
                    <div class="col">
                        <label class="form-label">Autre 1</label>
                        <input type="text" class="form-control" name="nom_autre_1" id="nom_autre_1" value="Autre 1">
                        <input type="number" class="form-control" name="autre_1" id="autre_1" value="0">

                        <label class="form-label">Autre 2</label>
                        <input type="text" class="form-control" name="nom_autre_2" id="nom_autre_2" value="Autre 2">
                        <input type="number" class="form-control" name="autre_2"  id="autre_2" value="0">

                        <label class="form-label">Autre 3</label>
                        <input type="text" class="form-control" name="nom_autre_3" id="nom_autre_3" value="Autre 3">
                        <input type="number" class="form-control" name="autre_3" id="autre_3" value="0">
                    </div>
                    <div class="col">
                        <label class="form-label">Autre 4</label>
                        <input type="text" class="form-control" name="nom_autre_4" id="nom_autre_4" value="Autre 4">
                        <input type="number" class="form-control" name="autre_4" id="autre_4" value="0">

                        <label class="form-label">Autre 5</label>
                        <input type="text" class="form-control" name="nom_autre_5" id="nom_autre_5" value="Autre 5">
                        <input type="number" class="form-control" name="autre_5" id="autre_5" value="0">

                        <label class="form-label">Autre 6</label>
                        <input type="text" class="form-control" name="nom_autre_6" id="nom_autre_6" value="Autre 6">
                        <input type="number" class="form-control" name="autre_6" id="autre_6" value="0">
                    </div>
                </div>

        </div> <!-- Fin 2 CONTAINER Tabs -->
        <div class="tab-pane fade" id="armes_armures-tab-pane" role="tabpanel" aria-labelledby="armes_armures-tab" tabindex="0">

        <h5 class="mt-4"><i class="bi bi-dice-1-fill"></i> Armes de contact</h5>
            <!-- ARMES -->
            <table class="table table-bordered align-baseline text-center">
                <thead>
                    <tr>
                        <th scope="col">Armes</th>
                        <th scope="col">%</th>
                        <th scope="col">Dégats</th>
                        <th scope="col">Main</th>
                        <th scope="col">Struct.</th>
                        <th scope="col">Taille</th>
                        <th scope="col">Empale</th>
                        <th scope="col">Pare</th>
                        <th scope="col">FOR/DEX&nbsp;min.</th>
                        <th scope="col">Prix</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr>
                        <th scope="row">Bagarre</th>
                        <td><input type="number" class="form-control" name="bagarre" id="bagarre"  value="25" required></td>
                        <td>1D3+MD</td>
                        <td>1M</td>
                        <td>--</td>
                        <td>Courte</td>
                        <td>non</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                    </tr>
                    <tr>
                        <th scope="row">Lutte</th>
                        <td><input type="number" class="form-control" name="lutte" id="lutte"  value="25" required></td>
                        <td>spécial</td>
                        <td>2M</td>
                        <td>--</td>
                        <td>Courte</td>
                        <td>non</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                    </tr>
                    <?php
                    /*$table, $fields, $selectName, $selectValue, $degats_absorbe, $count = 5, $colspan, $colspan2, $required, $non_input, $defaultLabel = "Choisissez une option"*/
                    echo generateDynamicSelects(
                        'jdr_elric_info_armes', // Table
                        ['id', 'nom','degats', 'base'], // champs
                        'base',                 // base %
                        'armes',                // select name
                        'elric',                // selct value
                        'degats',               // Base du name/id
                        5,                      // boucle
                        8,                      // colspan 1ere partie
                        2,                      // colspan 2eme partie
                        '',                     // required
                        'Yes',                   // Input ou pas : No
                        'Choisissez une arme'   // Label par défaut
                    );
                    ?>
                </tbody>
            </table>
            <!-- FIN ARMES -->

            <!-- ARMURES -->
            <h5 class="mt-4"><i class="bi bi-dice-2-fill"></i> Armures</h5>
            <table class="table table-bordered align-baseline text-center">
                <thead>
                    <tr>
                        <th scope="col" style="width:15%;">Armures</th>
                        <th scope="col">Absorbe</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    echo generateDynamicSelects(
                        'jdr_elric_info_armures',        // Table
                        ['id', 'nom','absorbe','absorbe_sans_heaume'],
                        'absorbe_sans_heaume',    // champs
                        'armures',                  // select name
                        'elric',                    // Base du name/id
                        'absorbe',
                        1,
                        2,
                        0,
                        '',
                        'No',                      // Nombre de selects
                        'Choisissez une armure'    // Label par défaut
                    );
                    ?>
                </tbody>
            </table>
             <!-- FIN ARMURES -->

             <!-- BOUCLIER -->
            <h5 class="mt-4"><i class="bi bi-dice-3-fill"></i> Boucliers</h5>
            <table class="table table-bordered align-baseline text-center">
                <thead>
                    <tr>
                        <th scope="col" style="width:15%;">Boucliers</th>
                        <th scope="col">Absorbe</th>
                        <th scope="col" style="width:25%;">--</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    echo generateDynamicSelects(
                        'jdr_elric_info_boucliers',  // Table
                        ['id', 'nom','degats','base'],
                        'base',
                        'boucliers',           // Champs (id, valeur)
                        'elric',
                        'degats',                  // Base du name/id
                        1,
                        2,
                        1,
                        '',
                        'Yes',                      // Nombre de selects
                        'Choisissez un bouclier'    // Label par défaut
                    );
                    ?>
                </tbody>
            </table>
             <!-- FIN BOUCLIER -->

            <!-- ARME DE JET -->
            <h5 class="mt-4"><i class="bi bi-dice-4-fill"></i> Armes de jet</h5>
            <table class="table table-bordered align-baseline text-center">
                <thead>
                    <tr>
                        <th scope="col" style="width:15%;">Arme&nbsp;de&nbsp;jet</th>
                        <th scope="col">Dégats</th>
                        <th scope="col" style="width:25%;">--</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                echo generateDynamicSelects(
                        ' jdr_elric_info_armes_jet',  // Table
                        ['id', 'nom','degats','base'],
                        'base',                // select name
                        'armesjet',           // Champs (id, valeur)
                        'elric',
                        'degats',              // Base du name/id
                        2,
                        2,
                        1,
                        '',
                        'Yes',                     // Nombre de selects
                        'Choisissez vos armes de jet'    // Label par défaut
                    );
                    ?>
                </tbody>
            </table>
             <!-- FIN ARME DE JET -->



    </div><!-- Fin 3 CONTAINER Tabs -->
    <div class="tab-pane fade" id="magie-tab-pane" role="tabpanel" aria-labelledby="magie-tab" tabindex="0">

        <!--  -->
        <h5 class="mt-4"><i class="bi bi-dice-1-fill"></i> Culte</h5>
            <div class="row"><!-- Début ligne 4 -->
                <div class="col">

                <table class="table table-bordered align-baseline text-center">
                <thead>
                    <tr>
                        <th scope="col" style="width:15%;">Noms</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php
                    /*function generateDynamicSelects($table, $fields, $base, $selectName, $selectValue, $degats_absorbe, $count = 5, $colspan = 1, $colspan2 = 1, $required = '', $non_input = 'No', $defaultLabel = "Choisissez une option") {*/
                    echo generateDynamicSelects(
                        ' jdr_elric_info_dieux',  // Table
                        ['id', 'nom','description','alignement'],
                        '',                // select name
                        'dieu',           // Champs (id, valeur)
                        'elric',
                        'alignement',              // Base du name/id
                        1,
                        1,
                        1,
                        '',
                        'No',                     // Nombre de selects
                        'Choisissez votre Dieu'    // Label par défaut
                    );
                    ?>
                </tbody>
            </table>





            <h5 class="mt-4"><i class="bi bi-dice-2-fill"></i> Magie (Minimum 16 en POU)</h5>
                <table class="table table-bordered align-baseline text-center">
                    <thead>
                        <tr>
                            <th scope="col" style="width:15%;">Sorts</th>
                            <th scope="col">Points&nbsp;de&nbsp;magie</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php
                        echo generateDynamicSelects(
                            ' jdr_elric_info_sorts',  // Table
                            ['id', 'nom', 'pts_magie','categorie'],
                            'categorie',
                            'sorts',           // Champs (id, valeur)
                            'elric',
                            'pts_magie',
                            3,
                            2,
                            0,
                            '',
                            'No',                    // Nombre de selects
                            'Choisissez vos sorts'    // Label par défaut
                        );
                        ?>
                    </tbody>
                </table>
                <!-- FIN SORTS-->
            </div>
            </div>

    </div>

<!----------------BACKGROUND----------------------------->
<div class="tab-pane fade" id="background-tab-pane" role="tabpanel" aria-labelledby="background-tab" tabindex="0">
    <h5 class="mt-4"><i class="bi bi-dice-1-fill"></i> Background</h5>


            <!-- Ajoutez ceci dans votre formulaire existant -->
            <div class="mb-3">
                <label for="image" class="form-label">Portrait du personnage</label>
                <input class="form-control" type="file" name="image" id="image" accept="image/*">
                <div class="form-text">Image carrée de 250x250px (JPG, PNG, max 2MB)</div>
                  <div class="form-text">Vous pouvez générer un image chez <a href="https://www.bing.com/images/create?FORM=IRPGEN" target="_blank">Bing</a></div>
            </div>

            <?php
            if (isset($_SESSION['user_id']))
            {
            ?>
                <!-- Bouton d'upload séparé -->
                <button type="button" id="uploadBtn" class="btn btn-primary mb-3">
                    <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status"></span>
                    Uploader l'image
                </button>
            <?php
            }
            ?>
            <!-- Prévisualisation -->
            <div id="preview" class="mb-3" style="width:250px; height:250px; border:1px dashed #ddd; display:none;">
                <img src="" class="img-fluid" id="previewImage" alt="Prévisualisation">
            </div>

            <!-- Champ caché pour récupérer le nom de l'image -->
            <input type="hidden" name="avatar" id="avatarField">

            <!-- Messages -->
            <div id="uploadMessage"></div>








    <div class="row"><!-- Début ligne 5 -->
        <div class="col">

            <label for="style" class="form-label">Style de votre personnage</label>
            <textarea class="form-control mb-3" name="style" id="style" rows="5"></textarea>

            <label for="ia" class="form-label">N'hésitez pas à utiliser un IA (<b>I</b>ntelligence <b>a</b>rtificielle) pour faire votre background, voici les bases à poser</label>


            <div class="alert alert-warning text-justify mb-3" role="alert" id="resultat-background">
                Crée un background détaillé pour un personnage de JDR avec ces caractéristiques :<br>
                Nom : <b>NOM_DU_PERSONNAGE</b><br>
                Nation : <b>NATIONALITE</b><br>
                Profession : <b>PROFESSION</b><br>
                Traits principaux : <br>
                - Age : <b>VOTRE_AGE</b><br>
                - Sexe : <b>VOTRE_SEXE</b><br>
                - Force : <b>VOTRE_FORCE/20</b><br>
                - Intelligence : <b>VOTRE_INTELLIGENCE/20</b><br>
                - Pouvoir : <b>VOTRE_POUVOIR/20</b><br>
                - Taille : <b>VOTRE_TAILLE/20</b><br>
                - Constitution : <b>VOTRE_CONSTITUTION/20</b><br>
                - Dextérité : <b>VOTRE_DEXTERITE/20</b><br>
                - Apparence : <b>VOTRE_APPARENCE/20</b><br>
                - Dieu :  <b>VOTRE_DIEU</b><br>
                - Utilisation de la magie :  <b>OUI_NON</b><br>

                Génère une histoire crédible de 150-200 mots incluant :<br>
                1. Origines et enfance<br>
                2. Événement marquant<br>
                3. Motivation actuelle<br>
                4. Optionnel : Particularité mystérieuse<br>
                Ton style doit être : <b>PETITE_DESCRITPION</b>.<br>
                Ce personnage doit respecter l'univers d'Elric/Stormbringer de Michael Moorcock.
            </div>
            <button class="btn btn-primary mb-3" type="button" id="generer-background" data-bs-toggle="tooltip">
            <i class="bi bi-code-square"></i> Générer le script pour l'IA
            </button>

            <br>
            <label for="background" class="form-label"><i class="bi bi-card-list"></i> Background de votre personnage</label>
            <textarea class="form-control mb-3" name="background" id="background" rows="10"></textarea>
        </div>
    </div><!-- Fin ligne 5 -->



        <div class="alert alert-warning text-justify mb-3" role="alert">
            <h4><i class="bi bi-info-square-fill"></i> ATTENTION</h4>
            <i class="bi bi-1-circle-fill"></i> Vérifiez que vous avez bien dépensé l’intégralité de vos 250 points.
        </div>

        <!-- Zone CAPTCHA  -->
       <label for="captach" class="form-label"> Captcha</label>
        <div class="input-group mb-3">
            <img id="captchaImage" src="../requete/captcha.php" alt="CAPTCHA">
            <input type="text" class="form-control"  id="captchaInput" name="captcha" placeholder="Entrez le code" required>
            <button class="btn btn-outline-secondary" type="button" id="refreshCaptcha" data-bs-toggle="tooltip">
                <span class="fond_captacha"><i class="bi bi-arrow-clockwise"></i></span>
            </button>
        </div>

        <!-- Zone CSRF -->
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <?php
    if (isset($_SESSION['user_id']))
    {
    ?>
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <input type="hidden" name="date_creation" value="<?php echo date('Ymd'); ?>">
        <button type="submit" class="btn btn-primary mb-3" id="boutonformelric">Valider votre héros</button>
        </form>
    <?php
    }
    ?>


</div>
<!------------------------------------------------------->

<div class="tab-pane fade" id="liste_pjs-tab-pane" role="tabpanel" aria-labelledby="liste_pjs-tab" tabindex="0">

<h5 class="mt-4"><i class="bi bi-person-square"></i> Liste des héros disponibles</h5>
<?php


if (isset($_SESSION['user_id']))
{

    // Connexion à la base de données
try {
    $options = unserialize(DB_OPTIONS);
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
        DB_USER,
        DB_PASS,
        $options
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération des personnages
    $stmt = $pdo->prepare("SELECT * FROM jdr_elric_personnages WHERE user_id = :user_id ORDER BY id DESC");
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $personnages = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>

    <table class="table table align-middle table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Avatar</th>
                <th scope="col">Nom</th>
                <th scope="col">Nationalité</th>
                <th scope="col">Profession</th>
                <th scope="col">Créé le</th>
                <th scope="col">Modifier</th>
                <th scope="col"><i class="bi bi-trash"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($personnages)): ?>
            <?php foreach ($personnages as $personnage): ?>
                <tr>
                <td><?php echo htmlspecialchars($personnage['id']); ?></td>
                <td><img src="images/avatars/<?php echo htmlspecialchars($personnage['avatar']); ?>" alt="Avatar" class="img-fluid" style="width: 50px; height: 50px;"></td>
                <td><a href="elric.php?id=<?php echo htmlspecialchars($personnage['id']); ?>"><?php echo htmlspecialchars($personnage['nom_personnage']); ?></a></td>
                <td><?php echo AffNation($personnage['nations']); ?></td>
                <td><?php echo AffProfession($personnage['profession']); ?></td>
                <td><?php echo formatDateFrNum($personnage['date_creation']); ?></td>
                <td><button type="button" class="btn btn-primary"><i class="bi bi-pencil-square" data-bs-toggle="tooltip" title="Editer <?php echo  htmlspecialchars($personnage['nom_personnage']); ?>"></i></button></td>
                <td><button type="button" class="btn btn-danger"><i class="bi bi-trash" data-bs-toggle="tooltip" title="Supprimer <?php echo htmlspecialchars($personnage['nom_personnage']); ?>"></i></button></td>
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Aucun personnage trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php
} else {
    echo '<div class="alert alert-info" role="alert">Ici, s\'affichera la liste de vos personnages.</div>';
}
?>

</div>

    </div>

                </div>





            <div class="col-md-4"><!-- DEUXIEME COLONNE  class="overflow-auto" style="max-height: 80vh;" -->
                <div id="load_content_weapon">
                    <!--img src="images/elric.png" alt="Elric" class="img-fluid" -->
                </div>

                <div id="load_content">
                    <img src="images/elric.png" alt="Elric" class="img-fluid">
                </div>
            </div>
        </div><!-- Fin ligne GLOBALE -->
