<!DOCTYPE html>
<?php
$cookie_nom = "usuari";
$cookie_valor = "Massagran";
setcookie($cookie_nom, $cookie_valor, time() + (86400 * 30), "/");
?>
<html>
<body>

<?php
if(!isset($_COOKIE[$cookie_nom])) {
     echo "Cookie named '" . $cookie_nom . "' is not set!";
} else {
     echo "Cookie '" . $cookie_nom . "' is set!<br>";
     echo "Value is: " . $_COOKIE[$cookie_nom];
}
?>

<p><strong>Note:</strong> You might have to reload the page to see the new value of the cookie.</p>

</body>
</html>
