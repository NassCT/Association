<?php
session_start();

$mysqli = new mysqli("localhost", "root", "", "association");

if ($mysqli->connect_error) {
    die("<div class='err_message'> La connexion à la base de données a échoué :  </div>" . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        $role = 'visiteurs';
        $email = $_POST['email'];

        $insert_query ="INSERT INTO utilisateurs (username, password, role, email) VALUES ($name, $pass, $role, $email)";

        if ($mysqli->query($insert_query) === TRUE) {
            $_SESSION['admin'] = true;
            header('Location: ../dashboard.php');
        } else {
            header('Location: ../index.php?error=2&message=Erreur lors de la création du compte');
        }
    } elseif (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $login_query = "SELECT * FROM utilisateurs WHERE username='$username' AND password='$password'";
        $login_result = $mysqli->query($login_query);

        if ($login_result->num_rows == 1) {
            $_SESSION['admin'] = true;
            header('Location: ../dashboard.php');
        } else {
            header('Location: ../index.php?error=1&message=Identifiants incorrects');
        }
    }
}

$mysqli->close();
