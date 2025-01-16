
document.addEventListener('DOMContentLoaded', function () {
  const buttonContainer = document.getElementById("celda-casilleros");

// Creamos 100 botones
for (let i = 100; i >= 1; i--) {
    // Creamos un botón
    const button = document.createElement("button");
    button.textContent = `Casillero ${i}`;
     // Aplicamos estilo directamente
     button.style.width = "17px"; // Ajusta el ancho a tu necesidad
     button.style.height = "50px"; // Opcional: establece la altura
     button.style.backgroundColor = "green"; // Color de fondo
    // Lo añadimos al contenedor
    buttonContainer.appendChild(button);
}
    const mostrarCasilleros = document.getElementById('MostrarCasilleros');
    const ocultarCasilleros = document.getElementById('OcultarCasilleros');
    const celdaCasilleros = document.getElementById('celda-casilleros');
    const agregarRegistro = document.getElementById('Agregar');
    const eliminarRegistro = document.getElementById('Eliminar');
    const actualizarRegistro = document.getElementById('Actualizar');
    const formularioAgregar = document.getElementById('formularioIngreso');
    const formularioEliminar = document.getElementById('formularioEliminar');
    const formularioActualizar = document.getElementById('formularioUpdate');
  
    // Mostrar casilleros cuando se selecciona "Mostrar Casilleros"
    mostrarCasilleros.addEventListener('change', function () {
      if (mostrarCasilleros.checked) {
        celdaCasilleros.style.display = 'grid'; // Mostrar como grid
      }
    });
  
    // Ocultar casilleros cuando se selecciona "Ocultar Casilleros"
    ocultarCasilleros.addEventListener('change', function () {
      if (ocultarCasilleros.checked) {
        celdaCasilleros.style.display = 'none'; // Ocultar
      }
    });

    //mostrar formulario de agregar registro    
    agregarRegistro.addEventListener('change', function () {
      if (agregarRegistro.checked) {
        formularioAgregar.style.display = 'block'; 
        formularioEliminar.style.display = 'none';
        formularioActualizar.style.display = 'none';
      }
    });
    
    //Mostar formulario para ekiminar registro 
    eliminarRegistro.addEventListener('change', function () {
      if (eliminarRegistro.checked) {
        formularioAgregar.style.display = 'none'; 
        formularioEliminar.style.display = 'block';
        formularioActualizar.style.display = 'none';  
      }
  });

  //Mostrar un formulario para actualizar registros
  

  actualizarRegistro.addEventListener('change', function () {
    if (actualizarRegistro.checked) {
      formularioActualizar.style.display = 'block';
      formularioAgregar.style.display = 'none'; 
      formularioEliminar.style.display = 'none';
    
    }
  });


});

