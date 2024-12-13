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
        regex: /^[0-3](\.[0-9]{1,2})?$/, // Valores entre 0.00 y 3.00
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
        return true; // Ignorar campos ocultos
    }

    const tipo = campo.id;
    const validacion = validaciones[tipo];
    if (!validacion) {
        return true; // Si el campo no tiene validación, asumir válido
    }

    const valor = campo.type === 'file' && campo.files.length > 0 
        ? campo.files[0].name 
        : campo.value.trim();

    const esValido = validacion.regex.test(valor);
    const errorDiv = campo.nextElementSibling;

    if (esValido) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
        errorDiv.textContent = '';
    } else {
        campo.classList.remove('is-valid');
        campo.classList.add('is-invalid');
        errorDiv.textContent = validacion.mensaje;
    }
    return esValido;
}

// Función para validar todo el formulario
function validarFormulario() {
    const campos = document.querySelectorAll('#solicitudForm input');
    let esValido = true;

    campos.forEach(campo => {
        if (campo.offsetParent !== null) {
            if (!validarCampo(campo)) {
                esValido = false;
            }
        }
    });
    return esValido;
}

// Función para mostrar el modal con los datos
function mostrarModal() {
    const formularioValido = validarFormulario();
    if (!formularioValido) {
        alert('Por favor, corrija los errores en el formulario.');
        return;
    }

    const datos = {
        'Tipo de Solicitud': document.getElementById('Renovacion')?.checked ? 'Renovación' : 'Registro',
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
        'Usuario': document.getElementById('Usuario')?.value || ''
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
    });

    // Reset file inputs
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => input.value = '');

    // Reset radio buttons
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    radioButtons.forEach(radio => radio.checked = false);
}

// Función para manejar el envío de datos
function datosSubidos(event) {
    event.preventDefault(); // Prevenir submit por defecto

    if (validarFormulario()) {
        // Crear FormData para enviar todos los datos
        const formData = new FormData(document.getElementById('solicitudForm'));

        fetch('../php/ProcesarForm.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert(result.message);
                const modalElement = document.getElementById('DatosModal');
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) modal.hide();
                LimpiarFormulario();
            } else {
                alert(result.message); // Mostrar mensaje de error si hay duplicados
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un problema al subir los datos');
        });
    }
}

// Asociar eventos al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    // Validar campos en tiempo real
    const inputs = document.querySelectorAll('#solicitudForm input');
    inputs.forEach(input => {
        input.addEventListener('input', () => validarCampo(input));
    });

    // Botón "Registrar"
    const registrarBtn = document.getElementById('Registrar');
    registrarBtn.addEventListener('click', mostrarModal);

    // Envío del formulario
    const formulario = document.getElementById('solicitudForm');
    formulario.addEventListener('submit', datosSubidos);
});