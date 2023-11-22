<?php
session_start();

include('..\..\include\connexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $name = $_POST['name'];
        $pass = $_POST['pass'];
        $role = 'visiteurs';
        $email = $_POST['email'];

        $insert_query ="INSERT INTO utilisateurs (username, password, role, email) VALUES ($name, $pass, $role, $email)";

        if ($conn->query($insert_query) === TRUE) {
            $_SESSION['admin'] = true;
            header('Location: ../dashboard.php');
        } else {
            header('Location: ../index.php?error=2&message=Erreur lors de la création du compte');
        }
    } elseif (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $login_query = "SELECT * FROM utilisateurs WHERE username='$username' AND password='$password'";
        $login_result = $conn->query($login_query);

        if ($login_result->num_rows == 1) {
            $_SESSION['admin'] = true;
            header('Location: ../dashboard.php');
        } else {
            header('Location: ../index.php?error=1&message=Identifiants incorrects');
        }
    }
}

$conn->close();