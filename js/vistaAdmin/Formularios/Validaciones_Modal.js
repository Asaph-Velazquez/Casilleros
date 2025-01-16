// Función para mostrar mensajes en el modal
function mostrarMensajeModal(mensaje) {
    document.getElementById('mensajeModalTexto').textContent = mensaje;
    const mensajeModal = new bootstrap.Modal(document.getElementById('MensajeModal'));
    mensajeModal.show();
}

// Configuración de validaciones
const validaciones = {
    Nombre: {
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚ\s]{3,30}$/,
        mensaje: "El nombre debe tener entre 3 y 30 caracteres"
    },
    ApellidoPaterno: {
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚ\s]{3,30}$/,
        mensaje: "El apellido debe tener entre 3 y 30 caracteres"
    },
    ApellidoMaterno: {
        regex: /^[a-zA-ZáéíóúÁÉÍÓÚ\s]{3,30}$/,
        mensaje: "El apellido debe tener entre 3 y 30 caracteres"
    },
    Telefono: {
        regex: /^[0-9]{10}$/,
        mensaje: "El teléfono debe tener exactamente 10 dígitos"
    },
    Correo: {
        regex: /^[a-zA-Z0-9._%+-]+@alumno\.ipn\.mx$/,
        mensaje: "El correo debe ser del dominio alumno.ipn.mx"
    },
    Boleta: {
        regex: /^20[0-9]{8}$/,
        mensaje: "La boleta debe tener el formato 20XXXXXXXX"
    },
    Estatura: {
        regex: /^[0-3](\.[0-9]{1,2})?$/,
        mensaje: "La estatura debe estar entre 0.00 y 3.00 con hasta dos decimales"
    },
    CURP: {
        regex: /^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])[HM](AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}\d{1}$/,
        mensaje: "El CURP debe tener el formato AAAA######HMAAAANNA"
    },
    Usuario: {
        regex: /^.{4,}$/,
        mensaje: "El usuario debe tener al menos 4 caracteres"
    },
    Contraseña: {
        regex: /^.{8,}$/,
        mensaje: "La contraseña debe tener al menos 8 caracteres"
    },
    Horario: {
        regex: /^.+\.(pdf|PDF)$/,
        mensaje: "El archivo debe ser de formato PDF"
    },
    Credencial: {
        regex: /^.+\.(pdf|PDF)$/,
        mensaje: "El archivo debe ser de formato PDF"
    }
};

// Función para validar un campo
function validarCampo(campo) {
    if (!campo.offsetParent || campo.style.display === 'none') {
        return true; // Ignorar campos no visibles
    }

    const tipo = campo.id;
    const validacion = validaciones[tipo];
    if (!validacion) {
        return true; // Ignorar campos sin validación específica
    }

    const valor = campo.type === 'file' && campo.files.length > 0 
        ? campo.files[0].name 
        : campo.value.trim();

    const esValido = validacion.regex.test(valor);
    const errorDiv = campo.nextElementSibling;

    if (esValido) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
        if (errorDiv) errorDiv.textContent = '';
    } else {
        campo.classList.remove('is-valid');
        campo.classList.add('is-invalid');
        if (errorDiv) errorDiv.textContent = validacion.mensaje;
    }
    return esValido;
}

// Función para validar todo el formulario
function validarFormulario() {
    const campos = document.querySelectorAll('#solicitudForm input');
    let esValido = true;
    let mensajesError = [];

    campos.forEach(campo => {
        if (!validarCampo(campo)) {
            esValido = false;
            const validacion = validaciones[campo.id];
            if (validacion) {
                mensajesError.push(validacion.mensaje);
            }
        }
    });

    if (!esValido) {
        mostrarMensajeModal("Por favor corrija los siguientes errores:\n" + mensajesError.join("\n"));
    }

    return esValido;
}

// Función para mostrar el modal con los datos
function mostrarModal() {
    if (!validarFormulario()) {
        return;
    }

    const datos = {
        'Tipo de Solicitud': document.querySelector('input[name="tipoSolicitud"]:checked')?.value || 'N/A',
        'Casillero Anterior': document.getElementById('CasilleroAnterior')?.value || 'N/A',
        'CURP': document.getElementById('CURP')?.value || '',
        'Nombre': document.getElementById('Nombre')?.value || '',
        'Primer Apellido': document.getElementById('ApellidoPaterno')?.value || '',
        'Segundo Apellido': document.getElementById('ApellidoMaterno')?.value || '',
        'Teléfono': document.getElementById('Telefono')?.value || '',
        'Correo': document.getElementById('Correo')?.value || '',
        'Boleta': document.getElementById('Boleta')?.value || '',
        'Estatura': document.getElementById('Estatura')?.value || '',
        'Credencial': document.getElementById('Credencial')?.files[0]?.name || '',
        'Horario': document.getElementById('Horario')?.files[0]?.name || '',
        'Usuario': document.getElementById('Usuario')?.value || '',
        'Contraseña': document.getElementById('Contraseña')?.value || ''
    };

    let contenidoHTML = '<div class="container">';
    for (const [clave, valor] of Object.entries(datos)) {
        if (valor && valor !== 'N/A') {
            contenidoHTML += `
                <div class="row mb-2">
                    <div class="col-4"><strong>${clave}:</strong></div>
                    <div class="col-8">${valor}</div>
                </div>`;
        }
    }
    contenidoHTML += '</div>';

    const modalBody = document.querySelector('#DatosModal .modal-body');
    modalBody.innerHTML = contenidoHTML;

    const modal = new bootstrap.Modal(document.getElementById('DatosModal'));
    modal.show();
}

// Función para limpiar el formulario
function LimpiarFormulario() {
    const inputs = document.querySelectorAll('#solicitudForm input');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
        input.value = '';
        const errorDiv = input.nextElementSibling;
        if (errorDiv && errorDiv.classList.contains('mensaje-invalido')) {
            errorDiv.textContent = '';
        }
    });
    document.querySelectorAll('input[type="radio"]').forEach(radio => radio.checked = false);
}

// Función para procesar datos al enviarlos
function datosSubidos(event) {
    event.preventDefault();

    if (validarFormulario()) {
        const formData = new FormData(document.getElementById('solicitudForm'));
        const tipoSolicitud = document.querySelector('input[name="tipoSolicitud"]:checked')?.value || '';

        fetch('../php/ProcesarForm.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('DatosModal'));
                if (modal) modal.hide();

                alert(result.message);
                LimpiarFormulario();

                const mensajeFinal = tipoSolicitud === 'Registro'
                    ? 'Después de 48 hrs., deberá ingresar al sistema para ver el resultado de su solicitud.'
                    : 'Para que se te respete tu número de casillero tienes 24 horas para iniciar sesión y subir el comprobante de pago.';

                mostrarMensajeModal(mensajeFinal);
            } else {
                alert(result.message);
            }
        })
    }
}

// Asociar eventos al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('#solicitudForm input').forEach(input => {
        input.addEventListener('input', () => validarCampo(input));
    });

    document.getElementById('Registrar')?.addEventListener('click', mostrarModal);

    document.getElementById('solicitudForm')?.addEventListener('submit', datosSubidos);
});
