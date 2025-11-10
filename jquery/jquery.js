$(document).ready(function() {


// Désactiver la validation HTML5 par défaut
$('#FormElric').on('submit', function(e) {
    e.preventDefault();
    validateForm();
});

// Validation personnalisée pour les onglets Bootstrap
$('#boutonformelric').click(function() {
    validateForm();
});

function validateForm() {
    let isValid = true;
    let emptyFields = [];

    // Réinitialiser les marqueurs d'erreur
    $('[required]').removeClass('is-invalid');

    // Vérifier tous les champs requis
    $('[required]').each(function() {
        let isEmpty = false;

        if ($(this).is('select')) {
            isEmpty = $(this).val() === null || $(this).val() === '' || $(this).find('option:selected').prop('disabled');
        } else {
            isEmpty = $(this).val().trim() === '';
        }

        if (isEmpty) {
            isValid = false;
            $(this).addClass('is-invalid');

            const fieldLabel = $(this).prev('label').text() || $(this).attr('name') || $(this).attr('id');
            emptyFields.push(fieldLabel.replace('*', '').trim());

            const tabPane = $(this).closest('.tab-pane');
            if (tabPane.length && !tabPane.hasClass('show active')) {
                const tabId = tabPane.attr('id');
                $(`[data-bs-target="#${tabId}"]`).tab('show');
            }
        }
    });

    // Vérification des points restants
    const pointsRestants = parseInt($('#points').text()) || 0;
    if (pointsRestants > 0) {
        isValid = false;
        $('#pointsRestants').removeClass('text-bg-success').addClass('text-bg-warning');
        emptyFields.push("Il reste " + pointsRestants + " points à dépenser");
    } else {
        $('#pointsRestants').removeClass('text-bg-warning').addClass('text-bg-success');
    }

    if (!isValid) {
        let errorMessage = "<div class='alert alert-danger'><h5>Erreurs à corriger :</h5><ul class='mb-0'>";
        emptyFields.forEach(function(field) {
            errorMessage += "<li>" + field + "</li>";
            /*alert(field);*/
        });
        errorMessage += "</ul></div>";

        $('#errorModal .modal-body').html(errorMessage);
        $('#errorModal').modal('show');
    } else {
        // Soumission AJAX du formulaire
        submitFormViaAjax();
    }
}



    // Fonction pour trouver l'input correspondant à une compétence
    function trouverInputParCompetence(competence) {
        // Mapping des correspondances entre les noms affichés et les IDs des inputs
        var correspondances = {
            'Marchander': 'marchander',
            'Evaluer': 'evaluer',
            'Sagacité': 'sagacite',
            'Ecouter': 'ecouter',
            'Monde Naturel': 'monde_naturel',
            'Autre Langue': 'langue_etrangere',
            'Jeunes Royaumes': 'jeunes_royaumes',
            'Votre spécialité': 'specialite' // À adapter selon votre spécialité
        };

        var idInput = correspondances[competence];
        if (idInput) {
            return $('#' + idInput);
        }

        // Si pas de correspondance directe, chercher par le texte du label
        return $('label.form-label').filter(function() {
            return $(this).text().trim() === competence;
        }).next('input.form-control');
    }


function submitFormViaAjax() {
    // Récupérer les données du formulaire
    const formData = new FormData($('#FormElric')[0]);


    $.ajax({
        /*url: $('#FormElric').attr('action') || window.location.href,*/
        url: '../requete/req.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            // Afficher un loader
            $('#boutonformelric').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Envoi en cours...');
        },
        success: function(response) {
            // Traitement de la réponse
            if (response.success) {
                $('#successModal').modal('show');
                formModified = false;
                // Rafraîchir la page
                setTimeout(() => { window.location.reload(); }, 2000);
                //window.location.reload();

            } else {
                $('#errorModal .modal-body').html('<div class="alert alert-danger">' + response.message + '</div>');
                $('#errorModal').modal('show');
            }
        },
        error: function(xhr) {
            $('#errorModal .modal-body').html('<div class="alert alert-danger">Erreur lors de l\'envoi du formulaire: ' + xhr.statusText + '</div>');
            $('#errorModal').modal('show');
        },
        complete: function() {
            $('#boutonformelric').prop('disabled', false).text('Valider votre héros');
        }
    });
}
    /***************************************/
    /***************************************/



    // Initialisation des tooltips Bootstrap
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    /***REFRESH****/
    let formModified = false;

    // Détecter les modifications dans le formulaire
    $('#FormElric').on('input change', 'input, select, textarea', function() {
        formModified = true;
    });

    // Fonction pour afficher un message dans le modal
    function showWarningModal(title, message, confirmText, confirmCallback) {
        // Mettre à jour le contenu du modal
        $('#errorModal .modal-title').html(title);
        $('#errorModal .modal-body').html(message);
        $('#errorModal #confirmAction').text(confirmText);

        // Supprimer les anciens gestionnaires d'événements
        $('#errorModal #confirmAction').off('click');

        // Ajouter le nouveau gestionnaire
        $('#errorModal #confirmAction').on('click', confirmCallback);

        // Afficher le modal
        $('#errorModal').modal('show');
    }

    // Intercepter le rafraîchissement
    $(window).on('beforeunload', function(e) {
        if (formModified) {
            e.preventDefault();

            const message = "⚠️ ATTENTION ⚠️\n\n" +
                           "Vous êtes sur le point de rafraîchir la page.\n" +
                           "Toutes les données saisies seront perdues.\n" +
                           "Souhaitez-vous continuer ?";

            e.returnValue = message;
            return message;
        }
    });

    // Capturer l'événement de rafraîchissement effectif
    $(window).on('unload', function() {
        // Vider le localStorage quand la page se rafraîchit vraiment
        localStorage.removeItem('metierCompetences');
    });

    // Réinitialiser quand le formulaire est soumis
    $('#FormElric').on('submit', function() {
        formModified = false;
    });

    /****Fin REFRESH*******/

    // Chargement dynamique de contenu
    // Variable pour suivre si on est en train de charger un métier ou autre chose
    let estChargementMetier = false;

    // Chargement dynamique de contenu - MÉTIERS SEULEMENT
    $('.load_select').on('change', function() {
        let page = $(this).val();
        let selectID = $(this).attr('id');

        if (page) {
            estChargementMetier = true; // On charge un métier
            $('#load_content').fadeOut(200, function() {
                $('#load_content').load('load/load.php?n=' + selectID + '&id=' + page, function() {
                    $(this).fadeIn(200);
                    // Sauvegarder les compétences dans le JSON et colorier
                    sauvegarderEtColorierCompetences();
                    estChargementMetier = false;
                });
            });
        } else {
            // Si on désélectionne un métier, supprimer le JSON et réinitialiser
            localStorage.removeItem('metierCompetences');
            reinitialiserCouleursCompetences();
            estChargementMetier = false;
        }
    });

    // Chargement pour les armes
    $('.load_select_weapon').on('change', function() {
        let page = $(this).val();
        let selectID = $(this).attr('id');
        if (page) {
            estChargementMetier = false; // On charge autre chose qu'un métier
            $('#load_content').fadeOut(200, function() {
                $('#load_content').load('load/load.php?n=' + selectID + '&id=' + page, function() {
                    $(this).fadeIn(200);
                    // Réappliquer les couleurs depuis le JSON (même si le contenu métier n'est plus affiché)
                    appliquerCouleursDepuisJSON();
                });
            });
        } else {
            // Réappliquer les couleurs même si on désélectionne une arme
            appliquerCouleursDepuisJSON();
        }
    });

    function sauvegarderEtColorierCompetences() {
        // Réinitialiser avant de colorier
        reinitialiserCouleursCompetences();

        var texteCompetences = $('.badge.text-bg-success').next('.card-text').text();
        if (!texteCompetences) return;

        var mappingCompetences = {
            'Amorcer Piège': 'amorcer_piege',
            'Art': 'art',
            'Artisanat': 'artisanat',
            'Baratin': 'baratin',
            'Chercher': 'chercher',
            'Crocheter': 'crocheter',
            'Déguisement': 'deguisement',
            'Déplacement silencieux': 'depl_silencieux',
            'Dissimuler objet': 'dissimuler_objet',
            'Ecouter': 'ecouter',
            'Eloquence': 'eloquence',
            'Equitation': 'equitation',
            'Esquive': 'esquive',
            'Evaluer': 'evaluer',
            'Grimper': 'grimper',
            'Jeunes Royaumes': 'jeunes_royaumes',
            'Lancer': 'lancer',
            'Langue étrangère': 'langue_etrangere',
            'Langue maternelle': 'langue_maternelle',
            'Marchander': 'marchander',
            'Médecine': 'medecine',
            'Monde naturel': 'monde_naturel',
            'Natation': 'natation',
            'Navigation': 'navigation',
            'Orientation': 'orientation',
            'Pister': 'pister',
            'Potions': 'potions',
            'Réparer/Concevoir': 'reparer_concevoir',
            'Royaumes Inconnus': 'royaumes_inconnus',
            'Sagacité': 'sagacite',
            'Sauter': 'sauter',
            'Scribe': 'scribe',
            'Se cacher': 'se_cacher',
            'Sentir/Goûter': 'sentir_gouter'
        };

        var texteNormalise = texteCompetences
            .toLowerCase()
            .normalize("NFD").replace(/[\u0300-\u036f]/g, "");

        var competencesTrouvees = [];

        Object.keys(mappingCompetences).forEach(function(competence) {
            var competenceNormalisee = competence
                .toLowerCase()
                .normalize("NFD").replace(/[\u0300-\u036f]/g, "");

            var regex = new RegExp('\\b' + escapeRegExp(competenceNormalisee) + '\\b', 'i');

            if (regex.test(texteNormalise)) {
                var id = mappingCompetences[competence];
                competencesTrouvees.push(id);
                $('#' + id).addClass('competence-active');
            }
        });

        // Sauvegarder les compétences trouvées dans le localStorage
        localStorage.setItem('metierCompetences', JSON.stringify(competencesTrouvees));
        console.log('Compétences sauvegardées:', competencesTrouvees);
    }

    function appliquerCouleursDepuisJSON() {
        // Réinitialiser d'abord
        reinitialiserCouleursCompetences();

        // Récupérer le JSON du localStorage
        var competencesJSON = localStorage.getItem('metierCompetences');

        if (competencesJSON) {
            var competences = JSON.parse(competencesJSON);
            console.log('Compétences restaurées:', competences);

            // Appliquer les couleurs pour chaque compétence sauvegardée
            competences.forEach(function(idCompetence) {
                if ($('#' + idCompetence).length) {
                    $('#' + idCompetence).addClass('competence-active');
                }
            });
        }
    }

    function reinitialiserCouleursCompetences() {
        // Liste de tous les IDs de compétences
        var idsCompetences = [
            'amorcer_piege', 'art', 'artisanat', 'baratin', 'chercher', 'crocheter',
            'deguisement', 'depl_silencieux', 'dissimuler_objet', 'ecouter', 'eloquence',
            'equitation', 'esquive', 'evaluer', 'grimper', 'jeunes_royaumes', 'lancer',
            'langue_etrangere', 'langue_maternelle', 'marchander', 'medecine', 'monde_naturel',
            'natation', 'navigation', 'orientation', 'pister', 'potions', 'reparer_concevoir',
            'royaumes_inconnus', 'sagacite', 'sauter', 'scribe', 'se_cacher', 'sentir_gouter'
        ];

        idsCompetences.forEach(function(id) {
            $('#' + id).removeClass('competence-active');
        });
    }

    // Fonction pour échapper les caractères spéciaux des regex
    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    // Au chargement de la page, appliquer les couleurs si un métier était sélectionné
    $(document).ready(function() {
        appliquerCouleursDepuisJSON();
    });
/**********************************************************/


/********************************** */
/***********Nom aleatoire********** */
const prenoms = [
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
		"Ulfred", "Valentin", "Zoran", "Anwen", "Briony", "Celestia", "Daphne", "Elowen", "Fiora", "Giselle","Gwanael", "Jem","Uldéric","Johannes","Siegdfried","Sigismond","Sigmar","Sigurd","Sigwald","Sigwulf", "Ludwig", "Ludovic","Liv","Stéfania"
];

const noms = [
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
		"Soren", "Tirin", "Ulgor", "Valrin"
];

function genererNomAleatoire() {
  const prenom = prenoms[Math.floor(Math.random() * prenoms.length)];
  const nom = noms[Math.floor(Math.random() * noms.length)];
  return prenom + " " + nom.toUpperCase();
}

$('#nom_personnage').val(genererNomAleatoire());
$('#generer_nom').click(function() {
  $('#nom_personnage').val(genererNomAleatoire());
});

/*********** Système de points (250 points) **********/
let totalPoints = 250;
let baseValues = {};
let calculatedFields = ['esquive', 'langue_maternelle', 'reparer_concevoir'];

// Initialisation des valeurs de base
function initializeBaseValues() {
  $("input[type='number']").each(function() {
      let $input = $(this);
      let name = $input.attr('name');
      let baseValue = parseInt($input.val()) || 0;

      // Pour les champs calculés, on initialise selon les caractéristiques
      if (calculatedFields.includes(name)) {
          if (name === 'esquive') baseValue = (parseInt($('#dexterite').val()) || 0) * 2;
          if (name === 'langue_maternelle') baseValue = (parseInt($('#intelligence').val()) || 0) * 5;
          if (name === 'reparer_concevoir') baseValue = (parseInt($('#dexterite').val()) || 0) * 4;
          $input.val(baseValue);
      }

      baseValues[name] = baseValue;
      $input.attr('min', baseValue);
      $input.attr('max', 100);

      // Empêcher la saisie manuelle hors limites
      $input.on('keydown', function(e) {
          if (e.key === '-' || e.key === '+') {
              return false;
          }
      });
  });
}

// Gestion des modifications des champs
$("input[type='number']").on('input', function() {
  let sum = 0;
  let currentInput = $(this);
  let currentValue = parseInt(currentInput.val()) || baseValues[currentInput.attr('name')];
  let baseValue = baseValues[currentInput.attr('name')];

  // Corriger la valeur si hors limites
  if (currentValue < baseValue) {
      currentInput.val(baseValue);
      currentValue = baseValue;
  } else if (currentValue > 100) {
      currentInput.val(100);
      currentValue = 100;
  }

  // Calculer le total des points utilisés
  $("input[type='number']").each(function() {
      let $input = $(this);
      let value = parseInt($input.val()) || baseValues[$input.attr('name')];
      sum += (value - baseValues[$input.attr('name')]);
  });

  let pointsRestants = totalPoints - sum;

  // Gérer le cas où on dépasse la limite
  if (pointsRestants < 0) {
      currentInput.val(currentInput.data('prev-value') || baseValue);
      $('#pointsModal').modal('show');
      return;
  }

  // Stocker la valeur actuelle comme précédente valide
  currentInput.data('prev-value', currentValue);

  // Mettre à jour l'affichage
  $("#points").text(pointsRestants);
});

// Initialisation du modal
$('#pointsModal').on('show.bs.modal', function() {
  $(this).find('.modal-body').html('Vous avez utilisé tous vos 250 points !<br>Diminuez une autre compétence si vous voulez augmenter celle-ci.');
});

/************ Jet de dés ************/
function rollDice() {
  return Math.floor(Math.random() * (18 - 6 + 1)) + 6;
}

// Tableau des modificateurs de dégâts
const damageModifiers = [
  { min: 2, max: 12, value: "-1D6" },
  { min: 13, max: 16, value: "-1D4" },
  { min: 17, max: 24, value: "0" },
  { min: 25, max: 32, value: "+1D4" },
  { min: 33, max: 40, value: "+1D6" },
  { min: 41, max: 56, value: "+2D6" },
  { min: 57, max: 72, value: "+3D6" },
  { min: 73, max: 88, value: "+4D6" },
  { min: 89, max: 104, value: "+5D6" },
  { min: 105, max: 120, value: "+6D6" },
  { min: 121, max: 136, value: "+7D6" },
  { min: 137, max: 152, value: "+8D6" },
  { min: 153, max: 168, value: "+9D6" },
  { min: 169, max: 184, value: "+10D6" }
];

// Fonction pour arrondir au supérieur
function ceil(num) {
  return Math.ceil(num);
}

// Calculer le modificateur de dégâts
function getDamageModifier(force, taille) {
  const total = force + taille;
  const mod = damageModifiers.find(m => total >= m.min && total <= m.max);
  return mod ? mod.value : "0";
}

// Mise à jour des valeurs calculées
function updateCalculatedValues() {
  const con = parseInt($('#constitution').val()) || 0;
  const tai = parseInt($('#taille').val()) || 0;
  const forc = parseInt($('#force').val()) || 0;
  const dex = parseInt($('#dexterite').val()) || 0;
  const int = parseInt($('#intelligence').val()) || 0;

  // Calculs de base
  $('#pts_vie').val(con + ceil(tai / 2));
  $('#pts_magie').val(parseInt($('#pouvoir').val()) || 0);
  $('#mod_degats').val(getDamageModifier(forc, tai));

  // Mise à jour des champs calculés (seulement si pas encore modifiés manuellement)
  $('input[name="esquive"]').each(function() {
      if (!$(this).data('manually-modified')) {
          $(this).val(dex * 2);
          baseValues['esquive'] = dex * 2;
      }
  });

  $('input[name="langue_maternelle"]').each(function() {
      if (!$(this).data('manually-modified')) {
          $(this).val(int * 5);
          baseValues['langue_maternelle'] = int * 5;
      }
  });

  $('input[name="reparer_concevoir"]').each(function() {
      if (!$(this).data('manually-modified')) {
          $(this).val(dex * 4);
          baseValues['reparer_concevoir'] = dex * 4;
      }
  });
}

// Marquer les champs comme modifiés manuellement
$('input[name="esquive"], input[name="langue_maternelle"], input[name="reparer_concevoir"]').on('input', function() {
  $(this).data('manually-modified', true);
});

// Gestion des jets de dés
function handleRoll(buttonId, inputId) {
  var clickCount = 0;

  $(buttonId).on('click', function() {
      if (clickCount < 3) {
          var ValRollDice = rollDice();
          $(inputId).val(ValRollDice).trigger('change');

          // Mise à jour des valeurs liées
          switch(buttonId) {
              case '#rollIntelligence':
                  $('#pourc_idee').val(ValRollDice * 5);
                  $('input[name="langue_maternelle"]').val(ValRollDice * 5).data('manually-modified', false);
                  baseValues['langue_maternelle'] = ValRollDice * 5;
                  break;
              case '#rollPouvoir':
                  $('#pourc_chance').val(ValRollDice * 5);
                  $('#pts_magie').val(ValRollDice);
                  break;
              case '#rollDexterite':
                  $('#pourc_dexterite').val(ValRollDice * 5);
                  $('input[name="esquive"]').val(ValRollDice * 2).data('manually-modified', false);
                  $('input[name="reparer_concevoir"]').val(ValRollDice * 4).data('manually-modified', false);
                  baseValues['esquive'] = ValRollDice * 2;
                  baseValues['reparer_concevoir'] = ValRollDice * 4;
                  break;
              case '#rollApparence':
                  $('#pourc_charisme').val(ValRollDice * 5);
                  break;
          }

          clickCount++;
          updateCalculatedValues();
          $("input[type='number']").trigger('input'); // Mettre à jour le compteur de points
      }

      if (clickCount >= 3) {
          $(buttonId).prop('disabled', true);
      }
  });





  // Fonction pour générer le background du personnage
  function genererBackground() {
    // Récupérer les valeurs du formulaire
    const nom = $('#nom_personnage').val();
    const age = $('#age').val();
    const sexe = $('#sexe').val();
    const nationalite = $('#nations option:selected').text(); // Récupère le texte de l'option sélectionnée
    const profession = $('#profession option:selected').text(); // Récupère le texte de l'option sélectionnée
    const force = $('#force').val();
    const intelligence = $('#intelligence').val();
    const pouvoir = $('#pouvoir').val();
    const taille = $('#taille').val();
    const constitution = $('#constitution').val();
    const dexterite = $('#dexterite').val();
    const apparence = $('#apparence').val();
    const style = $('#style').val()

    // Déterminer si le personnage utilise la magie
    const dieu = $('#dieu').val();
    const sort1 = $('#sorts_1').val();
    const sort2 = $('#sorts_2').val();
    const sort3 = $('#sorts_3').val();
    const magie = (sort1 || sort2 || sort3) ? "OUI" : "NON";

    // Créer le template avec les valeurs remplacées
    const backgroundTemplate = `
    Crée un background détaillé pour un personnage de JDR avec ces caractéristiques :<br>
    Nom : <b>${nom}</b><br>
    Nation : <b>${nationalite}</b><br>
    Profession : <b>${profession}</b><br>
    Traits principaux : <br>
    - Age : <b>${age}</b><br>
    - Sexe : <b>${sexe}</b><br>
    - Force : <b>${force}/20</b><br>
    - Intelligence : <b>${intelligence}/20</b><br>
    - Pouvoir : <b>${pouvoir}/20</b><br>
    - Taille : <b>${taille}/20</b><br>
    - Constitution : <b>${constitution}/20</b><br>
    - Dextérité : <b>${dexterite}/20</b><br>
    - Apparence : <b>${apparence}/20</b><br>
    - Dieu :  <b>${dieu}</b><br>
    - Utilisation de la magie : <b>${magie}</b><br>

    Génère une histoire crédible de 150-200 mots incluant :<br>
    1. Origines et enfance<br>
    2. Événement marquant<br>
    3. Motivation actuelle<br>
    4. Optionnel : Particularité mystérieuse<br>
    Ton style doit être : <b>${style}</b>.<br>
    Ce personnage doit respecter l'univers d'Elric/Stormbringer de Michael Moorcock.`;

    // Afficher le résultat dans un élément (par exemple avec l'id 'resultat-background')
    $('#resultat-background').html(backgroundTemplate);
  }

  // Appeler cette fonction lors de la soumission du formulaire ou via un bouton
  $('#generer-background').click(function() {
    genererBackground();
  });

}

// Appliquer la fonction handleRoll à chaque bouton
handleRoll('#rollForce', '#force');
handleRoll('#rollConstitution', '#constitution');
handleRoll('#rollTaille', '#taille');
handleRoll('#rollIntelligence', '#intelligence');
handleRoll('#rollPouvoir', '#pouvoir');
handleRoll('#rollDexterite', '#dexterite');
handleRoll('#rollApparence', '#apparence');

// Écouter les changements pour les calculs automatiques
$('#force, #constitution, #taille, #dexterite, #intelligence, #pouvoir, #apparence').on('change input', function() {
  updateCalculatedValues();
});

// Initialisation
initializeBaseValues();
updateCalculatedValues();
$("#points").text(totalPoints); // Afficher les points initiaux


/*****************UPLOAD******************/

$('#uploadBtn').on('click', function() {
    const fileInput = $('#image')[0];

    if(!fileInput.files || fileInput.files.length === 0) {
        showMessage('Veuillez sélectionner une image', 'warning');
        return;
    }

    $('#spinner').removeClass('d-none');
    $('#uploadMessage').html('');

    const formData = new FormData();
    formData.append('image', fileInput.files[0]);

    $.ajax({
        url: '../requete/upload.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            $('#spinner').addClass('d-none');

            try {
                const data = typeof response === 'object' ? response : JSON.parse(response);

                if(data.success) {
                    $('#previewImage').attr('src', data.filepath + '?' + new Date().getTime());
                    $('#preview').show();

                    // Remplit le champ caché pour la base de données
                    $('#avatarField').val(data.filename);

                    showMessage('Image uploadée avec succès!', 'success');
                } else {
                    showMessage(data.error || 'Erreur inconnue', 'danger');
                }
            } catch(e) {
                showMessage('Erreur de traitement', 'danger');
                console.error(e);
            }
        },
        error: function(xhr) {
            $('#spinner').addClass('d-none');
            try {
                const err = JSON.parse(xhr.responseText);
                showMessage(err.error || 'Erreur serveur', 'danger');
            } catch(e) {
                showMessage('Erreur de communication', 'danger');
            }
        }
    });
});

