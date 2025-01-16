
document.addEventListener('DOMContentLoaded', function () {
    const renovacionInput = document.getElementById('Renovacion');
    const lockerAnterior = document.getElementById('lockerAnterior');
    const EleccionCURP = document.getElementById('EleccionCURP');
    const botonRegistrar = document.getElementById('Registrar');
    const botonLimpiar = document.getElementById('Limpiar');
    const registroInput = document.getElementById('Registro');
    const EleccionNombre = document.getElementById('EleccionNombre');
    const EleccionTelefono = document.getElementById('EleccionTelefono');
    const PrimerApellido = document.getElementById('PrimerApellido');
    const SegundoApellido = document.getElementById('SegundoApellido');
    const EleccionCorreo = document.getElementById('EleccionCorreo');
    const EleccionBoleta = document.getElementById('EleccionBoleta');
    const EleccionEstatura = document.getElementById('EleccionEstatura');
    const EleccionCredencial = document.getElementById('EleccionCredencial');
    const EleccionHorario = document.getElementById('EleccionHorario');
    const EleccionUsuario = document.getElementById('EleccionUsuario');
    const EleccionContraseña = document.getElementById('EleccionContraseña');

    renovacionInput.addEventListener('click', function () {
        lockerAnterior.style.display = renovacionInput.checked ? 'block' : 'none';
        botonRegistrar.style.display= renovacionInput.checked ? 'block' : 'none';
        botonLimpiar.style.display = renovacionInput.checked ? 'block' : 'none';
        mostrarCamposRegistro();
    });

    registroInput.addEventListener('click', function () {
        botonRegistrar.style.display = 'block';
        botonLimpiar.style.display = 'block';
        lockerAnterior.style.display = 'none';
        mostrarCamposRegistro();
    });

    function mostrarCamposRegistro() {
        EleccionCURP.style.display = 'block';
        EleccionNombre.style.display = 'block';
        EleccionTelefono.style.display = 'block';
        PrimerApellido.style.display = 'block';
        SegundoApellido.style.display = 'block';
        EleccionCorreo.style.display = 'block';
        EleccionBoleta.style.display = 'block';
        EleccionEstatura.style.display = 'block';
        EleccionCredencial.style.display = 'block';
        EleccionHorario.style.display = 'block';
        EleccionUsuario.style.display = 'block';
        EleccionContraseña.style.display = 'block';
    }
});