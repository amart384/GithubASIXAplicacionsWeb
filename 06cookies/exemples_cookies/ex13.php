<!DOCTYPE html>
<?php
$cookie_nom = "usuari";
$cookie_valor = "Patufet";
setcookie($cookie_nom, $cookie_valor, time() + (86400 * 30), "/"); // 86400 segons = 1 dia
?>
<html>
<body>

<?php
if(!isset($_COOKIE[$cookie_nom])) {
     echo "La Cookie anomenada '" . $cookie_nom . "' no existeix!";
} else {
     echo "Cookie '" . $cookie_nom . "' esta creada!<br>";
     echo "El seu valor es: " . $_COOKIE[$cookie_nom];
}
?>

<p><strong>Nota:</strong> Potser has de recarregar la pàgina per veure la cookie</p>

</body>
</html>
