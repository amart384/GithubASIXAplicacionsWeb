<!DOCTYPE html>
<?php
$cookie_nom = "comptador";
if(!isset($_COOKIE[$cookie_nom])) {
     $cookie_valor = 1;
	 $missatge="Benvingut a la meva web!!";
} else {
	 $cookie_valor=$_COOKIE[$cookie_nom]+1; 
	 $missatge="Ens has visitat ".$cookie_valor." vegades.";
}
setcookie($cookie_nom, $cookie_valor, time() + (86400 * 30), "/"); // 86400 segons = 1 dia
?>
<html>
<body>
<h1> <?= $missatge ?> </h1>
</body>
</html>
