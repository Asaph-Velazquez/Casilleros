function validarLogin(event) {
    // Evitar el envío predeterminado
    event.preventDefault();

    // Obtener valores de los campos
    const usuario = document.getElementById('usuario').value.trim();
    const numTrabajador = document.getElementById('NumTrabajador').value.trim();
    const contrasenia = document.getElementById('contrasenia').value.trim();
    const mensaje = document.getElementById('mensaje-incompleto');

    // Validar que los campos no estén vacíos
    if (!usuario || !numTrabajador || !contrasenia) {
        mensaje.textContent = 'Por favor, completa todos los campos.';
        mensaje.style.color = 'red';
        return false;
    }

    // Limpiar mensajes de error
    mensaje.textContent = '';

    // Enviar el formulario
    document.querySelector('form').submit();
    return true;
}
