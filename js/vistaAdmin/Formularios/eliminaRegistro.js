

function validarFormulario(event) {
    event.preventDefault(); // Prevenir el envío del formulario

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
        // Asegurarse de que el formulario no se envíe accidentalmente
        confirmarEliminar.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir acción por defecto
            eliminarRegistro();
        });
    }

    // Mostrar el modal (Bootstrap Modal)
    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.show();
}


function eliminarRegistro() {
    console.log("Registro eliminado");

    // Cerrar el modal después de hacer la eliminación
    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
    modal.hide();

    // Enviar el formulario para eliminar el registro en el servidor
    document.getElementById('formDelete').submit();  // Esto enviará el formulario
}
