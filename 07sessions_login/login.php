<?php
session_start();

// Comprova si el formulari s'ha enviat
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = "admin";
    $password = "password123";

    $inputUsername="";
    $inputPassword="";

    // Obtenir el nom d'usuari i la contrasenya enviats
    if (isset($_POST["username"])) 
        $inputUsername = $_POST["username"];

    if (isset($_POST["password"])) 
        $inputPassword = $_POST["password"];

    // Validar credencials
    if ($inputUsername === $username && $inputPassword === $password) {
        // Emmagatzema el nom d'usuari a la sessió i redirigeix ​​a la pàgina principal
        $_SESSION["username"] = $inputUsername;
        header("Location: main.php");
        exit;
    } else {
        $error = "usuari o contrasenya invàlids.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    
	<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">

        <?php echo $error; ?>
    </form>
</body>
</html>
