function LimpiarFormulario() {
    const inputs = document.querySelectorAll('#Formulario input');
    const esRenovacion = document.getElementById('Renovacion').checked;
    const esRegistro = document.getElementById('Registro').checked;
    
    inputs.forEach(input =>{
      input.value=''  //asignamos cadena vacia a cada elemento
      input.classList.remove('is-valid', 'is-invalid');
    });

    //arreglo con todos los IDs de todos los campos 
    const camposOcultos = [
    'lockerAnterior',         
    'EleccionNombre',         
    'EleccionTelefono',       
    'PrimerApellido',          
    'SegundoApellido',         
    'EleccionCorreo',          
    'EleccionBoleta',          
    'EleccionEstatura',        
    'EleccionCredencial',      
    'EleccionHorario',         
    'EleccionUsuario',         
    'EleccionContraseña',
    'EleccionCURP',       
    ]

    if(esRenovacion){
      const lockerAnterior= document.getElementById('lockerAnterior');
      if(lockerAnterior){
        lockerAnterior.style.display='block'
      }
      MostrarCamposRegistro();

      document.getElementById('Registrar').style.display = 'block';  
      document.getElementById('Limpiar').style.display = 'block';
    }
    else if(esRegistro){
      MostrarCamposRegistro();
      document.getElementById('Registrar').style.display = 'block';
      document.getElementById('Limpiar').style.display = 'block';
    }
    else{
        camposOcultos.forEach(campo=>{
        const elemento= document.getElementById(campo);
        if (elemento){
          elemento.style.display= 'none';
        }
      });
      document.getElementById('Registrar').style.display = 'none';
      document.getElementById('Limpiar').style.display = 'none';
    }
  };

  function MostrarCamposRegistro(){
    const CamposRegistros=[        
    'EleccionNombre',         
    'EleccionTelefono',    
    'PrimerApellido',         
    'SegundoApellido',       
    'EleccionCorreo',         
    'EleccionBoleta',          
    'EleccionEstatura',       
    'EleccionCredencial',     
    'EleccionHorario',      
    'EleccionUsuario',         
    'EleccionContraseña',
    'EleccionCURP'      
    ]
    
    CamposRegistros.forEach(campo =>{
      const elementoVisible= document.getElementById(CamposRegistros);
      if(elementoVisible){
        elementoVisible.style.display= 'block'
      }
    })
  };