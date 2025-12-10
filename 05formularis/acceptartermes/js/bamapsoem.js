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
let marker;

//let geocoder;
let addressField;


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
	
	let cprt_API_KEY3='c89b588b918303304c008b752306789854cd5ee27f307da525620855becb364b';
			
}

// Carregar el mapa de manera asíncrona
function loadOpenStreetMapAPI() {
  const script = document.createElement('script');
  script.src = `https://unpkg.com/leaflet@1.9.3/dist/leaflet.js`; 
  script.defer = true;
  script.async = true;
  document.head.appendChild(script);
  initMap();
}

// Inicialitzar el mapa
function initMap() {
		
	//geocoder = new google.maps.Geocoder(); // Crear el servei de geocodificació
	
    //Per defecte es a Girona
	var userLocation = {
		lat: 41.981752,
		lng: 2.823311
	};

	
	map = L.map('map', {
            gestureHandling: true, // Requiere dos dedos para desplazarse en dispositivos táctiles 
			maxZoom: 19 			
        }).setView(userLocation, 19);
	// Usa OpenStreetMap como capa base del mapa
	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		maxZoom: 19 
	}).addTo(map);		
		
	// Activa el desplazamiento solo con dos dedos en dispositivos táctiles
	map.touchZoom.enable();  // Vuelve a activar el touchZoom
	map.options.gestureHandling = true; // Habilita el manejo de gestos
	map.on('touchstart', function(e) {
		if (e.touches.length > 1) {
			map.dragging.enable(); // Permitir arrastrar si se usan dos dedos
		} else {
			map.dragging.disable(); // Deshabilitar si solo hay un dedo
		}
	});
		
	addressField = document.getElementById('adrecaavis'); // Referencia al camp de text
	addressField.value = '';	

	/*
	// Crear el mapa centrat en l'ubicació predefinida
	map = new google.maps.Map(document.getElementById('map'), {
		zoom: 13,
		center: userLocation,
		mapId: "DEMO_MAP_ID", // Map ID is required for advanced markers.
		mapTypeControl: false, // Amaga l'opció de satèlit
		streetViewControl: false, // Amaga l'icona de Street View
		fullscreenControl: false // (Opcional) Amaga el botó de pantalla complerta
	})
	;*/
	
		
	showPosition(userLocation, 14);
	
	/*// Crear un marcador a la ubicació actual de l'usuari
	marker = new google.maps.marker.AdvancedMarkerElement({
		position: userLocation,
		map: map,
		draggable: true, // Per permetre que l'usuari mogui el marcador manualment.
		title: 'avis',
	});
	*/

	// Habilitar l'event de clic inicialment
	enableClickOnMap();
}

 // Muestra la posición del usuario en el mapa
function showPosition(position, zoom) {
	var lat = position.lat;
	var lon = position.lng;
	var userLocation = [lat, lon];

	// Mueve el mapa a la ubicación del usuario
	//map.setView(userLocation, 20);			

	// Si ya existe un marcador, actualiza su posición
	if (marker) {
		marker.setLatLng(userLocation);
	} else {
		// Añade un marcador en la ubicación del usuario
		marker = L.marker(userLocation).addTo(map);
			//.bindPopup("Esteu aquí").openPopup();
	}
	
	map.setView(marker.getLatLng(), zoom);
}
		
// Actualitzar el mapa
function UpdateMapGPS() {
	
  // Intentar obtenir la ubicació de l'usuari
  if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
		const clickedLocation = {
			lat: position.coords.latitude,
			lng: position.coords.longitude
		};

		// Mueve el mapa a la ubicación del usuario
        map.setView(clickedLocation, 20);
			
		/* Crear el mapa centrat en la ubicació dels usuaris
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 15,
			center: clickedLocation,
			mapId: "DEMO_MAP_ID", // Map ID is required for advanced markers.
			mapTypeControl: false, // Amaga l'opció de satèli
			streetViewControl: false, // Amaga l'icona de Street View
			fullscreenControl: false // (Opcional) OAmaga el botó de pantalla complerta
		});
		
		// Crear un marcador en la ubicación actual del usuario
		marker = new google.maps.marker.AdvancedMarkerElement({
			position: clickedLocation,
			map: map,
			draggable: true, // Per permetre que lusuari mogui el marcador manualment.
			title: 'avis',
		});
		*/

		// Si ya existe un marcador, actualiza su posición
		if (marker) {
			marker.setLatLng(clickedLocation);
		} else {
			// Añade un marcador en la ubicación del usuario
			marker = L.marker(clickedLocation).addTo(map);
				//.bindPopup("Esteu aquí").openPopup();
		}
		
		map.setView(marker.getLatLng(), 20);

		
		// Geocodificar la ubicació inicial i mostrar-la al camp de text
		//geocodeLatLng(geocoder, clickedLocation, addressField);
		geocodeLatLngOpenStreeMap(clickedLocation, addressField);
		
	}, function() {
	  alert('Error al obtenir la localització');
	},showGPSError);
  } else {
	alert('El navegador no suporta localització.');
  }
}


