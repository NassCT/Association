<!-- IMPORTANT | Renommer le fichier exemple_connexion.php par connexion.php -->

<?php
$servername = ""; //Veuillez remplacer par l'adresse IP de votre serveur
$username = ""; //Veuillez remplacer par votre nom d'utilisateur
$password = ""; //Veuillez remplacer par votre mot de passe
$database = ""; //Veuillez remplacer par le nom de votre base de données

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("<div class='err_message'> La connexion à la base de données a échoué :  </div>" . $conn->connect_error);
}

?>
