<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des participants</title>
    <link rel="stylesheet" href="..\..\CSS\styles.css">
</head>

<body>

    <a href="..\..\dashboard.php" class="button">Retour</a>

    <h1 class="Title">Ajouter un nouveau participant</h1>
    <div class="form">
        <form method="POST" action="">
            <input type="text" name="nom_participant" placeholder="Nom du participant" required><br>
            <input type="text" name="prenom_participant" placeholder="Prénom du participant" required><br>
            <input type="email" name="mail_participant" placeholder="Email du participant" required><br>
            <button type="submit" name="ajouter">Ajouter</button>
        </form>
    </div>

    <h1 class="Title">Liste des participants</h1>

    <?php
    include('..\..\include\connexion.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nom_participant = $_POST['nom_participant'];
        $prenom_participant = $_POST['prenom_participant'];

        if (isset($_POST['ajouter'])) {
            $mail_participant = $_POST['mail_participant'];
            // Ajouter un participant

            $insertparticipantQuery = "INSERT INTO participant (nom_participant, prenom_participant, mail_participant) VALUES (?, ?, ?)";
            $insertparticipantStmt = mysqli_prepare($conn, $insertparticipantQuery);
            mysqli_stmt_bind_param($insertparticipantStmt, "sss", $nom_participant, $prenom_participant, $mail_participant);

            if (mysqli_stmt_execute($insertparticipantStmt)) {
                echo "<div class='main_message'> participant ajouté avec succès.</div>";
            } else {
                echo "<div class='err_message'> Erreur lors de l'ajout du participant : </div>" . mysqli_error($conn);
            }

            mysqli_stmt_close($insertparticipantStmt);
        } elseif (isset($_POST['modifier'])) {

            $num_participant = $_POST['num_participant'];
            $mail_participant = $_POST['mail_participant'];

            // Modifier le participant
            $updateparticipantQuery = "UPDATE participant SET nom_participant = ?, prenom_participant = ?, mail_participant = ?  WHERE num_participant = ?";
            $updateparticipantStmt = mysqli_prepare($conn, $updateparticipantQuery);
            mysqli_stmt_bind_param($updateparticipantStmt, "sssi", $nom_participant, $prenom_participant, $mail_participant, $num_participant);

            if (mysqli_stmt_execute($updateparticipantStmt)) {
                echo "<div class='edit_message'> participant modifiée avec succès.</div>";
            } else {
                echo "<div class='err_message'> Erreur lors de la modification du participant : </div>" . mysqli_error($conn);
                mysqli_stmt_close($updateparticipantStmt);
            }
        } elseif (isset($_POST['supprimer'])) {

            $num_participant = $_POST['num_participant'];

            // Supprimer le participant
            $deleteparticipantQuery = "DELETE FROM participant WHERE num_participant = ?";
            $deleteparticipantStmt = mysqli_prepare($conn, $deleteparticipantQuery);
            mysqli_stmt_bind_param($deleteparticipantStmt, "i", $num_participant);

            if (mysqli_stmt_execute($deleteparticipantStmt)) {
                echo "<div class='del_message'> participant supprimée avec succès.</div>";
            } else {
                echo "<div class='err_message'> Erreur lors de la suppression du participant : </div>" . mysqli_error($conn);
                mysqli_stmt_close($deleteparticipantStmt);
            }
        }
    }

    $participantsQuery = "SELECT * FROM participant";
    $participantsResult = mysqli_query($conn, $participantsQuery);

    if (mysqli_num_rows($participantsResult) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Action</th></tr>";
        while ($participant = mysqli_fetch_assoc($participantsResult)) {
            echo "<form method='POST' action=''>";
            echo "<tr>";
            echo "<td>{$participant['num_participant']}</td>";
            echo "<td><input type='text' name='nom_participant' value='{$participant['nom_participant']}' required></td>";
            echo "<td><input type='text' name='prenom_participant' value='{$participant['prenom_participant']}' required></td>";
            echo "<td><input type='text' name='mail_participant' value='{$participant['mail_participant']}' required></td>";
            echo "<td><input type='hidden' name='num_participant' value='{$participant['num_participant']}'>";
            echo "<button class=\"bt2\" type=\"submit\" name=\"modifier\">Modifier</button> ";
            echo "<button class=\"bt3\" type=\"submit\" name=\"supprimer\">Supprimer</button></td>";
            echo "</tr>";
            echo "</form>";
        }
        echo "</table>";
    } else {
        echo "<div class='err_message'> Aucun participant trouvé.</div>";
    }

    mysqli_close($conn);
    ?>
</body>

</html>