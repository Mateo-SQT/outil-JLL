<?php 
// Démarrer la session
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="JLL" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscription</title>
    <link rel="icon" href="../../public/media/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <link rel="stylesheet" href="../../public/css/style_auth.css">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>

<body>
<?php
    // Vérification de l'envoi du formulaire
    if (isset($_POST['button_inscription'])) {
        include "connexion_bdd.php"; // Se connecter à la base de données
        extract($_POST); // Extraire les infos du formulaire

        // Validation des champs
        if (!empty($email) && !empty($mdp1) && !empty($name) && !empty($mdp2)) {
            if ($mdp2 !== $mdp1) {
                $error = "Les mots de passe sont différents !";
            } else {
                // Vérification de l'existence de l'email
                $req = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
                if (mysqli_num_rows($req) == 0) {
                    // Hachage du mot de passe
                    $password_hash = password_hash($mdp1, PASSWORD_DEFAULT);
                    // Insertion de l'utilisateur dans la base de données
                    $req = mysqli_query($con, "INSERT INTO users (name, email, password_hash, role_id) VALUES ('$name', '$email', '$password_hash', 1)");
                    if ($req) {
                        $_SESSION['message'] = "Votre compte a été créé avec succès !";
                        header("Location: ../../public/index.php");
                        exit();
                    } else {
                        $error = "Inscription échouée !";
                    }
                } else {
                    $error = "Cet email existe déjà !";
                }
            }
        } else {
            $error = "Veuillez remplir tous les champs !";
        }
    }
?>

<section class="overflow-hidden mt-0">
    <div class="container px-4 py-4 px-md-5 text-center text-lg-start my-5">
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                <h1 class="my-2 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                    <img src="../../public/media/image.png" class="img-fluid d-block mx-auto w-50" alt="Image centrée avec Bootstrap"> <br />
                </h1>
                <p class="mb-4 opacity-70" style="color: white">
                    We shape the future of real estate for a better world. <br />
                    Nous façonnons l'avenir de l'immobilier pour un monde meilleur. <br />
                </p>
            </div>

            <div class="col-lg-6 mt-5 position-relative d-flex justify-content-center align-items-center">
                <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                <div class="card card-custom w-75 text-left m-0"> 
                    <div class="card-body"> 
                        <h2 class="text-center">INSCRIPTION</h2>
                        <form action="" method="POST" class="form_connexion_inscription" id="form-inscription">
                            <p class="message_error">
                                <?php 
                                // Affichons l'erreur
                                if (isset($error)) {
                                    echo $error;
                                }
                                ?>
                            </p>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom :</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Votre nom" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email :</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="@gmail.com" required>
                                <div class="invalid-feedback">
                                    Votre adresse mail est invalide.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" class="form-control" name="mdp1" id="password" placeholder="*********" required>
                                <div class="invalid-feedback">
                                    Votre mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirmez votre mot de passe :</label>
                                <input type="password" class="form-control" name="mdp2" id="confirmPassword" placeholder="*********" required>
                                <div class="invalid-feedback">
                                    Votre mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mb-3" value="Inscription" name="button_inscription">S'inscrire</button>

                            <p class="link text-center">Vous avez un compte ? <br> <a href="../../public/index.php">Se connecter</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
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

</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
</body>
</html>
