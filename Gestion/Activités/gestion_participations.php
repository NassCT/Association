<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des participations</title>
    <link rel="stylesheet" href="../../CSS/styles.css">
</head>

<body>

    <a href="../../dashboard.php" class="button">Retour</a>

    <h1 class="Title">Liste des participations</h1>
    <?php
    include('../../include/connexion.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscrire'])) {
        // Code d'inscription ici
    }

    $participationsQuery = "SELECT pa.id_part, p.num_participant, p.nom_participant, p.prenom_participant, p.mail_participant, 
                        a.nom_act, a.site, r.nom_resp, r.prenom_resp, c.heure_debut, c.heure_fin 
                        FROM participation pa
                        JOIN activite a ON pa.id_act = a.id_act
                        JOIN responsable r ON a.num_resp = r.num_resp
                        JOIN creneau c ON pa.id_creneau = c.id_creneau
                        JOIN participant p ON pa.num_participant = p.num_participant";
    $participationsResult = mysqli_query($conn, $participationsQuery);

    if (mysqli_num_rows($participationsResult) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Nom Participant</th><th>Prénom Participant</th><th>Email Participant</th><th>Nom de l'activité</th><th>Site</th><th>Nom du Responsable</th><th>Créneau</th><th>Action</th></tr>";
        while ($participation = mysqli_fetch_assoc($participationsResult)) {
            echo "<tr>";
            echo "<td>{$participation['nom_participant']}</td>";
            echo "<td>{$participation['prenom_participant']}</td>";
            echo "<td>{$participation['mail_participant']}</td>";
            echo "<td>{$participation['nom_act']}</td>";
            echo "<td>{$participation['site']}</td>";
            echo "<td>{$participation['nom_resp']} {$participation['prenom_resp']}</td>";
            echo "<td>{$participation['heure_debut']} - {$participation['heure_fin']}</td>";
            echo "<td><form method='POST' action=''><input type='hidden' name='id_participation' value='{$participation['id_part']}'>";               
            echo "<button class=\"bt3\" type=\"submit\" name=\"supprimer\">Supprimer</button>";
            echo "</form></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<div class='err_message'>Aucune participation trouvée.</div>";
    }

    // Suppression de la participation
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer'])) {
        $id_participation = $_POST['id_participation'];
        $deleteParticipationQuery = "DELETE FROM participation WHERE id_part = ?";
        $deleteParticipationStmt = mysqli_prepare($conn, $deleteParticipationQuery);
        mysqli_stmt_bind_param($deleteParticipationStmt, "i", $id_participation);

        if (mysqli_stmt_execute($deleteParticipationStmt)) {
            echo "<div class='main_message'>Participation supprimée avec succès.</div>";
        } else {
            echo "<div class='err_message'>Erreur lors de la suppression de la participation : " . mysqli_error($conn) . "</div>";
        }

        mysqli_stmt_close($deleteParticipationStmt);
    }

    mysqli_close($conn);
    ?>
</body>

</html>