<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <script>
    console.log("Rôle de l'utilisateur : <?php echo $_SESSION['role']; ?>");
    </script>
</head>

<?php
session_start();
include('include/connexion.php');
$_SESSION['role'] = 'administrations';

// Get the number of users
$user_query = "SELECT COUNT(*) FROM utilisateurs";
$user_result = mysqli_query($conn, $user_query);
$user_count = 0;
if ($user_result) {
    $row = mysqli_fetch_row($user_result);
    $user_count = $row[0];
}
// Get the number of activities
$activity_query = "SELECT COUNT(*) FROM activite";
$activity_result = mysqli_query($conn, $activity_query);
$activity_count = 0;
if ($activity_result) {
    $row = mysqli_fetch_row($activity_result);
    $activity_count = $row[0];
}
// Get the number of participants
$participant_query = "SELECT COUNT(*) FROM participant";
$participant_result = mysqli_query($conn, $participant_query);
$participant_count = 0;
if ($participant_result) {
    $row = mysqli_fetch_row($participant_result);
    $participant_count = $row[0];
}
mysqli_close($conn);
?>

<body>
    <div class="container">
        <!-- NavBar -->
        <aside>
            <!-- Menu -->
            <p>Menu</p>

            <a href="dashboard.php" class="nav-link current-page">
                <object type="image/svg+xml" data="/Association/assets/img/icone/house.svg" class="navbar-icon"></object>
                <span>Tableau de bord</span>
            </a>
            <a href="/Association/Gestion/Utilisateurs/gestion_utilisateurs.php" class="nav-link ">
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
            <a href="/Association/Gestion/Activités/gestion_creneaux.php" class="nav-link">
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
            <a href="inscription.php" class="nav-link">
                <object type="image/svg+xml" data="/Association/assets/img/icone/house.svg" class="navbar-icon"></object>
                <span>Gestion des participations</span>
            </a>
            <?php
            // Check if the "role" key is set in the $_SESSION array
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'administrations') {
                ?>
                <a href="/Association/include/logout.php" class="nav-link">
                    <object type="image/svg+xml" data="/Association/assets/img/icone/logout.svg"
                        class="navbar-icon logout"></object>
                    <span>Déconnexion</span>
                </a>
            <?php
            }
            ?>
        </aside>



        <div class="statistical">
            <!-- tl-commande -->
            <div class="tl-commande">
                <img src="assets/img/icone/users.svg" alt="Icone Stats">
                <!-- middle -->
                <div class="middle">
                    <div class="left">
                        <h3>Total des utilisateurs</h3>
                        <h1><?php echo $user_count ?></h1>
                    </div>

                </div>
            </div>

        </div>

</body>

</html>

<!-- <p>Nombre d'utilisateurs: <?php echo $user_count; ?></p>
<p>Nombre d'activités: <?php echo $activity_count; ?></p>
<p>Nombre de participants: <?php echo $participant_count; ?></p>-->

