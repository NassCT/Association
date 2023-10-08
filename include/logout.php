<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\CSS\styles.css">
    <title>Déconnexion</title>
</head>
<body>
    
</body>
</html>


<?php
session_start();
session_destroy();
header('Refresh: 3; URL=..\index.php');
echo "<div class='main_message'>Redirection dans 3 secondes...</div>";
exit;
?>
