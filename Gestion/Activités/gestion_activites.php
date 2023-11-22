<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Activités</title>
    <link rel="stylesheet" href="../../CSS/styles.css">
</head>

<body>

    <a href="../../dashboard.php" class="button">Retour</a>

    <h1 class="Title" class="hey">Ajouter une nouvelle activité</h1 class="Title">
    <div class="form">
        <form method="POST" action="">
            <input type="text" name="nom_act" placeholder="Nom de l'activité" required><br>
            <input type="text" name="site" placeholder="Site" required><br>
            <select name='num_resp' required>
                <?php
                include('../../include/connexion.php');
                $responsablesQuery = "SELECT * FROM responsable";
                $responsablesResult = mysqli_query($conn, $responsablesQuery);
                echo '<option value="" disabled selected>Choisissez un responsable</option>';
                while ($responsable = mysqli_fetch_assoc($responsablesResult)) {
                    echo '<option value="' . $responsable['num_resp'] . '">' . $responsable['nom_resp'] . ' ' . $responsable['prenom_resp'] . '</option>';
                }
                ?>
            </select><br>
            <select name="id_creneau" required>
                <?php
                $creneauxQuery = "SELECT * FROM creneau";
                $creneauxResult = mysqli_query($conn, $creneauxQuery);
                echo '<option value="" disabled selected>Choisissez un créneau</option>';
                while ($creneau = mysqli_fetch_assoc($creneauxResult)) {
                    echo '<option value="' . $creneau['id_creneau'] . '">' . $creneau['heure_debut'] . ' - ' . $creneau['heure_fin'] . '</option>';
                }
                ?>
            </select><br>
            <button type="submit" name="ajouter">Ajouter</button>
        </form>
    </div>

    <h1 class="Title">Liste des Activités</h1 class="Title">

    <?php

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['ajouter'])) {
            // Ajouter une activité
            $nom_act = $_POST['nom_act'];
            $site = $_POST['site'];
            $num_resp = $_POST['num_resp'];
            $id_creneau = $_POST['id_creneau'];

            $insertActiviteQuery = "INSERT INTO activite (nom_act, site, num_resp) VALUES (?, ?, ?)";
            $insertActiviteStmt = mysqli_prepare($conn, $insertActiviteQuery);
            mysqli_stmt_bind_param($insertActiviteStmt, "ssi", $nom_act, $site, $num_resp);

            mysqli_begin_transaction($conn);

            if (mysqli_stmt_execute($insertActiviteStmt)) {
                $id_act = mysqli_insert_id($conn);

                $insertAvoirQuery = "INSERT INTO avoir (id_act, id_creneau) VALUES (?, ?)";
                $insertAvoirStmt = mysqli_prepare($conn, $insertAvoirQuery);
                mysqli_stmt_bind_param($insertAvoirStmt, "ii", $id_act, $id_creneau);

                if (mysqli_stmt_execute($insertAvoirStmt)) {
                    mysqli_commit($conn);
                    echo "<div class='main_message'> Activité ajoutée avec succès.</div>";
                } else {
                    mysqli_rollback($conn);
                    echo "<div class='err_message'> Erreur lors de l'ajout de l'activité : </div>" . mysqli_error($conn);
                }

                mysqli_stmt_close($insertAvoirStmt);
            } else {
                mysqli_rollback($conn);
                echo "<div class='err_message'> Erreur lors de l'ajout de l'activité : </div>" . mysqli_error($conn);
            }

            mysqli_stmt_close($insertActiviteStmt);
        } elseif (isset($_POST['modifier'])) {
            $id_act = $_POST['id_act'];
            $nom_act = $_POST['nom_act'];
            $site = $_POST['site'];
            $num_resp = $_POST['num_resp'];

            // Modifier l'activité
            $updateActiviteQuery = "UPDATE activite SET nom_act = ?, site = ?, num_resp = ? WHERE id_act = ?";
            $updateActiviteStmt = mysqli_prepare($conn, $updateActiviteQuery);
            mysqli_stmt_bind_param($updateActiviteStmt, "ssii", $nom_act, $site, $num_resp, $id_act);

            if (mysqli_stmt_execute($updateActiviteStmt)) {
                echo "<div class='edit_message'> Activité modifiée avec succès.</div>";
            } else {
                echo "<div class='err_message'> Erreur lors de la modification de l'activité : </div>" . mysqli_error($conn);
            }
        } elseif (isset($_POST['supprimer'])) {
            $id_act = $_POST['id_act'];
            $nom_act = $_POST['nom_act'];
            $site = $_POST['site'];
            $num_resp = $_POST['num_resp'];

            // Supprimer l'activité
            $deleteActiviteQuery = "DELETE FROM activite WHERE id_act = ?";
            $deleteActiviteStmt = mysqli_prepare($conn, $deleteActiviteQuery);
            mysqli_stmt_bind_param($deleteActiviteStmt, "i", $id_act);

            if (mysqli_stmt_execute($deleteActiviteStmt)) {
                echo "<div class='del_message'> Activité supprimée avec succès.</div>";
            } else {
                echo "<div class='err_message'> Erreur lors de la suppression de l'activité : </div>" . mysqli_error($conn);
            }

            mysqli_stmt_close($deleteActiviteStmt);
        }
    }

    $activitesQuery = "SELECT a.*, r.num_resp, r.nom_resp, r.prenom_resp, c.id_creneau, c.heure_debut, c.heure_fin 
                       FROM activite a
                       LEFT JOIN responsable r ON a.num_resp = r.num_resp
                       LEFT JOIN avoir av ON a.id_act = av.id_act
                       LEFT JOIN creneau c ON av.id_creneau = c.id_creneau";
    $activitesResult = mysqli_query($conn, $activitesQuery);

    if (mysqli_num_rows($activitesResult) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom de l'activité</th><th>Site</th><th>Responsable</th><th>Créneau</th><th>Action</th></tr>";
        while ($activite = mysqli_fetch_assoc($activitesResult)) {
            echo "<form method='POST' action=''>";
            echo "<tr>";
            echo "<td>{$activite['id_act']}</td>";
            echo "<td><input type='text' name='nom_act' value='{$activite['nom_act']}' required></td>";
            echo "<td><input type='text' name='site' value='{$activite['site']}'></td>";
            echo "<td>";
            echo "<select name='num_resp' required>";
            $responsablesQuery = "SELECT * FROM responsable";
            $responsablesResult = mysqli_query($conn, $responsablesQuery);
            while ($responsable = mysqli_fetch_assoc($responsablesResult)) {
                $selected = ($activite['num_resp'] == $responsable['num_resp']) ? 'selected' : '';
                echo "<option value='{$responsable['num_resp']}' $selected>{$responsable['nom_resp']} {$responsable['prenom_resp']}</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "<td>";
            echo "<select name='id_creneau' required>";
            $creneauxQuery = "SELECT * FROM creneau";
            $creneauxResult = mysqli_query($conn, $creneauxQuery);
            while ($creneau = mysqli_fetch_assoc($creneauxResult)) {
                $selected = ($activite['id_creneau'] == $creneau['id_creneau']) ? 'selected' : '';
                echo "<option value='{$creneau['id_creneau']}' $selected>{$creneau['heure_debut']} - {$creneau['heure_fin']}</option>";
            }
            echo "</select>";
            echo "</td>";
            echo "<td><input type='hidden' name='id_act' value='{$activite['id_act']}'>";
            echo "<button class=\"bt2\" type=\"submit\" name=\"modifier\">Modifier</button> ";
            echo "<button class=\"bt3\" type=\"submit\" name=\"supprimer\">Supprimer</button></td>";
            echo "</tr>";
            echo "</form>";
        }
        echo "</table>";
    } else {
        echo "<div class='err_message'> Aucune activité trouvée.</div>";
    }

    mysqli_close($conn);
    ?>
</body>

</html>