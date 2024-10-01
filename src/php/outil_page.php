<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="author" content="JLL" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JLL | Outils</title>
  <link rel="icon" href="../../public/media/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/pyodide/dev/full/pyodide.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.6.0/jszip.min.js"></script>

  <link rel="stylesheet" href="../../public/css/style.css">
  <link rel="stylesheet" href="../../public/css/style-drop.css">
  <link rel="stylesheet" href="../../public/css/style_stepbar.css">

</head>

<body style="background-color: #e0c6ad;">
  <div class="parent">
    <div class="child">
      <!-- Contenu de la partie du haut -->
      <div class="top-right">
        <form id="logoutForm" action="deconnexion.php" method="post" onsubmit="return confirmLogout(event);">
          <button id="logoutButton" class="btn btn-light" type="submit">Déconnexion</button>
        </form>
      </div>
      <div class="row justify-content-center text-center">
        <div class="col-12">
          <img src="../../public/media/image.png" alt="Logo JLL" class="img-fluid mx-auto" style="width: 15%; min-width: 150px; margin: 10px;" />
        </div>
      </div>
      <div class="row justify-content-center text-center mt-3">
        <div class="col-12">
          <a href="https://www.jll.fr/fr/terms-of-use" style="color: aliceblue">Propriété intellectuelle et conditions d'utilisation</a>
        </div>
      </div>
      <div class="row justify-content-center text-center mt-3">
        <div class="col-12">
          <p style="color: aliceblue">&copy; JLL - Année dev. 2023 - 2024</p>
        </div>
      </div>
    </div>
    <div class="child" style="padding: 20px;">
      <!-- Contenu de la partie du milieu -->
      <form action="" method="POST" class="form_input_principal" id="form_input_principal">
        <div class="row justify-content-center mt-2 mb-3">
          <div class="col-md-4 mb-3"> <!-- position -->
            <label for="position" class="form-label">Position : </label>
            <div class="input-group" name="position">
              <input type="text" aria-label="latitude" id="latitude" name="latitude" class="form-control" placeholder="Latitude" />
              <div class="invalid-feedback">Votre saisie de coordonnées est invalide.</div>
              <input type="text" aria-label="longitude" id="longitude" name="longitude" class="form-control" placeholder="Longitude" />
              <div class="invalid-feedback">Votre saisie de coordonnées est invalide.</div>
              <button class="btn btn btn-light" type="button" id="button-addon2" onclick="toggleDiv()">
                <i class="fa-solid fa-location-dot" style="color: #000000"></i>
              </button>
              <button class="btn btn btn-light" type="button" id="button-addon3" onclick="address()">
                <i class="fa-solid fa-magnifying-glass" style="color: #000000;"></i>
              </button>
            </div>
            <div id="map" style="display: none;"></div>
            <div id="address" style="display: none;">
              <input type="text" aria-label="addressInput" id="addressInput" name="addressInput" class="form-control" placeholder="Entrez votre adresse" />
              <ul id="suggestions"></ul>
            </div>
          </div>
          <div class="col-md-4"> <!-- Temps en minutes -->
            <label for="temps" class="form-label">Temps en minutes :</label>
            <div class="input-group" name="temps">
              <input aria-label="temps1" type="number" id="temps1" name="temps1" class="form-control" placeholder="Temps 1" />
              <div class="invalid-feedback">Votre saisie de temps de déplacement est invalide.</div>
              <input aria-label="Temps 2" type="number" id="temps2" name="temps2" class="form-control" placeholder="Temps 2" />
              <div class="invalid-feedback">Votre saisie de temps de déplacement est invalide.</div>
              <input aria-label="Temps 3" type="number" id="temps3" name="temps3" class="form-control" placeholder="Temps 3" />
              <div class="invalid-feedback">Votre saisie de temps de déplacement est invalide.</div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center mb-3">
          <div class="col-12 col-md-3 mb-3"> <!-- Régions -->
            <label for="Region" class="form-label">Régions :</label>
            <select class="form-select" name="Region" id="inputGroupSelect">
              <option selected disabled value="">Choisir la région :</option>
              <option value="fr-idf">fr-idf</option>
              <option value="fr-ne">fr-ne</option>
              <option value="fr-ne-amiens">fr-ne-amiens</option>
              <option value="fr-nw">fr-nw</option>
              <option value="fr-se">fr-se</option>
              <option value="fr-sw">fr-sw</option>
            </select>
            <div class="invalid-feedback">Votre saisie de région est invalide.</div>
          </div>
          <div class="col-12 col-md-3"> <!-- Date de départ -->
            <label for="dateInput" class="form-label">Date de départ :</label>
            <input type="date" class="form-control" id="dateInput" name="dateInput">
            <div class="invalid-feedback">Votre saisie de date de départ est invalide.</div>
          </div>
          <div class="col-12 col-md-3"> <!-- Heure de départ -->
            <label for="appt" class="form-label">Heure de départ :</label>
            <input id="appt" name="appt" type="time" class="form-control rounded" placeholder="Entrez votre heure de départ" />
            <div class="invalid-feedback">Votre saisie d'heure de départ est invalide.</div>
          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col mx-5 mt-3 text-center">
            <div class="d-grid gap-2 col-2 mx-auto">
              <button class="btn btn-custom" type="button" value="genere" name="button_genere" onclick="getValue()">Générer</button>
            </div>
          </div>
        </div>
        <div class="row justify-content-center mb-3">
          <div class="col mx-5 mt-3 text-center">
            <div class="d-flex justify-content-center gap-2">
              <button class="btn btn-custom" type="button" ><a href="mailto:email@example.com" style="color: inherit; text-decoration: none;">
                <i class="fas fa-envelope"></i> Contacter
            </a></button>
              <button class="btn btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#infoModal">
                <i class="fas fa-info-circle"></i> Besoin d'aide</button>
                <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="infoModalLabel">Utilisation de l'outil</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <p>Permet de générer des fichiers Json et Shapefile à partir de données géographiques.</p>
                              <br>
                              <p><strong> Saisie : </strong>Entrez vos coordonnées (latitude, longitude), temps de déplacement, sélectionnez une région, et indiquez la date et l'heure de départ.</p>
                              <p><strong> Génération : </strong>Cliquez sur "Générer" pour compiler vos données, avec une progression visible en quatre étapes. Option pour télécharger le Shapefile.</p>
                              <p><strong> Zone de Dépôt : </strong></p>
                                  <ul>
                                      <li><strong>Déposer un Fichier : </strong> Glissez-déposez ou cliquez pour sélectionner un fichier data.json.</li>
                                      <li><strong>Bouton "Envoyer" : </strong> Lancez l'envoi du fichier pour conversion.</li>
                                      <li><strong> Bouton "Télécharger" : </strong> Après conversion, un bouton apparaîtra pour télécharger le fichier converti.</li>
                                  </ul>
                              <p>Avec une interface intuitive, l'application simplifie la gestion de vos données géographiques.</p>    
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
    <div class="row justify-content-center">
      <div class="col-md-5 mt-3">
        <div class="container-fluid mt-4 mb-5 p-4 text-center" style="border-radius: 4px; background-color:aliceblue;">
          <h5>Progression de la génération du Shapefile :</h5>
          <div class="step mt-4" id="progress-bar">
            <div class="step-line"></div>
            <div class="step-item">
              <div class="step-number">1</div>
              <div class="mt-2" id="Donneescompilees" style="display: none;">
                <i class="fa-solid fa-check" style="color: #1ce119;"></i>Données utilisateurs compilées
              </div>
            </div>
            <div class="step-item">
              <div class="step-number">2</div>
              <div class="mt-2" id="API" style="display: none;">
                <i class="fa-solid fa-check" style="color: #1ce119;"></i>Réponse API positive
              </div>
            </div>
            <div class="step-item">
              <div class="step-number">3</div>
              <div class="mt-2" id="GeoJson" style="display: none;">
                <i class="fa-solid fa-check" style="color: #1ce119;"></i>Données GeoJson générées
              </div>
            </div>
            <div class="step-item">
              <div class="step-number">4</div>
              <div class="mt-2">
                <button class="btn btn-primary" id="download" disabled>Télécharger</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5 mt-3">
        <div class="container-fluid mt-4 mb-5 p-3 text-center" style="border-radius: 4px; background-color:aliceblue;">
          <h5>Zone de Dépôt data.json</h5>
          <div class="drop-zone" id="drop-zone">
            Déposez votre fichier ici ou cliquez pour sélectionner
          </div>
          <input type="file" id="fileElem" accept=".json" style="display:none;">
          <div class="text-center">
            <button id="submitBtn" class="btn btn-primary" onclick="triggerPythonScript()"> Envoyer</button>
          </div>
          <div id="outputMessage" class="mt-3"></div>
          <div id="downloadBtnContainer" class="mt-3" style="display:none;">
            <button id="downloadBtn" class="btn btn-success" onclick="downloadFile()"> Télécharger le fichier converti</button>
          </div>
        </div>
      </div>
    </div>   
    <script>
      let confirmed = false;

      function confirmLogout(event) {
          if (!confirmed) {
              event.preventDefault(); // Empêche l'envoi du formulaire
              const button = document.getElementById('logoutButton');
              button.textContent = 'Confirmer'; // Change le texte
              button.classList.remove('btn-light');
              button.classList.add('btn-danger'); // Change le style
              confirmed = true; // Met à jour l'état de confirmation
          } else {
              // Si déjà confirmé, permet l'envoi du formulaire
              return true;
          }
      }

      //=============== START - DECLARATION DU FORMULAIRE ===============//    
    (function () {
        'use strict'

        let form = document.getElementById('form_input_principal');

        form.addEventListener('button', function (event) {
            let valid = true;  // Ajout pour vérifier si tout le formulaire est valide

            Array.from(form.elements).forEach((input) => {
                if (input.type !== "button") {
                    let feedback = input.nextElementSibling;

                    if (!validateFields(input)) {
                        event.preventDefault();
                        event.stopPropagation();

                        input.classList.remove("is-valid");
                        input.classList.add("is-invalid");
                        if (feedback) feedback.style.display = 'block';
                        valid = false;  // Indique une erreur dans le formulaire
                    } else {
                        if (feedback) feedback.style.display = 'none';
                        input.classList.remove("is-invalid");
                        input.classList.add("is-valid");
                    }
                }
            });

            // Empêche la soumission du formulaire si une validation échoue
            if (!valid) {
                event.preventDefault();
            }

        }, false)
    })();

    // ============== FONCTIONS DE VALIDATION ============== //
    // Validation d'un champ REQUIRED
    function validateRequired(input) {
        return !(input.value == null || input.value.trim() === "");
    }

    // Validation du nombre de caractères : MIN et MAX
    function validateLength(input, minLength, maxLength) {
        const length = input.value.length;
        return (minLength === null || length >= minLength) &&
              (maxLength === null || length <= maxLength);
    }

    // Regex pour latitude et longitude
    const LATITUDE_REGEX = /^-?([1-8]?\d(\.\d+)?|90(\.0+)?)$/;
    const LONGITUDE_REGEX = /^-?((1[0-7]\d|[1-9]?\d)(\.\d+)?|180(\.0+)?)$/;

    // Validation de la latitude
    function validateLatitude(input) {
        return LATITUDE_REGEX.test(input.value);
    }

    // Validation de la longitude
    function validateLongitude(input) {
        return LONGITUDE_REGEX.test(input.value);
    }

    // Validation des nombres entiers
    const INTEGER_REGEX = /^\d+$/;
    function validateNombreEntier(input) {
        return INTEGER_REGEX.test(input.value);
    }

    // ============== VALIDATION DES INPUTS ============== //
    function validateFields(input) {
        let fieldName = input.name;

        // Validation de latitude
        if (fieldName === "latitude") {
            if (!validateRequired(input)) {
                return false;
            }
            if (!validateLatitude(input)) {
                return false;
            }
            return true;  // TRUE général
        }

        // Validation de longitude
        if (fieldName === "longitude") {
            if (!validateRequired(input)) {
                return false;
            }
            if (!validateLongitude(input)) {
                return false;
            }
            return true;  // TRUE général
        }

        // Validation de temps 1
        if (fieldName === "temps1") {
            if (!validateRequired(input)) {
                return false;
            }
            if (!validateNombreEntier(input)) {
                return false;
            }
            if (!validateLength(input, 1, 4)) {
                return false;
            }
            return true;  // TRUE général
        }

        // Validation de temps 2 - pas de remplissage obligatoire
        if (fieldName === "temps2") {
            if (!validateLength(input, null, 4)) {
                return false;
            }
            return true;  // TRUE général
        }

        // Validation de temps 3 - pas de remplissage obligatoire
        if (fieldName === "temps3") {
            if (!validateLength(input, null, 4)) {
                return false;
            }
            return true;  // TRUE général
        }

        // Validation de région
        if (fieldName === "Region") {
            if (!validateRequired(input)) {
                return false;
            }
            return true;  // TRUE général
        }

        // Validation de la date de départ
        if (fieldName === "dateInput") {
            if (!validateRequired(input)) {
                return false;
            }
            return true;  // TRUE général
        }

        // Validation de l'heure de départ
        if (fieldName === "appt") {
            if (!validateRequired(input)) {
                return false;
            }
            return true;  // TRUE général
        }

        return true;  // Par défaut, si aucune autre condition n'est remplie
    }

  </script>
  <script src="../../public/js/script-outil.js"></script>
  <script src="../../public/js/script-drop.js"></script>
  <script src="../../public/js/script_annexe.js"></script>
  <script src="../../public/js/script_stepbar.js"></script>
  <script src="../../public/js/form_input_principal.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
  <script async defer onload="initMap()" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>
