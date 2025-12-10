<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // Iniciar la sesió

$error_message="";
$inforegistrehtml='';
$camps_validats = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$tipuslocalitzacio='gps'; 
	//el reguest recull segons el name, no per el id (el id es per els estils o JavaScript)
	$tipuslocalitzacio=null;  //es recull segons el camp name
	if (isset($_REQUEST['tipuslocalitzacio']) && !empty($_REQUEST['tipuslocalitzacio'])) {
		$tipuslocalitzacio = sanejar_camp($_REQUEST['tipuslocalitzacio']);
	}

	$adrecaavis=null;
	if (isset($_REQUEST['adrecaavis']) && !empty($_REQUEST['adrecaavis'])) {	
		$adrecaavis = sanejar_camp($_REQUEST['adrecaavis']);	
	}
		
	$descripcio=null;
	if (isset($_REQUEST['descripcio']) && !empty($_REQUEST['descripcio'])) {
		$descripcio = sanejar_camp($_REQUEST['descripcio']);
	}
	
	$respostaavis="no";
	if (isset($_REQUEST['respostaavis']) && !empty($_REQUEST['respostaavis'])) {
		if (strcmp($_REQUEST['respostaavis'],"SI")==0) $respostaavis = "si";
	}	
	
	//Dades de contacte
	////////////////////////////////////////////////////////////
	$givenname=null;
	if (isset($_REQUEST['given-name']) && !empty($_REQUEST['given-name'])) {
		$givenname = sanejar_camp($_REQUEST['given-name']);			
		if (strlen($givenname) < 2) {
			$camps_validats = false;
			$error_message .= "<br/>El camp givenname ha de tenir almenys 2 caràcters.";
		}
	}
	
	$familyname=null;
	if (isset($_REQUEST['family-name']) && !empty($_REQUEST['family-name'])) {
		$familyname = sanejar_camp($_REQUEST['family-name']);	
		if (strlen($familyname) < 2) {
			$camps_validats = false;
			$error_message .= "<br/>El camp familyname ha de tenir almenys 2 caràcters.";
		}	
	}	
	
	$tel=null;
	if (isset($_REQUEST['tel']) && !empty($_REQUEST['tel'])) {
		$tel = sanejar_camp($_REQUEST['tel']);	
		
		// Comprovar Telèfon conté només dígits
		if (!ctype_digit($tel)) {
			$camps_validats = false;
			$error_message .= "<br/>El telèfon només pot contenir números.";
		}
	}
	
	$email="";
	if (isset($_REQUEST['email']) && !empty($_REQUEST['email'])) {
		$email = sanejar_camp($_REQUEST['email']);		

		// Comprovar que l'adreça de correu contingui '@'
		if (strpos($email, '@') === false) {
			$camps_validats = false;
			$error_message .= "<br/>L'adreça de correu ha de contenir el caràcter @.";
		}
	}

	$emailc="";
	if (isset($_REQUEST['emailc']) && !empty($_REQUEST['emailc'])) {
		$emailc = sanejar_camp($_REQUEST['emailc']);		
		// Comprovar que l'adreça de correu contingui '@'
		if (strpos($emailc, '@') === false) {
			$camps_validats = false;
			$error_message .= "<br/>L'adreça de correu ha de contenir el caràcter @.";
		}
	}

	//comprovem que tenim els camps obligatoris (NOT NULL)
	// opcional && ($tel!=null) 
	if (($camps_validats==true)&&($adrecaavis!=null) && ($respostaavis!=null) && 
	    ($givenname!=null) && ($familyname!=null) && ($email!=null)){							
		
		$inforegistrehtml.="<br/><b>Nom i Cognoms:</b> ".$givenname." ".$familyname;
		$inforegistrehtml.="<br/><b>correu:</b> ".$email;
		if (isset($tel)) $inforegistrehtml.="<br/><b>Telf:</b> ".$tel;

		if (isset($descripcio)) $inforegistrehtml.="<br/><b>Descripció:</b> ".$descripcio;
		$inforegistrehtml.="<br/><br/><b>Adreça de l'avís:</b> ".$adrecaavis;
		$inforegistrehtml.="<br/><b>Tipus localització:</b> ".$tipuslocalitzacio;		
		$inforegistrehtml.="<br/><br/><b>Vol rebre un seguiment:</b> ".$respostaavis;

	}else{
		$error_message .= '<br/><div class="alert alert-danger d-flex align-items-center" role="alert">'.'<i class="bi bi-envelope-x mx-4 fs-1"></i>'.'<br/>Dades de formulari incorrectes</div>';
	}
}
else {
	$error_message = "\n<br/>Mètode no permès.";
}

function sanejar_camp($camp){
	$resultat = null;
	//htmlspecialchars(): Convierte caracteres especiales (<, >, ", ', &) en entidades HTML, evitando inyecciones de código HTML y JavaScript (XSS).
	$resultat = htmlspecialchars($camp, ENT_QUOTES, 'UTF-8'); // Convierte caracteres especiales a HTML, previniendo inyección XSS
	
	//convierte todos los caracteres especiales en una cadena a sus correspondientes entidades HTML
	$resultat=htmlentities($resultat, ENT_QUOTES, 'UTF-8');
	
	return $resultat;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<meta name="author" content="Toni Martinez, copyright 2024">
	<meta name="description" content="Bústia d'avisos">
	<meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bústia d'avisos - Girona </title>
 
	<!-- Enllaç a les icones awesome 4 -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">	
	<!-- bootstrap per les caixes d'informació 
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">	-->
	<!-- bootstrap -->
	<link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet"/>	 
	<!-- bootstrap -->
    <script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
	<!-- bootstrap icons -->
	<link rel="stylesheet" href="bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">

	<link rel="stylesheet" href="css/bastyle.css">
	
	 <style>

    </style>
</head>

<body>

<div class="container my-5">
	  <div class="row">
            <div class="col-lg-8 col-sm-12 mx-auto">
					<h4 class="titolprincipal"><i class="bi bi-mailbox-flag mx-2 fs-1"></i> Bústia d'avisos</h4>
					<div class="card">
						<div class="card-header bg-primary text-white text-center">
							<h3>Processament de l'avís</h3>
						</div>
						<div class="card-body">
							<h6><?php echo $inforegistrehtml;?></h6>
							<h6><?php echo $error_message;?></h6>
							<h4>Gràcies per utilizar aquest servei.</h4>
								
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-md-1 col-sm-0"> </div>																	
									<div class="col-md-5 col-sm-12 d-grid text-center mb-3">  
										<form action="https://web.girona.cat" method="get">
									
										<button type="submit" class="btn btn-lg btn-success" name="submit-btn-sortir">Sortir <i class="bi bi-box-arrow-right mx-2 fs-3"></i></button>
										</form>
									</div>
								
									
								<div class="col-md-1 col-sm-0"> </div>                           
							</div>
						</div>		
					</div>				
			</div>
		</div>		
	</div>
</body>
</html>
