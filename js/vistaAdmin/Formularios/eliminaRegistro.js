// Función para validar el formulario y mostrar los datos en el modal
function validarFormulario(event) {
    event.preventDefault(); // Esto previene que el formulario se envíe antes de mostrar el modal

    // Obtener los valores del formulario
    const nombre = document.getElementById('NombreBorrar').value.trim();
    const primerApellido = document.getElementById('primerApellidoBorrar').value.trim();
    const segundoApellido = document.getElementById('segundoApellidoBorrar').value.trim();
    const usuarioBorrar = document.getElementById('validarUsuario').value.trim();
    const casilleroBorrar = document.getElementById('casilleroBorrar').value.trim();
    const boletaBorrar = document.getElementById('boletaBorrar').value.trim();
    const confirmarEliminar = document.getElementById('confirmarEliminar');

    // Si algún campo está vacío, mostrar un mensaje en el modal
    if (!nombre || !primerApellido || !segundoApellido || !usuarioBorrar || !casilleroBorrar || !boletaBorrar) {
        document.getElementById('modalMensaje').innerHTML = "Por favor, llena todos los campos antes de continuar.";
        confirmarEliminar.style.display = 'none';

    } else {
        // Si todos los campos están llenos, mostrar los datos ingresados en el modal
        document.getElementById('modalMensaje').innerHTML = `
            <p><strong>Nombre:</strong> ${nombre}</p>
            <p><strong>Primer Apellido:</strong> ${primerApellido}</p>
            <p><strong>Segundo Apellido:</strong> ${segundoApellido}</p>
            <p><strong>Usuario:</strong> ${usuarioBorrar}</p>
            <p><strong>Número de Casillero:</strong> ${casilleroBorrar}</p>
            <p><strong>No. Boleta:</strong> ${boletaBorrar}</p>
            <p>¿Seguro que deseas eliminar este registro?</p>
        `;
        confirmarEliminar.style.display = 'block'; // Mostrar el botón de confirmar eliminación
    }

    // Mostrar el modal (Bootstrap Modal)
    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.show();
}

// Función para eliminar el registro y cerrar el modal
function eliminarRegistro() {
    console.log("Registro eliminado");

    // Cerrar el modal después de hacer la eliminación
    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.hide();

    // Enviar el formulario para eliminar el registro en el servidor
    document.getElementById('formDelete').submit();  // Esto enviará el formulario
}

