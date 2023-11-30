<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription aux activités</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>

    <a href="dashboard.php" class="button">Retour</a>

    <h1 class="Title">Inscription à une activité</h1>
    <div class="form">
        <form method="POST" action="">
            <select name="id_act" required>
                <option value="" disabled selected>Choisir une activité</option>
                <?php
                include('include/connexion.php');

                $activitesQuery = "SELECT * FROM activite";
                $activitesResult = mysqli_query($conn, $activitesQuery);

                // Options menu déroulant
                while ($activite = mysqli_fetch_assoc($activitesResult)) {
                    echo "<option value='{$activite['id_act']}'>{$activite['nom_act']} - {$activite['site']}</option>";
                }

                ?>
            </select><br>
            <select name="id_creneau" required>
                <option value="" disabled selected>Choisir un créneau</option>
                <?php

                $creneauxQuery = "SELECT * FROM creneau";
                $creneauxResult = mysqli_query($conn, $creneauxQuery);

                while ($creneau = mysqli_fetch_assoc($creneauxResult)) {
                    echo "<option value='{$creneau['id_creneau']}'>{$creneau['heure_debut']} - {$creneau['heure_fin']}</option>";
                }
                ?>
            </select><br>
            <input type="text" name="nom_participant" placeholder="Nom" required><br>
            <input type="text" name="prenom_participant" placeholder="Prénom" required><br>
            <input type="email" name="mail_participant" placeholder="Email" required><br>
            <button type="submit" name="inscrire">S'inscrire</button>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inscrire'])) {

        $id_act = $_POST['id_act'];
        $id_creneau = $_POST['id_creneau'];
        $nom_participant = $_POST['nom_participant'];
        $prenom_participant = $_POST['prenom_participant'];
        $mail_participant = $_POST['mail_participant'];

        $insertParticipantQuery = "INSERT INTO participant (nom_participant, prenom_participant, mail_participant) VALUES (?, ?, ?)";
        $insertParticipantStmt = mysqli_prepare($conn, $insertParticipantQuery);
        mysqli_stmt_bind_param($insertParticipantStmt, "sss", $nom_participant, $prenom_participant, $mail_participant);

        if (mysqli_stmt_execute($insertParticipantStmt)) {

            // Récupérer l'ID
            $num_participant = mysqli_insert_id($conn);

            $insertParticipationQuery = "INSERT INTO participation (id_act, id_creneau, num_participant) VALUES (?, ?, ?)";
            $insertParticipationStmt = mysqli_prepare($conn, $insertParticipationQuery);
            mysqli_stmt_bind_param($insertParticipationStmt, "iii", $id_act, $id_creneau, $num_participant);

            // Executer la requete
            if (mysqli_stmt_execute($insertParticipationStmt)) {
                echo "<div class='main_message'>Inscription réussie à l'activité.</div>";
            } else {
                echo "<div class='err_message'>Erreur lors de l'inscription à l'activité : " . mysqli_error($conn) . "</div>";
            }

            mysqli_stmt_close($insertParticipationStmt);
        } else {
            echo "<div class='err_message'>Erreur lors de l'inscription du participant : " . mysqli_error($conn) . "</div>";
        }

        // Fermer la connexion
        mysqli_close($conn);
    }
    ?>

</body>

</html>