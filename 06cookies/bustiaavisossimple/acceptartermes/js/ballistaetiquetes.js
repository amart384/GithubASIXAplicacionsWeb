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

document.addEventListener('DOMContentLoaded', function () {

	let inputEtiquetaAvis = document.getElementById('etiquetaavis');
	inputEtiquetaAvis.addEventListener('keydown', deshabilitarEntradaEtiquetAavis);	
	
	  // Generem una URL única para evitar la catxe
	  const url = 'llistatequiteques.xml?' + new Date().getTime();

      // Cargar y parsear el archivo XML
      fetch(url)
        .then(response => response.text())
        .then(data => {
          let parser = new DOMParser();
          let xml = parser.parseFromString(data, 'text/xml');
          let menu = xml.getElementsByTagName('llistatequiteques')[0];
          let menuContainer = document.getElementById('menuContainer');
		  //parseMenu(menu, menuContainer);
		  let rootName = menu.getAttribute('id') || 'etiquetes';
          parseMenuRadio(menu, menuContainer, rootName);
        });

/*
      function parseMenu(node, container) {
        let items = node.children;
        for (let item of items) {
          let itemName = item.getAttribute('name');
		  //let itemColor = item.getAttribute('color') || '#000'; // Default color is black if not provided
          let subItems = item.children;		 

          if (subItems.length > 0) {
            // Crear el dropdown per els submenús
            let dropdown = document.createElement('div');
            dropdown.classList.add('nav-item', 'dropdown','llistaetiquetes');

            let dropdownLink = document.createElement('a');
            dropdownLink.classList.add('nav-link', 'dropdown-toggle');
            dropdownLink.href = '#';
            dropdownLink.textContent = itemName;
			dropdownLink.style.color = '#35393d'; // Aplicar el color 
            dropdown.appendChild(dropdownLink);

            let dropdownMenu = document.createElement('div');
            dropdownMenu.classList.add('dropdown-menu');
            dropdown.appendChild(dropdownMenu);

            // Al fer clic en el dropdownLink, alternem el submenú
            dropdownLink.addEventListener('click', function (event) {
              event.preventDefault();
              dropdownMenu.classList.toggle('show');
            });

			//temporal si es la etiqueta principal la despleguem
			if (itemName == 'Parc Infantil'){
			   dropdownMenu.classList.add('show');			   
			}
			  
            parseMenu(item, dropdownMenu);
            container.appendChild(dropdown);
			
			
          } else {
            let menuItem = document.createElement('a');
            menuItem.classList.add('dropdown-item','etiqueta');
            menuItem.href = '#';
            menuItem.textContent = itemName;
			//menuItem.style.color = 'white'; // Aplicar el color			
			
			let menuItemraio = document.createElement('a');
			
            menuItem.onclick = function (event) {
				
				event.preventDefault();  // Prevenir que el enlace navegue al principio de la página

				let inputEtiquetaAvis = document.getElementById('etiquetaavis');
				inputEtiquetaAvis.value = itemName;
				inputEtiquetaAvis.classList.add('etiqueta','etiquetatriada');				
				// Deshabilitar la entrada sobrescribiendo el evento keydown
				inputEtiquetaAvis.addEventListener('keydown', deshabilitarEntradaEtiquetAavis);
				let textAreaGroup = document.getElementById('textAreaGroup');
				let textdescripcio = document.getElementById('descripcio');				
				
				if (item.hasAttribute('mostrardescripcio')) {
					textAreaGroup.classList.remove('descripciooculta');
					//let itemidentificador = item.getAttribute('identificador')
					textdescripcio.focus();
				} else {
					textAreaGroup.classList.add('descripciooculta');
					document.getElementById('descripcio').value = '';
				}


				// Replegar tots els menus
				//let allDropdownMenus = document.querySelectorAll('.dropdown-menu');
				//allDropdownMenus.forEach(menu => menu.classList.remove('show'));			  
			  
            };
            container.appendChild(menuItem);
          }
        }
      }
	 */
	 function parseMenuRadio(node, container, currentPath) {
        let items = node.children;
        for (let item of items) {
            let itemName = item.getAttribute('id');
			let itemText = item.getAttribute('txt');
			if (!itemName) continue; // Ignorar nodos sin atributo "name"			
		
			let fullPath = `${currentPath}_${itemName}`; // Crear el path concatenado
            let subItems = item.children;

            if (subItems.length > 0) {
                // Crear el dropdown para los submenús
                let dropdown = document.createElement('div');
                dropdown.classList.add('nav-item', 'dropdown', 'llistaetiquetes');

                let dropdownLink = document.createElement('a');
                dropdownLink.classList.add('nav-link', 'dropdown-toggle');
                dropdownLink.href = '#';
                dropdownLink.textContent = itemText;
                dropdownLink.style.color = '#35393d';
                dropdown.appendChild(dropdownLink);

                let dropdownMenu = document.createElement('div');
                dropdownMenu.classList.add('dropdown-menu');
                dropdown.appendChild(dropdownMenu);

                // Alternar el submenú al hacer clic en el dropdownLink
                dropdownLink.addEventListener('click', function (event) {
                    event.preventDefault();
                    dropdownMenu.classList.toggle('show');
                });

                if (itemName === 'Parc Infantil') {
                    dropdownMenu.classList.add('show');
                }

                parseMenuRadio(item, dropdownMenu, fullPath);
                container.appendChild(dropdown);
            } else {
                // Crear input radio en lugar de enlace
                let menuItem = document.createElement('div');
                menuItem.classList.add('dropdown-item', 'etiqueta');
				menuItem.id = `id_${fullPath}`;				

                let radioInput = document.createElement('input');
                radioInput.type = 'radio';
                radioInput.name = 'radioetiquetes';
				radioInput.classList.add('radio-large');
                radioInput.value = itemName;
                radioInput.id = `${fullPath}`;
				radioInput.required = true;  // Establecer como obligatorio

                let label = document.createElement('label');
                label.htmlFor = `${fullPath}`;
                label.textContent = itemText;
                label.style.marginLeft = '8px';
				
				// Envolver el input y el label en el menuItem
				menuItem.appendChild(radioInput);
				menuItem.appendChild(label);
				
				// Hacer clic en el menuItem simula hacer clic en el radio
				menuItem.addEventListener('click', function () {
					radioInput.checked = true; // Activar el radio
					radioInput.dispatchEvent(new Event('change')); // Disparar el evento 'change'
					
					inputEtiquetaAvis.value = itemName;
                    inputEtiquetaAvis.classList.add('etiqueta', 'etiquetatriada');
                    inputEtiquetaAvis.addEventListener('keydown', deshabilitarEntradaEtiquetAavis);
					
					// Quitar el fondo amarillo de todos los menuItems
					let allMenuItems = document.querySelectorAll('.dropdown-item.etiqueta');
					//allMenuItems.forEach(item => item.style.backgroundColor = '');
					allMenuItems.forEach(item => item.classList.remove('etiquetatriada'));

					// Establecer el fondo amarillo al elemento actual
					//menuItem.style.backgroundColor = 'yellow';
				
					menuItem.classList.add('etiquetatriada');					   

                    let textAreaGroup = document.getElementById('textAreaGroup');
                    let textdescripcio = document.getElementById('descripcio');

                    if (item.hasAttribute('mostrardescripcio')) {
                        textAreaGroup.classList.remove('descripciooculta');
                        textdescripcio.focus();
                    } else {
                        textAreaGroup.classList.add('descripciooculta');
                        document.getElementById('descripcio').value = '';
                    }					
					
					// Replegar tots els menus
					//let allDropdownMenus = document.querySelectorAll('.dropdown-menu');
					//allDropdownMenus.forEach(menu => menu.classList.remove('show'));		
					
				});
			
                container.appendChild(menuItem);
            }
        }
    }
	
	// Función para deshabilitar la entrada de texto
	function deshabilitarEntradaEtiquetAavis(event) {
		event.preventDefault(); // Evita cualquier acción de teclado
	}

	
																																													
	let cprt_API_KEY='c89b588b918303304c008b752306789854cd5ee27f307da525620855becb364b';
	
    });