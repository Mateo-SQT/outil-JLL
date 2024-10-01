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
    <title>Connexion</title>
    <link rel="icon" href="media/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <link rel="stylesheet" href="css/style_auth.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php 
if (isset($_POST['button_con'])) {
    // Se connecter à la base de données
    include "../src/php/connexion_bdd.php";
    
    // Extraire les infos du formulaire
    extract($_POST);
    
    // Vérifions si les champs sont vides
    if (!empty($email) && !empty($mdp1)) {
        // Vérifions si les identifiants sont corrects
        $req = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
        
        // Vérifiez si la requête a réussi
        if (!$req) {
            die('Erreur SQL : ' . mysqli_error($con));
        }
        
        if (mysqli_num_rows($req) > 0) {
            $user = mysqli_fetch_assoc($req);
            if (password_verify($mdp1, $user['password_hash'])) {
                // Incrémenter le nombre de connexions directement
                mysqli_query($con, "UPDATE users SET nombre_connexions = nombre_connexions + 1 WHERE email = '$email'");

                // Création d'une session qui contient l'email et l'ID de l'utilisateur
                $_SESSION['user'] = $email;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role_id'] = $user['role_id']; // Récupération du rôle

                // Redirection en fonction du rôle
                if ($user['role_id'] == 2) { // Supposons que 2 est l'ID du rôle admin
                    header("Location: ../src/php/administrateur.php");
                } else {
                    header("Location: ../src/php/load.php");
                }
                exit(); // Ajouter exit après header pour éviter d'exécuter le reste du code
            } else {
                $error = "Email ou mot de passe incorrect !";
            }
        } else {
            $error = "Email ou mot de passe incorrect !";
        }
    } else {
        // Si les champs sont vides
        $error = "Veuillez remplir tous les champs !";
    }
}

?>

<section class="overflow-hidden mt-0">
    <div class="container px-4 py-4 px-md-5 text-center text-lg-start my-5">
        <div class="row gx-lg-5 align-items-center mb-5">
            <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                <h1 class="my-2 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                    <img src="media/image.png" class="img-fluid d-block mx-auto w-50" alt="Image centrée avec Bootstrap"> <br />
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
                        <h2 class="text-center">CONNEXION</h2>
                        <form action="" method="POST" class="form_connexion_inscription" id="form"> 
                            <?php
                            // Affichons le message qui dit qu'un compte a été créé
                            if (isset($_SESSION['message'])) {
                                echo $_SESSION['message'];
                            }
                            ?>

                            <p class="message_error">
                                <?php
                                // Affichons l'erreur
                                if (isset($error)) {
                                    echo $error;
                                }
                                ?>
                            </p>

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

                            <button type="submit" class="btn btn-primary btn-block mb-3" value="Connexion" name="button_con">Se connecter</button>

                            <p class="link text-center">Vous n'avez pas de compte ? <br> <a href="../src/php/inscription.php">Créer un compte</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>

    function validateRequired(input) {
        if (input.value.trim() === "") {
            input.classList.add("is-invalid");
            return false;
        } else {
            input.classList.remove("is-invalid");
            return true;
        }
    }

    const EMAIL_REGEX = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    function validateEmail(input) {
        return EMAIL_REGEX.test(input.value);
    }

    const PASSWORD_REGEX = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

    function validatePassword(input) {
        return PASSWORD_REGEX.test(input.value);
    }

    function validateFields(input) {
        let fieldName = input.name;

        // Validation de l'email
        if (fieldName === "email") {
            if (!validateRequired(input)) {
                return false;
            }
            if (!validateEmail(input)) {
                input.classList.add("is-invalid");
                return false;
            }
            input.classList.remove("is-invalid");
            return true;  // Email valide
        }

        // Validation du mot de passe
        if (fieldName === "mdp1") {
            if (!validateRequired(input)) {
                return false;
            }
            if (!validatePassword(input)) {
                input.classList.add("is-invalid");
                return false;
            }
            input.classList.remove("is-invalid");
            return true;  // Mot de passe valide
        }

        return true;  // Par défaut, si aucune autre condition n'est remplie
    }

    // Événement de soumission du formulaire
    document.getElementById("form").addEventListener("submit", function(event) {
        let inputs = this.querySelectorAll("input");
        let valid = true;

        inputs.forEach(function(input) {
            if (!validateFields(input)) {
                valid = false;
            }
        });

        if (!valid) {
            event.preventDefault();  // Empêche l'envoi du formulaire si invalide
        }
    });

</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
    
</body>
</html>
