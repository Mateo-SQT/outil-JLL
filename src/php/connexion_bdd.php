<?php 
    //Connexion à la base de données
    $con = mysqli_connect("localhost","root","MateoS21!","outil_jll");
    //gérer les accents et autres caractères français
    $req= mysqli_query($con , "SET NAMES UTF8");
    if(!$con){
        //si la connexion échoue , afficher :
        echo "Connexion échouée";
    }


?>