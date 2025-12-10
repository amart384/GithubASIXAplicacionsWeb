/***************************************************

Copyright © Agost, 2024 Toni Martinez]. Tots els drets reservats.

Aquest programa està protegit per les lleis de drets d'autor i altres drets de propietat intel·lectual. 
Qualsevol ús, còpia, modificació o distribució d'aquest programa sense el consentiment exprés de l'autor 
està estrictament prohibit, excepte en els casos permesos per la llei o per la llicència d'ús.



DESCÀRREC DE RESPONSABILITAT:
Aquest programari es proporciona "tal qual", sense cap tipus de garantia, explícita o implícita, incloent, 
però no limitant-se a, les garanties de comercialització, idoneïtat per a un propòsit particular o no 
infracció. En cap cas, l'autor serà responsable de cap reclamació, dany o altra responsabilitat, ja sigui 
per una acció contractual, un greuge o qualsevol altra raó, que sorgeixi de, fora de o en connexió amb el 
programari o l'ús d'aquest.
****************************************************/

let cameraStream;
let cprt_API_KEY='c89b588b918303304c008b752306789854cd5ee27f307da525620855becb364b';

// Configurar la càmera
function initCamera() {
	const divcamera = document.getElementById("divcamera");
	const camera = document.getElementById("camera");
	const capturedImage = document.getElementById("captured-image");
	const output = document.getElementById("output");
	
	let statusMessage = document.getElementById('status-message');
	statusMessage.textContent = "Obrint la càmera, si us plau esperi...";
	statusMessage.style.display = 'block';
	statusMessage.className = "alert alert-info";

	//acces a qualsevol camera { video: true }
	//camera selfie { facingMode: "user" } 
	//camera posterior { facingMode: "environment" } 			
	navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment",
												width: { min: 640 },
												height: { min: 480 },
												frameRate: { ideal: 25 } }  })
		.then(stream => {
			divcamera.style.display = 'block';
			camera.srcObject = stream;                    
			camera.style.display = 'block';
			capturedImage.style.display = 'none';					
			cameraStream = stream;
			statusMessage.style.display = 'none';
			statusMessage.textContent = '';
			statusMessage.className = "alert alert-light";
			
		})
		.catch(err => {
			console.error('Error al accedir a la càmera: ', err);
			statusMessage.textContent = 'Error al accedir a la càmera. Si us plau, comprova els permissos i torna a carregar la plana';
			statusMessage.className = "alert alert-danger";
			statusMessage.style.display = 'block';
		});
}

// Capturar foto
function captureImage() {
	const statusMessage = document.getElementById('status-message');
	statusMessage.style.display = 'none';
	statusMessage.textContent = '';			
	statusMessage.className = "alert alert-light";
	
	let camera = document.getElementById("camera");
	let canvas = document.createElement("canvas");
	let context = canvas.getContext("2d");
	let capturedImage = document.getElementById("captured-image");

	canvas.width = camera.videoWidth;
	canvas.height = camera.videoHeight;
	context.drawImage(camera, 0, 0, camera.videoWidth, camera.videoHeight);

	/*Imatge original
	// convertim la imatge a png
	capturedImage.src = canvas.toDataURL("image/png");
	*/
	
	/* Per seguretat es redimensiona la imatge */
	let resizedImage = resizeImage(canvas);
	// convertim la imatge a png
	let imageDataUrl = resizedImage.toDataURL("image/png");
	
	capturedImage.src = imageDataUrl;
	capturedImage.style.display = 'block';		
	/* Aturar la transmissió de la càmera per alliberar recursos
	if (cameraStream) {
		//cameraStream.getTracks().forEach(track => track.stop());
	}*/
	
	// Assignar la imatge al camp ocult del formulari
	document.getElementById("image-data").value = imageDataUrl;
	
	MostrarFormulari();
}

function loadImage() {
	const statusMessage = document.getElementById('status-message');
	statusMessage.style.display = 'none';
	statusMessage.textContent = '';
	statusMessage.className = "alert alert-light";			
	
	let input = document.createElement('input');
	let canvas = document.createElement("canvas");
	let context = canvas.getContext("2d");
	let capturedImage = document.getElementById("captured-image");
	
	input.type = 'file';
	input.accept = 'image/*';
	input.onchange = () => {
		const reader = new FileReader();
		reader.onload = () => {
			const img = new Image();
			img.onload = () => {				
					
				canvas.width = img.width;
				canvas.height = img.height;
				context.drawImage(img, 0, 0, canvas.width, canvas.height);
				
				/* Imatge original		
				// convertim la imatge a png
				capturedImage.src = canvas.toDataURL("image/png");
				*/

			    /* Per seguretat es redimensiona la imatge */
				let resizedImage = resizeImage(canvas);
				// convertim la imatge a png
				let imageDataUrl = resizedImage.toDataURL("image/png");
	
				capturedImage.src = imageDataUrl;
				capturedImage.style.display = 'block';
	
				//Assignar la imatge al camp del formulari
				document.getElementById("image-data").value = imageDataUrl;
				
				MostrarFormulari();
			};
			img.src = reader.result;
		};
		reader.readAsDataURL(input.files[0]);
	};
	input.click();
}