function showMessage(msg, type) {
    $('#uploadMessage').html(`<div class="alert alert-${type} mt-2">${msg}</div>`);
}
/****************************************** */


/************ Register **************/

    // Vérification du mot de passe
    $('#password').on('input', function() {
        const password = $(this).val();

        // Vérification des règles
        const hasUpper = /[A-Z]/.test(password);
        const hasNumber = /\d/.test(password);
        const hasSpecial = /[!@#$%^&*()_+]/.test(password);
        const hasLength = password.length >= 8;

        // Mise à jour visuelle
        $('#uppercase').toggleClass('text-danger', !hasUpper).toggleClass('text-success', hasUpper);
        $('#number').toggleClass('text-danger', !hasNumber).toggleClass('text-success', hasNumber);
        $('#special').toggleClass('text-danger', !hasSpecial).toggleClass('text-success', hasSpecial);
        $('#length').toggleClass('text-danger', !hasLength).toggleClass('text-success', hasLength);
    });

    // Vérification de la correspondance des mots de passe
    $('#password2').on('input', function() {
        const password = $('#password').val();
        const password2 = $(this).val();
        const match = password === password2 && password !== '';

        $(this).toggleClass('is-invalid', !match);
        $(this).toggleClass('is-valid', match);
        $('#passwordMatch').toggle(!match);
    });

    // Vérification de l'email
    $('#mail').on('blur', function() {
        const email = $(this).val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
            $(this).addClass('is-invalid');
            return;
        }

        // Vérification si l'email existe déjà
        $.ajax({
            url: '../requete/check_email.php',
            method: 'POST',
            data: { email: email },
            success: function(response) {
                if (response.exists) {
                    $('#mail').addClass('is-invalid').removeClass('is-valid');
                } else {
                    $('#mail').addClass('is-valid').removeClass('is-invalid');
                }
            }
        });
    });

    // Vérification du nom d'utilisateur
    $('#username').on('blur', function() {
        const username = $(this).val();

        if (username.length < 3) {
            $(this).addClass('is-invalid').removeClass('is-valid');
            return;
        }

        // Vérification si le nom d'utilisateur existe déjà
        $.ajax({
            url: '../requete/check_username.php',
            method: 'POST',
            data: { username: username },
            success: function(response) {
                if (response.exists) {
                    $('#username').addClass('is-invalid').removeClass('is-valid');
                } else {
                    $('#username').addClass('is-valid').removeClass('is-invalid');
                }
            }
        });
    });

    // Rafraîchissement du CAPTCHA
    $('#refreshCaptcha').click(function() {
        $('#captcha').attr('src', '../requete/captcha.php?' + new Date().getTime());
    });

    // Soumission du formulaire
    $('#registerForm').submit(function(e) {
        e.preventDefault();

        // Validation finale
        const username = $('#username').val();
        const email = $('#mail').val();
        const password = $('#password').val();
        const password2 = $('#password2').val();
        const csrf_token = $('input[name="csrf_token_register"]').val();
        const captcha = $('#captcha').val();

        // Vérification des règles du mot de passe
        const isValidPassword = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+]).{8,}$/.test(password);

        if (!isValidPassword) {
            alert('Le mot de passe doit contenir :\n- Au moins 8 caractères\n- Une majuscule\n- Un chiffre\n- Un caractère spécial (!@#$%^&*()_+)');
            return false;
        }

        if (password !== password2) {
            alert('Les mots de passe ne correspondent pas.');
            return false;
        }

        if ($('#username').hasClass('is-invalid')) {
            alert('Nom d\'utilisateur invalide ou déjà pris.');
            return false;
        }

        if ($('#mail').hasClass('is-invalid')) {
            alert('Email invalide ou déjà utilisé.');
            return false;
        }

        if (captcha.length === 0) {
            alert('Veuillez entrer le code CAPTCHA.');
            return false;
        }

        // Envoi des données via AJAX
        $.ajax({
            url: '../requete/register_user.php',
            method: 'POST',
            data: {
                username: username,
                email: email,
                password: password,
                captcha: captcha,
                csrf_token_register: csrf_token
            },
            success: function(response) {
                if (response.success) {
                    alert('Inscription réussie !');
                    window.location.href = '../index.php'; // Redirection vers la page de connexion
                } else {
                    alert('Erreur : ' + response.message);
                    if (response.captcha_error) {
                        $('#captcha').attr('src', '../requete/captcha.php?' + new Date().getTime());
                    }
                }
            },
            error: function() {
                alert('Une erreur est survenue lors de l\'inscription.');
            }
        });
    });

    /***************** Fin Register ************/

    /******************Login form **************/
    $('#loginForm').submit(function(e) {
        e.preventDefault();

        // Réinitialisation
        $('.is-invalid').removeClass('is-invalid');
        $('#loginError').remove();

        // Récupération des valeurs
        const formData = {
            email: $('#mail-login').val().trim(),
            password: $('#password-login').val(),
            csrf_token_login: $('input[name="csrf_token_login"]').val()
        };

        // Validation
        let isValid = true;

        if (!formData.email) {
            $('#mail-login').addClass('is-invalid');
            isValid = false;
        } else if (!/^\S+@\S+\.\S+$/.test(formData.email)) {
            $('#mail-login').addClass('is-invalid');
            isValid = false;
        }

        if (!formData.password || formData.password.length < 8) {
            $('#password-login').addClass('is-invalid');
            isValid = false;
        }

        if (!isValid) return;

        // Envoi AJAX
        $.ajax({
            url: '../requete/authentification.php',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect || '/';
                } else {
                    if (response.csrf_invalid) {
                        // Rafraîchissement silencieux
                        location.reload();
                    } else {
                        showError(response.message || 'Erreur inconnue');
                    }
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON?.csrf_invalid) {
                    location.reload();
                } else {
                    showError(xhr.responseJSON?.message || 'Erreur serveur');
                }
            }
        });
    });

    function showError(message) {
        // Afficher le message d'erreur
        $('#loginForm').append(
            `<div id="loginError" class="alert alert-danger mt-3">
                ${message}
            </div>`
        );

        // Compte à rebours avant rafraîchissement
        let seconds = 5;
        const countdown = setInterval(() => {
            seconds--;
            $('#countdown').text(seconds);

            if (seconds <= 0) {
                clearInterval(countdown);
                /*location.reload();*/
            }
        }, 1000);
    }
    /****************** Fin Login form **************/



    /******* Requete Lost Mail ***********/
    $('#LostMailForm').submit(function(e) {
        e.preventDefault();

        // Réinitialisation des messages
        $('#mail-login-lost').removeClass('is-invalid');
        $('#lostMailError, #lostMailSuccess').remove();

        const email = $('#mail-login-lost').val().trim();
        const csrf_token_lost = $('input[name="csrf_token_lost"]').val();

        // Validation basique
        if (!email) {
            $('#mail-login-lost').addClass('is-invalid');
            return;
        }

        // Envoi AJAX
        $.ajax({
            url: '../requete/reset_password.php',
            type: 'POST',
            dataType: 'json',
            data: {
                email: email,
                csrf_token_lost: csrf_token_lost
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                } else {
                    alert("Erreur: " + response.message);
                }
            },
            error: function() {
                alert("Erreur lors de la communication avec le serveur");
            }
        });
    });
    /******* Fin Requete Lost Mail ***********/

    /*********** Modifier le mot de passe **********/
    // Validation en temps réel
    $('#password').on('input', function() {
        const password = $(this).val();
        const hasUpper = /[A-Z]/.test(password);
        const hasNumber = /\d/.test(password);
        const hasSpecial = /[!@#$%^&*()_+]/.test(password);
        const hasLength = password.length >= 8;

        $('#uppercase').toggleClass('text-danger', !hasUpper).toggleClass('text-success', hasUpper);
        $('#number').toggleClass('text-danger', !hasNumber).toggleClass('text-success', hasNumber);
        $('#special').toggleClass('text-danger', !hasSpecial).toggleClass('text-success', hasSpecial);
        $('#length').toggleClass('text-danger', !hasLength).toggleClass('text-success', hasLength);
    });

    // Vérification correspondance des mots de passe
    $('#password2').on('input', function() {
        const match = $(this).val() === $('#password').val();
        $(this).toggleClass('is-invalid', !match);
        $('#passwordMatch').toggle(!match);
    });

    // Soumission du formulaire
    $('#loginResetPwdForm').submit(function(e) {
        e.preventDefault();

        // Validation finale
        const password = $('#password').val();
        const password2 = $('#password2').val();
        const token = $('input[name="token"]').val();
        const csrf_token = $('input[name="csrf_token_register"]').val();

        // Vérification règles mot de passe
        const isValid = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+]).{8,}$/.test(password);

        if (!isValid) {
            alert('Le mot de passe ne respecte pas les exigences de sécurité');
            return false;
        }

        if (password !== password2) {
            alert('Les mots de passe ne correspondent pas');
            return false;
        }

        // Envoi AJAX
        $.ajax({
            url: '../requete/reset_password_process.php',
            method: 'POST',
            dataType: 'json',
            data: {
                token: token,
                password: password,
                password2: password2,
                csrf_token_register: csrf_token
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    window.location.href = '../?p=login'; // Redirection vers la page de connexion
                } else {
                    alert('Erreur : ' + response.message);
                    if (response.new_token) {
                        $('input[name="csrf_token_register"]').val(response.new_token);
                    }
                }
            },
            error: function(xhr) {
                alert('Erreur serveur : ' + xhr.statusText);
            }
        });
    });

});
