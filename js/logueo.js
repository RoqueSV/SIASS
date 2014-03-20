// JavaScript Document
function ValidarUsuario(){
	 with (document.forms["login"])
  {
	var valor=usuario.value;	
	var valor2=pass.value;
	if(valor==""||valor2==""){
		alert("Error en Ingreso de Datos de Loggin. \n\nDigite Usuario y Contrase\u00f1a.");
	return false;
				}
	  }
	
	return true;
		
	}
        
        
        