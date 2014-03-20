//------------------------------------------------------------------------------------
//tooltip: muestra mensajitos flotantes (vi�etas)
//------------------------------------------------------------------------------------
var objeto = "";
function toolTip(mensaje,elemento) {
	objeto = elemento;
	objeto.onmousemove = actualizaPosicion;
	document.getElementById('toolTipBox').innerHTML = mensaje;
	document.getElementById('toolTipBox').style.display = "block";
	window.onscroll = actualizaPosicion;
}
function actualizaPosicion() {
	var evento = arguments[0]?arguments[0]:event;
	var x = evento.clientX;
	var y = evento.clientY;
	posicionX = 24;
	posicionY = 0;
	document.getElementById('toolTipBox').style.top  = y-2+posicionY+document.body.scrollTop+ "px";
	document.getElementById('toolTipBox').style.left = x-2+posicionX+document.body.scrollLeft+"px";
	objeto.onmouseout = ocultarMensaje;
}
function ocultarMensaje() {
	document.getElementById('toolTipBox').style.display = "none";
}
//------------------------------------------------------------------------------------
//redireccionar a una pagina
//------------------------------------------------------------------------------------
function redireccionar(direccion){location.href = direccion;}

// Desplegar textbox - used by Roquet 

function txt(){
    var valor = document.getElementById('cmb').value;
    if(valor==1){ // Si
        document.getElementById('col1').style.display = "block";
        document.getElementById('col2').style.display = "block";
        document.getElementById('clave1').style.display = "block";
        document.getElementById('clave2').style.display = "block";      
        document.getElementById('clave1').value="";
        document.getElementById('clave2').value="";       
       
    }
    if(valor==2){ //No
        document.getElementById('col1').style.display = "none";
        document.getElementById('col2').style.display = "none";
        document.getElementById('clave1').style.display = "none";
        document.getElementById('clave2').style.display = "none";  
        document.getElementById('clave1').value=document.getElementById('claveoriginal').value;
        document.getElementById('clave2').value=document.getElementById('claveoriginal').value;
    }
}
