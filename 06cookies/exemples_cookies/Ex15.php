<!DOCTYPE html>
<?php
// set the expiration date to one hour ago
setcookie("usuari", "", time() - 3600, "/");
setcookie("comptador", "", time() - 3600, "/");
?>
<html>
<body>

<?php
echo "Cookie 'usuari' is deleted.";
echo "Cookie 'comptador' is deleted.";
echo time();
?>

</body>
</html>
