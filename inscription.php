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
                include('include\connexion.php');

                $activitesQuery = "SELECT a.id_act, a.nom_act, a.site, r.nom_resp, r.prenom_resp FROM activite a
                JOIN responsable r ON a.num_resp = r.num_resp";
                $activitesResult = mysqli_query($conn, $activitesQuery);

                while ($activite = mysqli_fetch_assoc($activitesResult)) {
                    echo "<option value='{$activite['id_act']}'>{$activite['nom_act']} - {$activite['site']} - {$activite['nom_resp']} {$activite['prenom_resp']}</option>";
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

</body>

</html>