function loadImageFromDisk() {			
	
	let input = document.createElement('input');
	let canvas = document.createElement("canvas");
	let context = canvas.getContext("2d");
	let capturedImage = document.getElementById("captured-image");
	
	input.type = 'file';
	input.accept = 'image/*';
	input.onchange = () => {
		const reader = new FileReader();
		reader.onload = () => {
			const img = new Image();
			img.onload = () => {				
					
				canvas.width = img.width;
				canvas.height = img.height;
				context.drawImage(img, 0, 0, canvas.width, canvas.height);
				
				/* Imatge original		
				// convertim la imatge a png
				capturedImage.src = canvas.toDataURL("image/png");
				*/

			    /* Per seguretat es redimensiona la imatge */
				let resizedImage = resizeImage(canvas);
				// convertim la imatge a png
				let imageDataUrl = resizedImage.toDataURL("image/png");
	
				capturedImage.src = imageDataUrl;
				capturedImage.style.display = 'block';
	
				//Assignar la imatge al camp del formulari
				document.getElementById("image-data").value = imageDataUrl;
				
				let divimagecarregada = document.getElementById("divimagecarregada");
				divimagecarregada.classList.add("d-flex"); //d-block d-inline
				divimagecarregada.classList.remove("d-none");
				
				let divcarregaimages = document.getElementById("divcarregaimages");
				divcarregaimages.classList.add("d-none");
				divcarregaimages.classList.remove("d-flex");
				
			};
			img.src = reader.result;
		};
		reader.readAsDataURL(input.files[0]);
	};
	input.click();
}

function resizeImage(canvas) {
	const maxDimension = 1024;
	let width = canvas.width;
	let height = canvas.height;

	// Calcular el factor de escala si la imagen excede el tamaño máximo
	if (width > maxDimension || height > maxDimension) {
		const scaleFactor = maxDimension / Math.max(width, height);
		width = Math.round(width * scaleFactor);
		height = Math.round(height * scaleFactor);
	}

	// Crear un nuevo canvas con las dimensiones ajustadas
	const resizedCanvas = document.createElement("canvas");
	resizedCanvas.width = width;
	resizedCanvas.height = height;
	const context = resizedCanvas.getContext("2d");

	// Dibujar la imagen ajustada en el nuevo canvas
	context.drawImage(canvas, 0, 0, width, height);

	return resizedCanvas;
}

	
function deleteLoadedImage() {
	try{		
		let divimagecarregada = document.getElementById("divimagecarregada");
		divimagecarregada.classList.add("d-none");
		divimagecarregada.classList.remove("d-flex");		
		
		let divcarregaimages = document.getElementById("divcarregaimages");
		divcarregaimages.classList.add("d-flex");
		divcarregaimages.classList.remove("d-none");
		
		document.getElementById("image-data").value = '';
	} catch (error) {
		console.error(error);
	}
}

function deleteCapturedImage() {
	ShowCaptureImageButtons();
}


function ShowCaptureImageButtons() {
	const statusMessage = document.getElementById('status-message');
	statusMessage.style.display = 'none';
	statusMessage.textContent = '';			
	statusMessage.className = "alert alert-light";
	
	//Mostro el video			
	let divcamera = document.getElementById("divcamera");
	divcamera.style.display = 'block';	
	
	let divimages = document.getElementById("divimages");
	divimages.style.display = 'none';
	
	//Amago la imatge capturada
	//let capturedImage = document.getElementById("captured-image");
	//capturedImage.style.display = 'hidden';
	
	//mostro els botons de captura
	//let captureimage = document.getElementById("divbuttonscaptureimage");
	//captureimage.style.display = 'flex';
	
	//Amago els boto de tornar a capturar
	//let captureimageagain = document.getElementById("divbuttonscaptureimage-again");
	//captureimageagain.style.display = 'hidden';
	
	//Pujo al principi de la plana
	GoToTopPage();
}

function HideCaptureImageButtons() {
	
	//Amago el video
	let divinput = document.getElementById("divcamera");
	divinput.style.display = 'none';
	
	let divimages = document.getElementById("divimages");
	divimages.style.display = 'block';	
	
	//mostro la imatge capturada
	//let capturedImage = document.getElementById("captured-image");
	//capturedImage.style.display = 'block';
	
	//let divcaptureimage = document.getElementById("divbuttonscaptureimage");
	//divcaptureimage.style.display = 'hidden';
	
	//let divcaptureimageagain = document.getElementById("divbuttonscaptureimage-again");
	//divcaptureimageagain.style.display = 'flex';
}

function MostrarFormulari() {
	
	HideCaptureImageButtons();
	
	let divform = document.getElementById("divform");
	divform.style.display = 'block';
	
	GoToBottomPage();
}

function GoToBottomPage() {
  //Funció que s'executa al cap de 600ms
  setTimeout(function() {
	  
	//jQuery
	//Ens desplacem fins al formulari amb una animació de 500ms	
	var movetoelement = $('#captured-image');
	$('html, body').animate({
		scrollTop: movetoelement.offset().top
	}, 500);
	
  }, 600); // Esperar x ms antes de desplazar
}

function GoToTopPage() {
	window.scrollTo(0, 0);
}		

/*
// Reiniciar càmera en fer clic al botó de captura
document.getElementById("capture-button").addEventListener("click", () => {
	if (document.getElementById("camera").style.display === "none") {
		initCamera();
	}
});*/

function reiniciarCamara() {
	// Aturar el stream actual si existeix
	if (cameraStream) {
		cameraStream.getTracks().forEach(track => track.stop());
	}
}

function EnableSubmitForm() {
	document.getElementById('submitForm').removeAttribute('disabled');
}
