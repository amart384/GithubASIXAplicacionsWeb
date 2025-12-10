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
let clickListener; // Variable para guardar el listener de clic
let map;
let marker=null;

let geocoder;
let addressField;
let cprt_API_KEY2='c89b588b918303304c008b752306789854cd5ee27f307da525620855becb364b';
let infoWindow = null;	  

//Geolocalització per GPS
function getLocation(tipus) {	
	if (tipus === 'gps') {	
		UpdateMapGPS();
		disableClickOnMap();
	} else if (tipus === 'marcador') {
		document.getElementById("latitud").value = 0;
		document.getElementById("longitud").value = 0;
		enableClickOnMap();		
	}
			
}

// Carregar el mapa de manera asíncrona
function loadGoogleMapsAPI() {
  const script = document.createElement('script');
  script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyA7rVxRBhaRB3JhEE7_9DM_06bjMR0J7C0&loading=async&callback=initMap&v=weekly&libraries=marker`; // Canvia 'API_KEY' amb la teva clau de Google
  script.defer = true;
  script.async = true;
  document.head.appendChild(script);
}

// Inicialitzar el mapa
function initMap() {
	
	geocoder = new google.maps.Geocoder(); // Crear el servei de geocodificació
	addressField = document.getElementById('adrecaavis'); // Referencia al camp de text
	addressField.value = '';
	
	//Per defecte es a Girona
	var userLocation = {
		lat: 41.9855802,
		lng: 2.8210475
	};

	// Crear el mapa centrat en l'ubicació predefinida
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 14,
		center: userLocation,
		mapId: "DEMO_MAP_ID", // Map ID is required for advanced markers.
		mapTypeControl: false, // Amaga l'opció de satèlit
		streetViewControl: false, // Amaga l'icona de Street View
		fullscreenControl: false, // (Opcional) Amaga el botó de pantalla complerta
		styles: [
						{
							featureType: "poi.business",
							stylers: [{ visibility: "off" }]
						},
						{
							featureType: "transit",
							stylers: [{ visibility: "off" }]
						}
					]
	});
		
		/*
	// Crear un marcador a la ubicació actual de l'usuari
	marker = new google.maps.marker.AdvancedMarkerElement({
		position: userLocation,
		map: map,
		draggable: true, // Per permetre que l'usuari mogui el marcador manualment.
		title: 'avis',
	});*/

	// Habilitar l'event de clic inicialment
	enableClickOnMap();
	mostrarAvisosActuals();
}

// Actualitzar el mapa
function UpdateMapGPS() {
	
  console.log('UpdateMapGPS');
  // Intentar obtenir la ubicació de l'usuari
  if (navigator.geolocation) {
	console.log('pas1');
	navigator.geolocation.getCurrentPosition(function(position) {
	  console.log('pas2');
	  const clickedLocation = {
		lat: position.coords.latitude,
		lng: position.coords.longitude
	  };

	  	console.log('pas3');

		// Crear el mapa centrat en la ubicació
		/*map = new google.maps.Map(document.getElementById('map'), {
			zoom: 14,
			center: clickedLocation,
			mapId: "DEMO_MAP_ID", // Map ID is required for advanced markers.
			mapTypeControl: false, // Amaga l'opció de satèli
			streetViewControl: false, // Amaga l'icona de Street View
			fullscreenControl: false // (Opcional) OAmaga el botó de pantalla complerta
		
		});*/
			/*styles: [
						{
							featureType: "poi.business",
							stylers: [{ visibility: "off" }]
						},
						{
							featureType: "transit",
							stylers: [{ visibility: "off" }]
						}
					]*/		

		centerMap(clickedLocation.lat, clickedLocation.lng);
		console.log('pas4');

		// Crear un marcador en la ubicación actual del usuario
		if (marker == null){
			marker = new google.maps.marker.AdvancedMarkerElement({
				position: clickedLocation,
				map: map,
				draggable: true, // Per permetre que lusuari mogui el marcador manualment.
				title: 'avis'
			});			
		}
		
		console.log('pas5');
		console.log('longitud: '+ clickedLocation.lng);
		console.log('latitud: '+ clickedLocation.lat);

		// Moure el marcador a la nova ubicació
		marker.position = clickedLocation;				
		
		// Geocodificar la ubicació inicial i mostrar-la al camp de text
		geocodeLatLng(geocoder, clickedLocation, addressField);
				
	}, function() {
	  console.error('Error al obtenir la localització');
	  alert('Error al obtenir la localització.');
	},showGPSError);
  } else {
	console.error('El navegador no suporta localització.');
	alert('El navegador no suporta localització.');
  }
}

function centerMap(lat, lng) {
    const newLocation = new google.maps.LatLng(lat, lng);
    map.setCenter(newLocation);
	map.setZoom(17);
}

// Funció per habilitar l'esdeveniment de clic al mapa
function enableClickOnMap() {
	clickListener = map.addListener('click', function(event) {
		const clickedLocation = {
		  lat: event.latLng.lat(),
		  lng: event.latLng.lng()
		};		
		
		
		// Crear un marcador en la ubicación actual del usuario
		if (marker == null){
				marker = new google.maps.marker.AdvancedMarkerElement({
				position: clickedLocation,
				map: map,
				draggable: true, // Per permetre que lusuari mogui el marcador manualment.
				title: 'avis'
			});
		}		
		
		// Moure el marcador a la nova ubicació
		marker.position = clickedLocation;
		
		// Passa de coordenades GPS a text
		geocodeLatLng(geocoder, clickedLocation, addressField);
		
		document.getElementById('localitzaciomapa').checked = true;
	});
}

// Funció per deshabilitar l'esdeveniment de clic al mapa
function disableClickOnMap() {
	if (clickListener) {
		google.maps.event.removeListener(clickListener);
		clickListener = null; // Limpiar la variable
	}
}

function showGPSPosition(position) {
	document.getElementById("latitud").value = position.coords.latitude;
	document.getElementById("longitud").value = position.coords.longitude;
}

function showGPSError(error) {
	switch(error.code) {
		case error.PERMISSION_DENIED:
			alert("L'usuari ha denegat la sol·licitud de geolocalització.");
			break;
		case error.POSITION_UNAVAILABLE:
			alert("La informació d'ubicació no està disponible.");
			break;
		case error.TIMEOUT:
			alert("La sol·licitud d'ubicació s'ha expirat.");
			break;
		case error.UNKNOWN_ERROR:
			alert("Error desconegut");
			break;
	}
}

// Funció per geocodificar latitud/longitud en direcció i mostrar al camp de text
function geocodeLatLng(geocoder, location, addressField) {
  geocoder.geocode({ location: location }, function(results, status) {

	if (status === 'OK') {

	  if (results[0]) {
	
		addressField.value = results[0].formatted_address; // Establir l'adreça al camp de text
		
		//alert('lat'+location.lat+'    long'+location.lng);
		document.getElementById("latitud").value = location.lat;
		document.getElementById("longitud").value = location.lng;
	
	  } else {
		addressField.value = 'No s\'ha trobat l\'adreça';
	  }
	} else {
	  addressField.value = 'Error al obtenir l\'adreça: ' + status;
	}
  });
}

function mostrarAvisosActuals(){
	/*const avisosactuals = [
		{ id: 1, estat: "Pendent", descripcio: "Semáforo averiado", data: "2025-02-17", lat: 41.9791101, lng: 2.8082486 },	
		//{ id: 2, estat: "En execució", descripcio: "Bache en la calzada", data: "2025-02-16", lat: 41.9855802, lng: 2.8170475 },
		{ id: 3, estat: "Resolt", descripcio: "Alcantarilla tapada", data: "2025-02-15", lat: 41.9855802, lng: 2.8290475 },
		{ id: 4, estat: "Pendent", descripcio: "Farola apagada", data: "2025-02-14", lat: 41.9787802, lng: 2.8220475},
		{ id: 5, estat: "En execució", descripcio: "Fuga de agua", data: "2025-02-13", lat: 41.9859802, lng: 2.8240475 }
	];*/

	/*const icons = {
		'Obert': "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
		'Obert': "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png",
		'Tancat': "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
	};*/

	const icons = {
		'Tancat': "https://mart.institutmontilivi.cat/avisos/img/red-dot-exlamation.png",
		'Obert': "https://mart.institutmontilivi.cat/avisos/img/yellow-dot-hamer.png",
		'Obert': "https://mart.institutmontilivi.cat/avisos/img/green-dot-tick.png"
	};
	
	
	//https://www.streamlinehq.com/icons/tabler-line/all-icons?search=map&icon=ico_G0Zyq3rPeRpyXuIT
	//https://www.streamlinehq.com/icons/tabler-line/all-icons?search=ENVELOP&icon=ico_zdh6JqiKg9yQWPOS
	
	/*<svg xmlns="http://www.w3.org/2000/svg" viewBox="-0.5 -0.5 24 24" fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" id="Mail-Bolt--Streamline-Tabler"><desc>Mail Bolt Streamline Icon: https://streamlinehq.com</desc><path d="M12.458333333333334 18.208333333333336H4.791666666666667a1.9166666666666667 1.9166666666666667 0 0 1 -1.9166666666666667 -1.9166666666666667V6.708333333333334a1.9166666666666667 1.9166666666666667 0 0 1 1.9166666666666667 -1.9166666666666667h13.416666666666668a1.9166666666666667 1.9166666666666667 0 0 1 1.9166666666666667 1.9166666666666667v5.270833333333334" stroke-width="1"></path><path d="m2.875 6.708333333333334 8.625 5.75 8.625 -5.75" stroke-width="1"></path><path d="m18.208333333333336 15.333333333333334 -1.9166666666666667 2.875h3.8333333333333335l-1.9166666666666667 2.875" stroke-width="1"></path></svg>
	
	'Pendent': {
			path: "M8.625 10.541666666666668a2.875 2.875 0 1 0 5.75 0 2.875 2.875 0 0 0 -5.75 0 M14.379791666666668 18.505416666666665l-1.5247083333333333 1.5237500000000002a1.9166666666666667 1.9166666666666667 0 0 1 -2.709208333333333 0l-4.067166666666667 -4.066208333333334a7.666666666666667 7.666666666666667 0 1 1 13.025666666666668 -4.44475 M18.208333333333336 15.333333333333334v2.875 M18.208333333333336 21.083333333333336v0.009583333333333334",
			fillColor: "red",
			strokeColor: "#CC2222",
			strokeWeight: 3,
			scale: 1.2 // Ajusta el tamaño según necesites
		}
	*/
	/*
	const icons = {
		'Pendent': {
			path: "M8.625 10.541666666666668a2.875 2.875 0 1 0 5.75 0 2.875 2.875 0 0 0 -5.75 0 M14.379791666666668 18.505416666666665l-1.5247083333333333 1.5237500000000002a1.9166666666666667 1.9166666666666667 0 0 1 -2.709208333333333 0l-4.067166666666667 -4.066208333333334a7.666666666666667 7.666666666666667 0 1 1 13.025666666666668 -4.44475 M18.208333333333336 15.333333333333334v2.875 M18.208333333333336 21.083333333333336v0.009583333333333334",
			fillColor: "red",
			strokeColor: "#CC2222",
			strokeWeight: 3,
			scale: 1.2 // Ajusta el tamaño según necesites
		},
		'En execució': {
			path: "M12.458 18.208H4.792a1.917 1.917 0 0 1-1.917-1.917V6.708a1.917 1.917 0 0 1 1.917-1.917h13.417a1.917 1.917 0 0 1 1.916 1.917v9.583a1.917 1.917 0 0 1-1.916 1.917H12.458 M2.875 6.708l8.625 5.75 8.625-5.75 M12 6.5l-1 2h2l-1 2 M12 18.2 L12 30",
			fillColor: "orange",
			strokeColor: "#EEBB22",
			strokeWeight: 3,
			scale: 1.3, // Ajusta el tamaño si es necesario
			anchor: { x: 12, y: 30 } // Ajusta el anclaje para que la punta inferior coincida con el PNG
		},
		'Resolt': {
			path: "M8.625 10.541666666666668a2.875 2.875 0 1 0 5.75 0 2.875 2.875 0 0 0 -5.75 0 M11.375416666666666 20.585a1.909 1.909 0 0 1 -1.2295416666666665 -0.5558333333333333l-4.067166666666667 -4.066208333333334a7.666666666666667 7.666666666666667 0 1 1 12.798541666666667 -3.3292500000000005 M14.375 18.208333333333336l1.9166666666666667 1.9166666666666667 3.8333333333333335 -3.8333333333333335 M12 18.2 L12 30",
			fillColor: "none",
			strokeColor: "#22AA22",
			strokeWeight: 3,
			scale: 1.2 // Ajusta el tamaño si es necesario
		}
	};
	*/
	const llistaavisos = document.getElementById("llistaavisos");
   
	avisosactuals.forEach(avisactual => {
		const markeravisosactuals = new google.maps.Marker({
			position: { lat: avisactual.latitud, lng: avisactual.longitud },
			map,
			icon: icons[avisactual.state]
		});
		
		// Cierra el InfoWindow anterior si hay uno abierto
		if (infoWindow) {
			infoWindow.close();
		}

		infoWindow = new google.maps.InfoWindow({
			content: `<div style="font-size: 16px;"><b>Estat: </b>${avisactual.state}<br/><b>Creat: </b>${avisactual.created}<br/></div>`,
			ariaLabel: `${avisactual.number} Estat: ${avisactual.state} Creat: ${avisactual.created}`, // Etiqueta accesible para lectores de pantalla
		});
		
		markeravisosactuals.addListener("click", () => {
			infoWindow.open(map, markeravisosactuals);

			setTimeout(() => {
				// Seleccionar el div generado por Google Maps
				const extraTextContainer = document.querySelector(".gm-style-iw-ch");
		
				if (extraTextContainer) {
					extraTextContainer.innerHTML = `<div style="font-size: 16px;"><b>Número d'avís:</b> ${avisactual.number}</div>`; // Modificar el contenido
				}
			}, 300); // Ajustar el tiempo si es necesario

			//document.getElementById(`avisactual-${avisactual.id}`).scrollIntoView({ behavior: "smooth" });
		});
		/*
		 const listItem = document.createElement("li");
                listItem.id = `avisactual-${avisactual.id}`;
                listItem.className = "list-group-item";
                listItem.innerHTML = `<strong>${avisactual.descripcio}</strong> - ${avisactual.estat} <br> data: ${avisactual.data}`;
                listItem.addEventListener("click", () => {
                    map.setCenter(markeravisosactuals.getPosition());
                    map.setZoom(16);
                    infoWindow.open(map, markeravisosactuals);
                });
                
        llistaavisos.appendChild(listItem); */
	});
}