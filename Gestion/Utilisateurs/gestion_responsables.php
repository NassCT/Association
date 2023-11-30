<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Responsables</title>
    <link rel="stylesheet" href="../../CSS/style.css">
</head>

<body>

    <a href="../../dashboard.php" class="button">Retour</a>

    <h1 class="Title">Ajouter un nouveau responsable</h1>
    <div class="form">
        <form method="POST" action="">
            <input type="text" name="nom_resp" placeholder="Nom du responsable" required><br>
            <input type="text" name="prenom_resp" placeholder="Prénom du responsable" required><br>
            <button type="submit" name="ajouter">Ajouter</button>
        </form>
    </div>

    <h1 class="Title">Liste des Responsables</h1>

    <?php
    include('../../include/connexion.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nom_resp = $_POST['nom_resp'];
        $prenom_resp = $_POST['prenom_resp'];

        if (isset($_POST['ajouter'])) {
            // Ajouter un responsable

            $insertResponsableQuery = "INSERT INTO responsable (nom_resp, prenom_resp) VALUES (?, ?)";
            $insertResponsableStmt = mysqli_prepare($conn, $insertResponsableQuery);
            mysqli_stmt_bind_param($insertResponsableStmt, "ss", $nom_resp, $prenom_resp);

            if (mysqli_stmt_execute($insertResponsableStmt)) {
                echo "<div class='main_message'> Responsable ajouté avec succès.</div>";
            } else {
                echo "<div class='err_message'> Erreur lors de l'ajout du responsable : </div>" . mysqli_error($conn);
            }

            mysqli_stmt_close($insertResponsableStmt);
        } elseif (isset($_POST['modifier'])) {

            $num_resp = $_POST['num_resp'];

            // Modifier le Responsable
            $updateResponsableQuery = "UPDATE responsable SET nom_resp = ?, prenom_resp = ? WHERE num_resp = ?";
            $updateCreaneauStmt = mysqli_prepare($conn, $updateResponsableQuery);
            mysqli_stmt_bind_param($updateCreaneauStmt, "ssi", $nom_resp, $prenom_resp, $num_resp);

            if (mysqli_stmt_execute($updateCreaneauStmt)) {
                echo "<div class='edit_message'> Responsable modifiée avec succès.</div>";
            } else {
                echo "<div class='err_message'> Erreur lors de la modification du responsable : </div>" . mysqli_error($conn);
                mysqli_stmt_close($updateCreaneauStmt);
            }
        } elseif (isset($_POST['supprimer'])) {

            $num_resp = $_POST['num_resp'];

            // Supprimer le Responsable
            $deleteResponsableQuery = "DELETE FROM responsable WHERE num_resp = ?";
            $deleteResponsableStmt = mysqli_prepare($conn, $deleteResponsableQuery);
            mysqli_stmt_bind_param($deleteResponsableStmt, "i", $num_resp);

            if (mysqli_stmt_execute($deleteResponsableStmt)) {
                echo "<div class='del_message'> Responsable supprimée avec succès.</div>";
            } else {
                echo "<div class='err_message'> Erreur lors de la suppression du responsable : </div>" . mysqli_error($conn);
                mysqli_stmt_close($deleteResponsableStmt);
            }
        }
    }

    $responsablesQuery = "SELECT * FROM responsable";
    $responsablesResult = mysqli_query($conn, $responsablesQuery);

    if (mysqli_num_rows($responsablesResult) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Action</th></tr>";
        while ($responsable = mysqli_fetch_assoc($responsablesResult)) {
            echo "<form method='POST' action=''>";
            echo "<tr>";
            echo "<td>{$responsable['num_resp']}</td>";
            echo "<td><input type='text' name='nom_resp' value='{$responsable['nom_resp']}' required></td>";
            echo "<td><input type='text' name='prenom_resp' value='{$responsable['prenom_resp']}' required></td>";
            echo "<td><input type='hidden' name='num_resp' value='{$responsable['num_resp']}'>";
            echo "<button class=\"bt2\" type=\"submit\" name=\"modifier\">Modifier</button> ";
            echo "<button class=\"bt3\" type=\"submit\" name=\"supprimer\">Supprimer</button></td>";
            echo "</tr>";
            echo "</form>";
        }
        echo "</table>";
    } else {
        echo "<div class='err_message'> Aucun responsable trouvé.</div>";
    }

    mysqli_close($conn);
    ?>
</body>

</html>