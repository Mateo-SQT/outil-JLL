<?php
session_start();
include "connexion_bdd.php"; // Incluez votre connexion à la base de données

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../public/index.php");
    exit();
}

// Définir l'URL de redirection
$redirect_url = "outil_page.php"; // Remplacez par l'URL de votre outil JLL
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="JLL" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chargement ...</title>
    <link rel="icon" href="../../public/media/favicon.ico" type="image/x-icon">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/style_auth.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    
    <style>
        .loading-container {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            justify-content: center;
        }
        .logo {
            width: 300px;
            height: 300px;
            background-image: url('../../public/media/image.png');
            background-size: contain;
            background-repeat: no-repeat;
        }
        .loading-text {
            margin-top: 20px;
            font-size: 24px;
            color: #ffffff;
            letter-spacing: 1.5px;
            animation: blink 1s steps(5, start) infinite;
        }
        @keyframes blink {
            50% { opacity: 0; }
        }
    </style>
    <script>
        // Redirection après 4 secondes
        setTimeout(function() {
            window.location.href = "<?php echo $redirect_url; ?>";
        }, 4000);
    </script>
</head>
<body>
    <section class="overflow-hidden mt-0">
        <div class="container px-4 py-4 px-md-5 text-center text-lg-start my-5">
            <div class="loading-container">
                <div class="logo"></div>
                <div class="loading-text">Chargement...</div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.2.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
