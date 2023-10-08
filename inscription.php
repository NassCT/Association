<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription aux activités</title>
    <link rel="stylesheet" href="CSS\styles.css">
</head>

<body>

    <a href="dashboard.php" class="button">Retour</a>

    <h1 class="Title">Inscription à une activité</h1>
    <div class="form">
        <form method="POST" action="">
            <select name="id_act" required>
                <option value="" disabled selected>Choisir une activité</option>
                <?php
                // Connexion à la base de données
                include('include\connexion.php');

                // Récupérer les activités depuis la base de données
                $activitesQuery = "SELECT * FROM activite";
                $activitesResult = mysqli_query($conn, $activitesQuery);

                // Afficher les options du menu déroulant
                while ($activite = mysqli_fetch_assoc($activitesResult)) {
                    echo "<option value='{$activite['id_act']}'>{$activite['nom_act']} - {$activite['site']}</option>";
                }

                // Fermer la connexion à la base de données
                ?>
            </select><br>
            <select name="id_creneau" required>
                <option value="" disabled selected>Choisir un créneau</option>
                <?php
                // Connexion à la base de données (à nouveau car la connexion a été fermée précédemment)

                // Récupérer les créneaux depuis la base de données
                $creneauxQuery = "SELECT * FROM creneau";
                $creneauxResult = mysqli_query($conn, $creneauxQuery);

                // Afficher les options du menu déroulant
                while ($creneau = mysqli_fetch_assoc($creneauxResult)) {
                    echo "<option value='{$creneau['id_creneau']}'>{$creneau['heure_debut']} - {$creneau['heure_fin']}</option>";
                }

                // Fermer la connexion à la base de données
                ?>
            </select><br>
            <input type="text" name="nom_participant" placeholder="Nom" required><br>
            <input type="text" name="prenom_participant" placeholder="Prénom" required><br>
            <input type="email" name="mail_participant" placeholder="Email" required><br>
            <button type="submit" name="inscrire">S'inscrire</button>
        </form>
    </div>

    <?php
    // Traitement du formulaire d'inscription
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscrire'])) {

        // Récupérer les données du formulaire
        $id_act = $_POST['id_act'];
        $id_creneau = $_POST['id_creneau'];
        $nom_participant = $_POST['nom_participant'];
        $prenom_participant = $_POST['prenom_participant'];
        $mail_participant = $_POST['mail_participant'];

        // Insérer les données dans la table participant
        $insertParticipantQuery = "INSERT INTO participant (nom_participant, prenom_participant, mail_participant) VALUES (?, ?, ?)";
        $insertParticipantStmt = mysqli_prepare($conn, $insertParticipantQuery);
        mysqli_stmt_bind_param($insertParticipantStmt, "sss", $nom_participant, $prenom_participant, $mail_participant);

        // Exécuter la requête d'insertion
        if (mysqli_stmt_execute($insertParticipantStmt)) {
            // Récupérer l'ID du participant nouvellement inscrit
            $num_participant = mysqli_insert_id($conn);

            // Insérer les données dans la table participation
            $insertParticipationQuery = "INSERT INTO participation (id_act, id_creneau, num_participant) VALUES (?, ?, ?)";
            $insertParticipationStmt = mysqli_prepare($conn, $insertParticipationQuery);
            mysqli_stmt_bind_param($insertParticipationStmt, "iii", $id_act, $id_creneau, $num_participant);

            // Exécuter la requête d'insertion
            if (mysqli_stmt_execute($insertParticipationStmt)) {
                echo "<div class='main_message'>Inscription réussie à l'activité.</div>";
            } else {
                echo "<div class='err_message'>Erreur lors de l'inscription à l'activité : " . mysqli_error($conn) . "</div>";
            }

            mysqli_stmt_close($insertParticipationStmt);
        } else {
            echo "<div class='err_message'>Erreur lors de l'inscription du participant : " . mysqli_error($conn) . "</div>";
        }

        // Fermer la connexion à la base de données
        mysqli_close($conn);
    }
    ?>

</body>

</html>
