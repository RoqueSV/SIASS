<?php
//rellena con espacios en blanco una cadena con $n espacios con una alineacion i
function rellenar($cad,$n,$alineacion)
	{
	    switch($alineacion)
	    {
	      case "i":
		   $tipo = STR_PAD_LEFT;
	      break;

	      case "d":
		   $tipo = STR_PAD_RIGHT;
	      break;
	    }
	   
	    return str_pad($cad, $n," ", $tipo);
	}//rellenar()


	/*
	Nombre: fecha2letra
	Descripcion: 	Recibe un string con el formato de una fecha (2012-10-23) y devuelve en texto 
					la misma fecha con el siguiente formato: "Martes 23 de Octubre del 2012" (con $num igual a 1)
					si $num es igual a 2 el texto devuelto es "Octubre del 2012".
	Autor: LPaulino
	Contacto: rgijeru@gmail.com
	*/
	function fecha2letra($fecha,$num)
	{
	$test = new DateTime($fecha);
	$f=date_timestamp_get ($test);

	$dias=array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
	$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	if($num==1){
	$fecha = $dias[date('w',$f)]." ".strftime("%d de ".$meses[date('n',$f)-1]." del %Y",$f);
	return $fecha;
	}
	
	if($num==2){
	$fecha2=strftime($meses[date('n',$f)-1]." del %Y",$f);
	return $fecha2;
	}
		
	}//fecha2letra()

?>
