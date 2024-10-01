//=============== START - DECLARATION DU FORMULAIRE ===============//
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        let form = document.getElementById('form-inscription');

        if (form) {
            form.addEventListener('submit', function (event) {
                let valid = true;  // Vérification de la validité du formulaire

                Array.from(form.elements).forEach((input) => {
                    if (input.type !== "submit") {
                        if (!validateFields(input)) {
                            event.preventDefault();
                            input.classList.remove("is-valid");
                            input.classList.add("is-invalid");
                            valid = false;  // Indique une erreur dans le formulaire
                        } else {
                            input.classList.remove("is-invalid");
                            input.classList.add("is-valid");
                        }
                    }
                });

                // Empêche la soumission du formulaire si une validation échoue
                if (!valid) {
                    event.preventDefault();
                }
            }, false);
        }
    });
})();

// ============== FONCTIONS DE VALIDATION ============== //

// Validation d'un champ REQUIRED
function validateRequired(input) {
    return input.value.trim() !== "";
}

// Validation du nombre de caractères : MIN et MAX
function validateLength(input, minLength, maxLength) {
    return input.value.length >= minLength && input.value.length <= maxLength;
}

// Validation des caractères : LATIN et LETTRES (ajout d'espaces)
function validateText(input) {
    return /^[A-Za-zÀ-ÿ\s\-]+$/.test(input.value); // REGEX
}

// Validation pour saisie d'un chiffre et au moins une majuscule
function validateNumberUpperletter(input) {
    return /^(?=.*[A-Z])(?=.*\d).{8,}$/.test(input.value); // REGEX
}

// Validation d'un e-mail
function validateEmail(input) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(input.value);
}

// ============== VALIDATION DES INPUTS ============== //
function validateFields(input) {
    let fieldName = input.name;

    // Validation de l'email
    if (fieldName === "email") {
        return validateRequired(input) && validateEmail(input);
    }

    // Validation du nom
    if (fieldName === "name") {
        return validateRequired(input) && validateText(input);
    }

    // Validation du mot de passe 1
    if (fieldName === "mdp1") {
        return validateRequired(input) && validateLength(input, 8, 20) && validateNumberUpperletter(input);
    }

    // Validation du mot de passe 2 (confirmation)
    if (fieldName === "mdp2") {
        let password = document.querySelector('input[name="mdp1"]');
        return validateRequired(input) && (input.value === password.value);
    }

    return true;  // Par défaut, si aucune autre condition n'est remplie
}
