function enviarActualizacion(event) {
     // Prevenir el envío del formulario
     event.preventDefault();

    // Obtener los valores del formulario
    const nombre = document.getElementById('NombreActualizar').value.trim();
    const primerApellido = document.getElementById('PrimerApellidoActualizar').value.trim();
    const segundoApellido = document.getElementById('SegundoApellidoActualizar').value.trim();
    const estatura = document.getElementById('EstaturaActualizar').value.trim();
    const telefono = document.getElementById('TelefonoActualizar').value.trim();
    const correo = document.getElementById('correoActualizar').value.trim();
    const usuario = document.getElementById('usuarioActualizar').value.trim();
    const curp = document.getElementById('curpActualizar').value.trim();
    const nuevoCasillero = document.getElementById('casilleroActualizar').value.trim();
    const botonActualizar = document.getElementById('updateDatos'); // Botón de actualización

    // Verificar si alguno de los campos está vacío
    if (!nombre || !primerApellido || !segundoApellido || !estatura || !telefono || !correo || !usuario || !curp || !nuevoCasillero) {
        // Si algún campo está vacío, mostrar mensaje de advertencia
        document.getElementById('modalMensaje').innerHTML = "Por favor, llena todos los campos antes de continuar.";
        botonActualizar.style.display = 'none'; // Ocultar el botón de confirmación
    } else {
        // Si todos los campos están llenos, mostrar los datos en el modal
        document.getElementById('modalMensaje').innerHTML = `
            <p><strong>Nombre:</strong> ${nombre}</p>
            <p><strong>Primer Apellido:</strong> ${primerApellido}</p>
            <p><strong>Segundo Apellido:</strong> ${segundoApellido}</p>
            <p><strong>Estatura:</strong> ${estatura}</p>
            <p><strong>Teléfono:</strong> ${telefono}</p>
            <p><strong>Correo:</strong> ${correo}</p>
            <p><strong>Usuario:</strong> ${usuario}</p>
            <p><strong>CURP:</strong> ${curp}</p>
            <p><strong>Casillero:</strong> ${nuevoCasillero}</p>
            <p>¿Seguro que deseas actualizar este registro?</p>
        `;
        botonActualizar.style.display = 'block'; // Mostrar el botón de confirmación
         // Asegurarse de que el formulario no se envíe accidentalmente
         botonActualizar.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir acción por defecto
            actualizarDatos();
        });
        
    }
     // Mostrar el modal (Bootstrap Modal)
     const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
     modal.show();
     // Agregar el evento para cerrar el modal al hacer clic en "Cerrar"
    const botonCerrar = document.querySelector('[data-bs-dismiss="modal"]');
    if (botonCerrar) {
        botonCerrar.addEventListener('click', function() {
            modal.hide(); // Cerrar el modal manualmente al hacer clic en el botón de "Cerrar"
        });
    }
}

function actualizarDatos() {
    
    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.hide();

    // Enviar el formulario para eliminar el registro en el servidor
    document.getElementById('consultarActualizacion').submit();  // Esto enviará el formulario
}
