<?php 
session_start();
include "connexion_bdd.php";

$total_users = 0;
$total_connections = 0;
$users = [];
$message = '';
$user_to_modify = null;
$user_found = false;

// Vérifiez la connexion
if (!$con) {
    die("Erreur de connexion à la base de données.");
}

// Récupérer le nom de l'utilisateur connecté
$query = $con->prepare("SELECT name FROM users WHERE id = ?");
$query->bind_param("i", $_SESSION['user_id']);
$query->execute();
$result = $query->get_result();
$user_name = $result->fetch_assoc()['name'] ?? 'Utilisateur';

// Récupérer le nombre total d'utilisateurs et de connexions
if (isset($_POST['Actualiser'])) {
    $query = $con->prepare("SELECT COUNT(*) as total_users FROM users");
    $query->execute();
    $total_users = $query->get_result()->fetch_assoc()['total_users'];

    $query = $con->prepare("SELECT SUM(nombre_connexions) as total_connections FROM users");
    $query->execute();
    $total_connections = $query->get_result()->fetch_assoc()['total_connections'];
}

// Afficher tous les utilisateurs
if (isset($_POST['Afficher'])) {
    $query = $con->prepare("SELECT users.*, roles.name AS role_name FROM users JOIN roles ON users.role_id = roles.id");
    $query->execute();
    $result = $query->get_result();
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Rechercher un utilisateur
if (isset($_POST['Rechercher'])) {
    $nameInput = htmlspecialchars($_POST['searchName']);
    $query = $con->prepare("SELECT * FROM users WHERE name = ?");
    $query->bind_param("s", $nameInput);
    $query->execute();
    $user_to_modify = $query->get_result()->fetch_assoc();

    if ($user_to_modify) {
        $user_found = true;
        $message = "Utilisateur trouvé : " . htmlspecialchars($user_to_modify['name']);
    } else {
        $message = "Utilisateur introuvable.";
    }
}

// Vérifiez le rôle de l'utilisateur connecté
$query = $con->prepare("SELECT roles.name AS role_name FROM users JOIN roles ON users.role_id = roles.id WHERE users.id = ?");
$query->bind_param("i", $_SESSION['user_id']);
$query->execute();
$user_role = $query->get_result()->fetch_assoc()['role_name'] ?? null;

// Modifier un utilisateur
if (isset($_POST['modifier']) && $user_found) {
    if ($user_role !== 'admin') {
        $message = "Vous n'avez pas l'autorisation de modifier les utilisateurs.";
    } else {
        $newName = htmlspecialchars(trim($_POST['newName']));
        $confirmName = htmlspecialchars(trim($_POST['confirmName']));
        $userId = $user_to_modify['id'] ?? null;

        if (empty($newName) || empty($confirmName)) {
            $message = "Les champs sont obligatoires.";
        } elseif ($userId && $newName === $confirmName) {
            $query = $con->prepare("UPDATE users SET name = ? WHERE id = ?");
            $query->bind_param("si", $newName, $userId);
            if ($query->execute()) {
                $message = "Utilisateur modifié avec succès : " . htmlspecialchars($newName);
                $user_to_modify = null; // Réinitialise l'utilisateur trouvé
                $user_found = false; // Réinitialise l'état
            } else {
                $message = "Erreur lors de la modification de l'utilisateur.";
            }
        } else {
            $message = "Les noms ne correspondent pas.";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="JLL" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administration</title>
    <link rel="icon" href="../../public/media/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <link rel="stylesheet" href="../../public/css/style_auth.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        .container-custom-1 {
            margin-bottom: 1rem;
            height: 100%;
        }
        .container-custom-2 {
            margin-bottom: 1rem;
            margin-top: 2rem;
            height: 100%;
        }

        .custom-logo {
            margin-right: 10px;
            color: #fff;
        }
        #loader {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <section class="overflow-hidden mt-0">
        <div class="container px -4 px-md-5 text-center text-lg-start">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mt-5 position-relative d-flex justify-content-center align-items-center">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>
                </div>
                <div class="top-right">
                    <form id="logoutForm" action="deconnexion.php" method="post" onsubmit="return confirmLogout(event);">
                        <button id="logoutButton" class="btn btn-light" type="submit">Déconnexion</button>
                    </form>
                </div>
                <div class="container-fluid position-relative d-flex justify-content-center align-items-center">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="container-custom-1 text-center text-white">
                                <h1>Bienvenue <?php echo htmlspecialchars($user_name); ?></h1>
                                <p>
                                    <span class="custom-logo"><i class="fas fa-user-shield"></i></span>
                                    Voici votre page Administrateur.
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="container-custom-3 text-center position-relative d-flex justify-content-center align-items-center">
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form_connexion_inscription text-left w-75 m-0" id="form-statistics" style="background: white;">
                                    <h4 class="text-center pt-3">Statistiques générales</h4>
                                    <div class="my-3">
                                        <div class="col-12">
                                            <div class="text-center position-relative d-flex justify-content-center align-items-center">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                    <label for="connexion_Input" class="form-label">Nombre total de connexions : <?php echo $total_connections; ?></label>
                                                        <label for="user_Input" class="form-label">Nombre d'utilisateurs : <?php echo $total_users; ?></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label id="nombre_json" for="nombre_json" class="form-label">Nombre de téléchargement de data.json : </label>
                                                        <label id="nombre_shapefile" for="nombre_shapefile" class="form-label">Nombre de téléchargement de shapefile : </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3 pt-3">
                                        <button type="submit" class="btn btn-primary w-50 mb-2" value="Actualiser" name="Actualiser">Actualiser les statistiques</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="container-custom-2  text-center position-relative d-flex justify-content-center align-items-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form_connexion_inscription text-left m-0 p-3" id="form-search" style="background: white;">
                                            <h4 class="text-center p-2">Consulter tous les utilisateurs</h4>
                                            <button type="submit" class="btn btn-primary btn-block mb-3" value="Afficher" name="Afficher">Afficher</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form_connexion_inscription text-left m-0 p-3" id="form-modify" style="background: white;">
                                            <h4 class="text-center">Modifier un utilisateur</h4>
                                            <div class="my-3">
                                                <label for="searchName" class="form-label">Saisir son nom :</label>
                                                <div class="d-flex align-items-center">
                                                    <input type="text" class="form-control me-2" id="searchName" name="searchName" placeholder="le nom" required>
                                                    <button type="submit" class="btn btn-primary mx-1" value="Rechercher" name="Rechercher">Rechercher</button>
                                                </div>
                                            </div>
                                            <?php if ($user_to_modify): ?>
                                                <div class="mb-3">
                                                    <label for="newName" class="form-label">Nouveau Nom</label>
                                                    <input type="text" class="form-control" id="newName" name="newName" placeholder="Nouveau nom" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="confirmName" class="form-label">Confirmation : </label>
                                                    <input type="text" class="form-control" id="confirmName" name="confirmName" placeholder="Confirmer nouveau nom" required>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <button type="submit" class="btn btn-primary btn-block mb-3" value="modifier" name="modifier">Modifier</button>
                                                </div>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (isset($_POST['Afficher'])): ?>
                        <div class="col-12 mt-4">
                            <div class="card card-utilisateur">
                                <div class="card-header">
                                    <h4 class="text-center">Les utilisateurs :</h4>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($users)): ?>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nom</th>
                                                    <th>Email</th>
                                                    <th>Rôle</th>
                                                    <th>Nombre de connexions</th>
                                                    <th>Création du compte</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($users as $user): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                        <td><?php echo htmlspecialchars($user['role_name'] ?? 'Non spécifié'); ?></td>
                                                        <td><?php echo htmlspecialchars($user['nombre_connexions']); ?></td>
                                                        <td><?php echo htmlspecialchars($user['date_creation']); ?></td> 
                                                    </tr>
                                                <?php endforeach; ?>                                               
                                            </tbody>
                                        </table>
                                        <button class="btn btn-custom" onclick="fermerCarte()">Fermer</button>
                                    <?php else: ?>
                                        <p class="text-center">Aucun utilisateur trouvé.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ($message): ?>
                            <div class="alert alert-info mt-3"><?php echo $message; ?></div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

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
        
        function fermerCarte() {
            const carte = document.querySelector('.card-utilisateur');
            carte.style.display = 'none'; // Ou utilise une animation pour la fermer
        }

        async function fetchData() {
            const response = await fetch('/api/fichiers');
            const data = await response.json();
            const nombreJsonLabel = document.querySelector('#nombre_json');
            const nombreShapefileLabel = document.querySelector('#nombre_shapefile');

            // Met à jour le contenu des labels avec les données récupérées
            const jsonFile = data.jsonFiles.find(file => file.type_fichier === 'data.json');
            const shapefile = data.shapefiles.find(file => file.type_fichier === 'Shapefile');

            if (jsonFile) {
                nombreJsonLabel.innerHTML = `Nombre de téléchargement de data.json : ${jsonFile.nombre_telechargements} téléchargements`;
            }

            if (shapefile) {
                nombreShapefileLabel.innerHTML = `Nombre de téléchargement de shapefile : ${shapefile.nombre_telechargements} téléchargements`;
            }
        }
        fetchData();




    </script>
    <script>

    </script>

    <script src="../../public/js/mongo.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
</body>
</html>