const buttonContainer = document.getElementById("celda-casilleros");

// Creamos 100 botones
for (let i = 1; i <= 100; i++) {
    // Creamos un botón
    const button = document.createElement("button");
    button.textContent = `Casillero ${i}`;

    // Lo añadimos al contenedor
    buttonContainer.appendChild(button);
}



document.addEventListener('DOMContentLoaded', function () {
    const mostrarCasilleros = document.getElementById('MostrarCasilleros');
    const ocultarCasilleros = document.getElementById('OcultarCasilleros');
    const celdaCasilleros = document.getElementById('celda-casilleros');
    const agregarRegistro = document.getElementById('Agregar');
    const eliminarRegistro = document.getElementById('Eliminar');
    const formularioAgregar = document.getElementById('formularioIngreso');
    const formularioEliminar = document.getElementById('formularioEliminar');
  
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
      }
    });
    
    eliminarRegistro.addEventListener('change', function () {
      if (eliminarRegistro.checked) {
        formularioAgregar.style.display = 'none'; 
        formularioEliminar.style.display = 'block';
      }
  });
});

