<?php 
// Démarrer la session
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("location: ../../public/index.php");
    exit(); // Assurez-vous d'arrêter le script ici
}

// Destruction de toutes les sessions
session_destroy();

// Redirection vers la page de connexion
header("location: ../../public/index.php");
exit(); // Assurez-vous d'arrêter le script ici
?>
