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
        regex: /^[0-2]\.[0-9]{2}$/,
        mensaje: "La estatura debe tener el formato X.XX"
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

function validarCampo(campo) {
    if (!campo.offsetParent || campo.style.display === 'none') {
        return true;
    }

    const tipo = campo.id;
    const validacion = validaciones[tipo];
    if (!validacion) {
        return true;
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

function validarFormulario() {
    const campos = document.querySelectorAll('#Formulario input');
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

function subida() {
    const formularioValido = validarFormulario();
    if (!formularioValido) {
        alert('Por favor, corrija los errores en el formulario');
        return;
    }

    const datos = {
        'Tipo de Solicitud': document.getElementById('Renovacion')?.checked ? 'Renovación' : 'Registro',
        'Casillero Anterior': document.getElementById('CasilleroAnterior')?.value || 'N/A',
        'CURP': document.getElementById('CURP')?.value || '',
        'Nombre': document.getElementById('Nombre')?.value || '',
        'Primer Apellido': document.getElementById('ApellidoPaterno')?.value || '',
        'Segundo Apellido': document.getElementById('ApellidoMaterno')?.value || '',
        'Telefono': document.getElementById('Telefono')?.value || '',
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

document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('#Formulario input');
    inputs.forEach(input => {
        input.addEventListener('input', () => validarCampo(input));
    });

    const formulario = document.querySelector('#Formulario');
    if (formulario) {
        formulario.addEventListener('submit', function (event) {
            if (!validarFormulario()) {
                event.preventDefault();
                alert('Hay errores en el formulario');
            }
        });
    }
});

function datosSubidos() {
    alert('Datos subidos correctamente');
}

function validarLogin() {
    const campos = document.querySelectorAll('.form input');
    let valido = true;
    for (let i = 0; i < campos.length && valido; i++) {
        if (campos[i].value === '') valido = false;
    }
    document.getElementById('mensaje-incompleto').innerHTML = valido ? '' : 'Complete los campos faltantes';
}
