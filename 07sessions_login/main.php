<?php
session_start();

// Comprova si l'usuari ha iniciat la sessió
if (!isset($_SESSION["username"])) {
    // Redirecció a la pàgina d'inici de sessió si no s'ha iniciat la sessió
    header("Location: login.php");
    exit;
}

//Tanca la sessió de l'usuari.
//Com que un enllaç sempre és un GET ho recollim pel GET
if ((isset($_GET['logout']) && $_GET['logout'] === "true")) {
    //unset($_SESSION["username"]);
    session_unset(); //destrueix totes les variables de sessió
    session_destroy();
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Plana aplicatiu</title>
</head>
<body>    
    <p>Hola, <?php echo htmlspecialchars($_SESSION["username"]); ?>! Has iniciat sessió correctament.</p>
    
    <a href="main.php?logout=true">Sortir</a>
</body>
</html>
