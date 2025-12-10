<?php
//Display errors en mode developer
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$missatge="";

if (isset($_POST['submit-btn-accept'])) {
	if (isset($_POST['accept_cookies']) && isset($_POST['accept_privacy_terms'])) {
		$missatge="S'han acceptat els termes";
	}
	else{
		$missatge= "No S'han acceptat els termes";
	}
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<meta name="author" content="Toni Martinez, copyright (c) Agost, 2024">
	<meta name="description" content="Bústia d'avisos">
	<meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- No cache -->
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">
	
    <title>Bústia d'avisos</title>
 
	<!-- Enllaç a les icones awesome 4 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
	<!-- bootstrap per les caixes d'informació -->
	<!--<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">-->	 
	<link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"/>	 
	<!-- bootstrap -->
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
	<!-- bootstrap icons -->
	<link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">

	<style>

	</style>
</head>
<body>

	<div class="container my-5">
		<div class="row">
            <div class="col-lg-8 col-sm-12 mx-auto">
			<?php
				echo $missatge;
			?>
			</div>	
		</div>
	</div>

   
</body>
</html>
