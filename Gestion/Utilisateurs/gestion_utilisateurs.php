    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modifier un Utilisateur</title>
        <link rel="stylesheet" href="../../assets/css/style.css">
    </head>

    <body>
        <div class="container">
            <!-- NavBar -->
            <aside>
                <!-- Menu -->
                <p>Menu</p>
                <a href="dashboard.php" class="nav-link">
                    <object type="image/svg+xml" data="assets/img/icone/house.svg" class="navbar-icon "></object>
                    <span>Tableau de bord</span>
                </a>
                <a href="Gestion/Utilisateurs/gestion_utilisateurs.php" class="nav-link current-page">
                    <object type="image/svg+xml" data="assets/img/icone/users.svg" class="navbar-icon"></object>
                    <span>Gestion des utilisateurs</span>
                </a>
                <a href="Gestion/Utilisateurs/gestion_utilisateurs.php" class="nav-link">
                    <object type="image/svg+xml" data="assets/img/icone/house.svg" class="navbar-icon"></object>
                    <span>Gestion des responsables</span>
                </a>
                <a href="Gestion/Utilisateurs/gestion_utilisateurs.php" class="nav-link">
                    <object type="image/svg+xml" data="assets/img/icone/house.svg" class="navbar-icon"></object>
                    <span>Gestion des activités</span>
                </a>
                <a href="Gestion/Utilisateurs/gestion_utilisateurs.php" class="nav-link">
                    <object type="image/svg+xml" data="assets/img/icone/house.svg" class="navbar-icon"></object>
                    <span>Gestion des créneaux</span>
                </a>
                <a href="Gestion/Utilisateurs/gestion_utilisateurs.php" class="nav-link">
                    <object type="image/svg+xml" data="assets/img/icone/house.svg" class="navbar-icon"></object>
                    <span>Gestion des participants</span>
                </a>
                <a href="Gestion/Utilisateurs/gestion_utilisateurs.php" class="nav-link">
                    <object type="image/svg+xml" data="assets/img/icone/house.svg" class="navbar-icon"></object>
                    <span>Gestion des participations</span>
                </a>
                <a href="Gestion/Utilisateurs/gestion_utilisateurs.php" class="nav-link">
                    <object type="image/svg+xml" data="assets/img/icone/house.svg" class="navbar-icon"></object>
                    <span>Gestion des utilisateurs</span>
                </a>
                <a href="include/logout.php" class="nav-link">
                    <object type="image/svg+xml" data="assets/img/icone/logout.svg" class="navbar-icon"></object>
                    <span>Déconnexion</span>
                </a>
            </aside>

            <div class="xcontent">
                <h1 class="Title">Modifier un Utilisateur</h1>

                <a href="../../dashboard.php" class="button">Retour</a>

                <?php
                session_start();

                include('../../include/connexion.php');

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $id = $_POST['id'];
                    $newUsername = $_POST['username'];
                    $newPassword = $_POST['password'];
                    $newRole = $_POST['role'];
                    $newEmail = $_POST['email'];

                    $updateQuery = "UPDATE utilisateurs SET username = ?, password = ?, role = ?, email = ? WHERE id = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);
                    mysqli_stmt_bind_param($updateStmt, "ssssi", $newUsername, $newPassword, $newRole, $newEmail, $id);

                    if (mysqli_stmt_execute($updateStmt)) {
                        echo "<div class='edit_message'> Utilisateur modifié avec succès.</div>";
                    } else {
                        echo "<div class='err_message'>Erreur lors de la modification de l'utilisateur :  </div>" . mysqli_error($conn);
                    }

                    mysqli_stmt_close($updateStmt);
                }

                $selectQuery = "SELECT * FROM utilisateurs";
                $result = mysqli_query($conn, $selectQuery);

                if (mysqli_num_rows($result) > 0) {
                    echo "<table id='userTable'>";
                    echo "<thead><tr><th>ID</th><th>Nom d'utilisateur</th><th>Mot de passe</th><th>Rôle</th><th>Email</th><th>Action</th></tr></thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<form method='POST' action=''>";
                        echo "<tr>";
                        echo "<td>{$row['id']}</td>";
                        echo "<td><input type='text' name='username' value='{$row['username']}' required></td>";
                        echo "<td><input type='password' name='password' value='{$row['password']}' required></td>";
                        echo "<td>";
                        echo "<select name='role' required>";
                        echo "<option value='administrations' " . ($row['role'] == 'administrations' ? 'selected' : '') . ">Administrations</option>";
                        echo "<option value='inscriptions' " . ($row['role'] == 'inscriptions' ? 'selected' : '') . ">Inscriptions</option>";
                        echo "<option value='visiteurs' " . ($row['role'] == 'visiteurs' ? 'selected' : '') . ">Visiteurs</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "<td><input type='text' name='email' value='{$row['email']}' required></td>";
                        echo "<td><input type='hidden' name='id' value='{$row['id']}'>";
                        echo "<button class=\"bt2\" type=\"submit\" name=\"modifier\">Modifier</button></td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<div class='err_message'>Aucun utilisateur trouvé.</div>";
                }

                mysqli_close($conn);
                ?>
            </div>

    </body>

    </html>