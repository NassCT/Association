<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Créneaux</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>

<body>
    <div class="container">

        <!-- NavBar -->
        <aside>
            <!-- Menu -->
            <p>Menu</p>
            <a href="/Association/dashboard.php" class="nav-link">
                <object type="image/svg+xml" data="/Association/assets/img/icone/house.svg" class="navbar-icon"></object>
                <span>Tableau de bord</span>
            </a>
            <a href="/Association/Gestion/Utilisateurs/gestion_utilisateurs.php" class="nav-link">
                <object type="image/svg+xml" data="/Association/assets/img/icone/users.svg" class="navbar-icon"></object>
                <span>Gestion des utilisateurs</span>
            </a>
            <a href="/Association/Gestion/Utilisateurs/gestion_responsables.php" class="nav-link">
                <object type="image/svg+xml" data="/Association/assets/img/icone/house.svg" class="navbar-icon"></object>
                <span>Gestion des responsables</span>
            </a>
            <a href="/Association/Gestion/Activités/gestion_activites.php" class="nav-link">
                <object type="image/svg+xml" data="/Association/assets/img/icone/house.svg" class="navbar-icon"></object>
                <span>Gestion des activités</span>
            </a>
            <a href="/Association/Gestion/Activités/gestion_creneaux.php" class="nav-link current-page">
                <object type="image/svg+xml" data="/Association/assets/img/icone/house.svg" class="navbar-icon"></object>
                <span>Gestion des créneaux</span>
            </a>
            <a href="/Association/Gestion/Utilisateurs/gestion_participants.php" class="nav-link">
                <object type="image/svg+xml" data="/Association/assets/img/icone/house.svg" class="navbar-icon"></object>
                <span>Gestion des participants</span>
            </a>
            <a href="/Association/Gestion/Activités/gestion_participations.php" class="nav-link">
                <object type="image/svg+xml" data="/Association/assets/img/icone/house.svg" class="navbar-icon"></object>
                <span>Gestion des participations</span>
            </a>
            <a href="/Association/include/logout.php" class="nav-link">
                <object type="image/svg+xml" data="/Association/assets/img/icone/logout.svg" class="navbar-icon logout"></object>
                <span>Déconnexion</span>
            </a>
        </aside>

        <div class="xcontent">

            <a href="../../dashboard.php" class="button">Retour</a>

            <h1 class="Title"><br>Ajouter un nouveau créneau</h1>
            <div class="form">
                <form method="POST" action="">
                    <input type="datetime-local" name="heure_debut" required><br>
                    <input type="datetime-local" name="heure_fin" required><br>
                    <button type="submit" name="ajouter">Ajouter</button>
                </form>
            </div>

            <br></br>
            <h1 class="Title"><br>Liste des Créneaux</h1>

            <?php
            include('../../include/connexion.php');
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $heure_debut = $_POST['heure_debut'];
                $heure_fin = $_POST['heure_fin'];


                if (isset($_POST['ajouter'])) {

                    $insertCreneauQuery = "INSERT INTO creneau (heure_debut, heure_fin) VALUES (?, ?)";
                    $insertCreneauStmt = mysqli_prepare($conn, $insertCreneauQuery);
                    mysqli_stmt_bind_param($insertCreneauStmt, "ss", $heure_debut, $heure_fin);

                    if (mysqli_stmt_execute($insertCreneauStmt)) {
                        echo "<div class='main_message'> Créneau ajouté avec succès.</div>";
                    } else {
                        echo "<div class='err_message'> Erreur lors de l'ajout du créneau : </div>" . mysqli_error($conn);
                    }
                    mysqli_stmt_close($insertCreneauStmt);
                } elseif (isset($_POST['modifier'])) {
                    $id_creneau = $_POST['id_creneau'];

                    // Modifier le créneau
                    $updateCreneauQuery = "UPDATE creneau SET heure_debut = ?, heure_fin = ? WHERE id_creneau = ?";
                    $updateCreaneauStmt = mysqli_prepare($conn, $updateCreneauQuery);
                    mysqli_stmt_bind_param($updateCreaneauStmt, "ssi", $heure_debut, $heure_fin, $id_creneau);

                    if (mysqli_stmt_execute($updateCreaneauStmt)) {
                        echo "<div class='edit_message'> Créneau modifiée avec succès.</div>";
                    } else {
                        echo "<div class='err_message'> Erreur lors de la modification du créneau : </div>" . mysqli_error($conn);
                        mysqli_stmt_close($updateCreaneauStmt);
                    }
                } elseif (isset($_POST['supprimer'])) {
                    $id_creneau = $_POST['id_creneau'];

                    // Supprimer le créneau
                    $deleteCreneauQuery = "DELETE FROM creneau WHERE id_creneau = ?";
                    $deleteCreneauStmt = mysqli_prepare($conn, $deleteCreneauQuery);
                    mysqli_stmt_bind_param($deleteCreneauStmt, "i", $id_creneau);

                    if (mysqli_stmt_execute($deleteCreneauStmt)) {
                        echo "<div class='del_message'> Créneau supprimée avec succès.</div>";
                    } else {
                        echo "<div class='err_message'> Erreur lors de la suppression du créneau : </div>" . mysqli_error($conn);
                        mysqli_stmt_close($deleteCreneauStmt);
                    }
                }
            }


            $creneauxQuery = "SELECT * FROM creneau";
            $creneauxResult = mysqli_query($conn, $creneauxQuery);

            if (mysqli_num_rows($creneauxResult) > 0) {
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Heure de début</th><th>Heure de fin</th><th>Action</th></tr>";
                while ($creneau = mysqli_fetch_assoc($creneauxResult)) {
                    echo "<form method='POST' action=''>";
                    echo "<tr>";
                    echo "<td>{$creneau['id_creneau']}</td>";
                    echo "<td><input type='datetime-local' name='heure_debut' value='{$creneau['heure_debut']}' required></td>";
                    echo "<td><input type='datetime-local' name='heure_fin' value='{$creneau['heure_fin']}' required></td>";
                    echo "<td><input type='hidden' name='id_creneau' value='{$creneau['id_creneau']}' required>";
                    echo "<button class=\"bt2\" type=\"submit\" name=\"modifier\">Modifier</button> ";
                    echo "<button class=\"bt3\" type=\"submit\" name=\"supprimer\">Supprimer</button></td>";
                    echo "</tr>";
                    echo "</form>";
                }
                echo "</table>";
            } else {
                echo "<div class='err_message'> Aucun créneau trouvé.</div>";
            }

            mysqli_close($conn);
            ?>
        </div>
</body>

</html>