// Funció per habilitar l'esdeveniment de clic al mapa
function enableClickOnMap() {
	/*
	clickListener = map.addListener('click', function(event) {
		const clickedLocation = {
		  lat: event.latLng.lat(),
		  lng: event.latLng.lng()
		};
		
		// Moure el marcador a la nova ubicació
		marker.position = clickedLocation;

		// Passa de coordenades GPS a text
		geocodeLatLng(geocoder, clickedLocation, addressField);
		
		document.getElementById('localitzaciomapa').checked = true;
	});*/
	
	/*
		map.on('click', function(e) {
            var newLatLng = e.latlng; // Obtener las coordenadas donde se hizo clic

            // Si ya existe un marcador, actualiza su posición
            if (marker) {
                marker.setLatLng(newLatLng);
				//.bindPopup("Marcador movido aquí").openPopup();
            } else {
                // Si no existe marcador, crea uno nuevo
                marker = L.marker(newLatLng).addTo(map);
                    //.bindPopup("Marcador colocado aquí").openPopup();
            }

            // Mueve el mapa a la nueva ubicación
            map.setView(newLatLng, 20);
			
			geocodeLatLng(geocoder, clickedLocation, addressField);
		
			document.getElementById('localitzaciomapa').checked = true;
			
        });*/
	
		map.on('click', function(event) {
			var clickedLocation = event.latlng; // Obtener las coordenadas donde se hizo clic

            // Si ya existe un marcador, actualiza su posición
            if (marker) {
                marker.setLatLng(clickedLocation);
				//.bindPopup("Marcador movido aquí").openPopup();
            } else {
                // Si no existe marcador, crea uno nuevo
                marker = L.marker(clickedLocation).addTo(map);
                    //.bindPopup("Marcador colocado aquí").openPopup();
            }

            // Mueve el mapa a la nueva ubicación
            map.setView(clickedLocation, 20);
			
			//geocodeLatLng(geocoder, clickedLocation, addressField);
			geocodeLatLngOpenStreeMap(clickedLocation, addressField);
		
			document.getElementById('localitzaciomapa').checked = true;
			
		});	
}

// Funció per deshabilitar l'esdeveniment de clic al mapa
function disableClickOnMap() {
	if (clickListener) {
		//google.maps.event.removeListener(clickListener);
		map.event.removeListener(clickListener);
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

/*
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
}*/
	
function geocodeLatLngOpenStreeMap(location, addressField) {
  
  let lat = location.lat;
  let lon = location.lng;
			
  //var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}&addressdetails=1`;
	var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}&addressdetails=1&accept-language=ca`;
			
	fetch(url)
		.then(response => response.json())
		.then(data => {
			/*// Si la búsqueda inversa tiene éxito, muestra la dirección en la caja de texto
			var address = data.display_name;
			document.getElementById('address').value = address;
			*/
			
			// Extraemos los componentes relevantes de la dirección
			var addressComponents = data.address;
			
			// Filtrar los componentes para mostrar solo los relevantes
			var street = addressComponents.road || '';
			var houseNumber = addressComponents.house_number || '';
			var postcode = addressComponents.postcode || '';
			var city = addressComponents.city || addressComponents.town || addressComponents.village || '';                   
			
			// Concatenar la dirección sin provincia, comarca, barrio ni país
			var address = `${street}, ${houseNumber}, ${postcode}, ${city}`;
			
			addressField.value = address.trim();	
			
			// Mostrar la dirección en la caja de texto
			//document.getElementById('address').value = address.trim();	

			document.getElementById("latitud").value = location.lat;
			document.getElementById("longitud").value = location.lng;		
			
		})
		.catch(error => {
			addressField.value = 'Error al obtenir l\'adreça: ';
		});		
}
	