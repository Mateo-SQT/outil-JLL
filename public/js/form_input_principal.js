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
