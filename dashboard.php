<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>
    <!-- NavBar -->
    <aside>
        <!-- Menu -->
        <p>Menu</p>
        <a href="dashboard.php" class="nav-link current-page">
            <object type="image/svg+xml" data="assets/img/icone/house.svg" class="navbar-icon"></object>
            <span>Tableau de bord</span>
        </a>
        <a href="Gestion/Utilisateurs/gestion_utilisateurs.php" class="nav-link ">
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
</body>



<div class="container">
    <h1 class="Title">Bienvenue dans la page d'administration</h1>
    <p>Choisissez une option :</p>
    <a href="Gestion/Utilisateurs/gestion_utilisateurs.php" class="button">Gérer les Utilisateurs</a>
    <a href="Gestion/Utilisateurs/gestion_responsables.php" class="button">Gérer les responsables</a>
    <a href="Gestion/Activités/gestion_activites.php" class="button">Gérer les activités</a>
    <a href="Gestion/Activités/gestion_creneaux.php" class="button">Gérer les créneaux</a>
    <a href="Gestion/Utilisateurs/gestion_participants.php" class="button">Gérer les participants</a>
    <a href="Gestion/Activités/gestion_participations.php" class="button">Gérer les participations</a><br><br>
    <a href="inscription.php" class="button">Inscrire un utilisateur</a>
    <a href="index.php" class="button2">Changer de session</a>
    <a href="include/logout.php" class="button3">Déconnexion</a>
</div>


</html>