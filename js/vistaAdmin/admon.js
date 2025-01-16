document.addEventListener('DOMContentLoaded', function () {
  const buttonContainer = document.getElementById("celda-casilleros");

  // Creamos 100 botones
  for (let i = 100; i >= 1; i--) {
      // Creamos un botón
      const button = document.createElement("button");
      button.textContent = `Casillero ${i}`;
      button.id = `casillero-${i}`;
      buttonContainer.appendChild(button);
  }

  // Llamamos al archivo PHP usando fetch para obtener los casilleros ocupados
  fetch('../php/Admin/casilleros.php')
      .then(response => response.json())  // Parseamos el JSON que nos devuelve el PHP
      .then(casillerosOcupados => {
          // Para cada casillero, revisamos si está ocupado
          casillerosOcupados.forEach(casilleroId => {
              const casilleroButton = document.getElementById(`casillero-${casilleroId}`);
              if (casilleroButton) {
                  casilleroButton.style.backgroundColor = "gray";  // Cambiar a gris si está ocupado
                  casilleroButton.disabled = true;  // Desactivar el botón si está ocupado
              }
          });
      })
      .catch(error => console.error('Error al cargar los casilleros ocupados:', error));

  const mostrarCasilleros = document.getElementById('MostrarCasilleros');
  const ocultarCasilleros = document.getElementById('OcultarCasilleros');
  const celdaCasilleros = document.getElementById('celda-casilleros');
  const agregarRegistro = document.getElementById('Agregar');
  const eliminarRegistro = document.getElementById('Eliminar');
  const actualizarRegistro = document.getElementById('Actualizar');
  const formularioAgregar = document.getElementById('formularioIngreso');
  const formularioActualizar = document.getElementById('formularioUpdate');

  // Mostrar casilleros cuando se selecciona "Mostrar Casilleros"
  mostrarCasilleros.addEventListener('change', function () {
      if (mostrarCasilleros.checked) {
          celdaCasilleros.style.display = 'grid'; // Mostrar los casilleros
      }
  });

  // Ocultar casilleros cuando se selecciona "Ocultar Casilleros"
  ocultarCasilleros.addEventListener('change', function () {
      if (ocultarCasilleros.checked) {
          celdaCasilleros.style.display = 'none'; // Ocultar los casilleros
      }
  });

  // Mostrar formulario de agregar registro    
  agregarRegistro.addEventListener('change', function () {
      if (agregarRegistro.checked) {
          formularioAgregar.style.display = 'block'; 
          formularioActualizar.style.display = 'none';
      }
  });

  // Mostrar formulario para eliminar registro
  eliminarRegistro.addEventListener('change', function () {
      if (eliminarRegistro.checked) {
          formularioAgregar.style.display = 'none'; 
          formularioActualizar.style.display = 'none';  
      }
  });

  // Mostrar un formulario para actualizar registros
  actualizarRegistro.addEventListener('change', function () {
      if (actualizarRegistro.checked) {
          formularioActualizar.style.display = 'block';
          formularioAgregar.style.display = 'none'; 
      }
  });
});
