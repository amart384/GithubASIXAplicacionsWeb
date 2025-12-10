<?php


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
