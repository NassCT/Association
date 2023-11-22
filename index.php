<!DOCTYPE html>
<html>

<head>
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>

<body>
    <h1 class="Title">Connexion</h1>
    <form method="POST" action="index.php">
        <div class="container">
            <div class="login-page">
                <div class="form">
                    <div class="register-form">
                        <input type="text" name="name" placeholder="Nom">
                        <input type="password" name="pass" placeholder="Mot de passe">
                        <input type="email" name="email" placeholder="Email">
                        <button class="ad_buttons" name="register" type="submit">Créer</button>
                        <p class="message">Déjà inscrit(e) ? <a href="#">S'identifier</a></p>
                    </div>
                    <div class="login-form">
                        <input type="text" name="username" placeholder="Nom d'utilisateur">
                        <input type="password" name="password" placeholder="Mot de passe">
                        <button class="ad_buttons" name="login" type="submit">Se connecter</button>
                        <p class="message">Vous n'êtes pas inscrit(e) ? <a href="#">Créer un compte</a></p>
                    </div>
                    <div class="message-container">
                        <p class="err_message"></p>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    session_start();

    include('include/connexion.php');

    $error_message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['register'])) {
            $username = $_POST['name'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $role = 'visiteurs';

            $insert_query = "INSERT INTO utilisateurs (username, password, role, email) VALUES ('$username', '$password', '$role', '$email')";

            if ($conn->query($insert_query) === TRUE) {
                $_SESSION['admin'] = true;
                header('Location: dashboard.php');
            } else {
                $error_message = "Erreur lors de la création du compte.";
            }
        } elseif (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $login_query = "SELECT * FROM utilisateurs WHERE username='$username' AND password='$password'";
            $login_result = $conn->query($login_query);

            if ($login_result->num_rows == 1) {
                $_SESSION['admin'] = true;
                header('Location: dashboard.php');
            } else {
                $error_message = "Identifiants incorrects.";
            }
        }
    }

    $conn->close();
    ?>

    <script src="Autre/index.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var errorMessage = "<?php echo $error_message; ?>";
            if (errorMessage !== "") {
                document.querySelector('.err_message').textContent = errorMessage;
            }
        });
    </script>
</body>

</html>