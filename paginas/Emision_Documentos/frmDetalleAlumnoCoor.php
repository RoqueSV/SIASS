<?php
include "../../librerias/cabecera.php";
include "../../librerias/abrir_conexion.php";

/* Bloque seguridad */
if (!(isset($_SESSION['TYPEUSER']))) {
header("Location: ../../paginas/Inicio/frmAccesoDenegado.php");
exit(); 
}
else if (!($_SESSION['TYPEUSER']==2)) {
session_destroy();
header("Location: ../../paginas/Inicio/frmAcceso.php");
exit();    
}
 /* **********    */


$query="select  nombrealumno||' '||apellidosalumno nomalumno, carnet, p.idproyecto, nomproyecto, nombredocente, iniciotutoria,fintutoria,estadoalumnoproyecto,
horas, revision
from alumno a
join alumno_proyecto ap on a.idalumno=ap.idalumno
join proyecto p on ap.idproyecto=p.idproyecto
join se_convierte sc on p.idproyecto=sc.idproyecto
join propuesta_proyecto pp on sc.idpropuesta=pp.idpropuesta
join tutoria t on p.idproyecto=t.idproyecto
join docente d on t.iddocente=d.iddocente
join tutoria_alumno ta on (t.idtutoria=ta.idtutoria and ta.idalumno=a.idalumno)
where a.idalumno=".$_GET['id']." order by 1;";
$resul = pg_query($query) or die ("<SPAN CLASS='error'>Fallo en consulta!!</SPAN>".pg_last_error());
$row = pg_fetch_array($resul);
$nombrealumno=$row['nomalumno'];
$carnet=$row['carnet'];

?>

<style>.tinytable{width: 80%;}</style>
<h2 align="center">DETALLES DE ALUMNO</h2>

	<table  align="center" width="100%" border="0" >
	<tr>
        <td align="center">
            <b>Carnet: </b><?php echo $carnet; ?>
                &nbsp; &nbsp;
            <b>Alumno: </b><?php echo $nombrealumno; ?>
        </td> 
        </tr>
        </table>
        <table class='tinytable' align='center'>
		
                
                <thead><tr><th colspan='6'><h3>INFORMACION PROYECTO</h3></tr></thead>
		<tr><td width='35%'><b>Proyecto</b></td><td  width='25%'><b>Docente</b></td><td width='10%'><b>Horas</b></td><td width='10%'><b>Estado</b></td><td width='25%' colspan='2'><b>Revisar documentos</b></td></tr>
		
                <?php
		pg_result_seek($resul,0);
		while($row=pg_fetch_array($resul)){
                /* ********** */
                $querydoc1="select d.iddocumento from documento d join alumno_documento ad on (d.iddocumento=ad.iddocumento) where idalumno=".$_GET['id']." and idproyecto= ".$row['idproyecto']." and tipodocumento='M';";
                $documentoM=pg_query($querydoc1);
                $memoria=  pg_fetch_array($documentoM);
                
                /* ********* */
                $querydoc2="select d.iddocumento from documento d join alumno_documento ad on (d.iddocumento=ad.iddocumento) where idalumno=".$_GET['id']." and idproyecto= ".$row['idproyecto']." and tipodocumento='P';";
                $documentoP=pg_query($querydoc2);
                $plan=  pg_fetch_array($documentoP);
		
                /* ******** */
                ?>
                <tr><td><?php echo $row['nomproyecto']; ?></td><td><?php echo $row['nombredocente']; ?></td><td><?php echo $row['horas']; ?></td><td>
		<?php                
		if($row['revision']<=0||$row['revision']>3)
		echo "Error. Tutor no aprob&oacute;";
				
		if($row['revision']==1)
		echo "Aprob&oacute; Tutor";
				
		if($row['revision']==2)
		echo "Aprob&oacute; Coordinador";
		?>		
		</td>
                <td><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../Alumno/frmVerActividadesAlumno.php?idalum=<?php echo $_GET['id']; ?>&iddoc=<?php echo $memoria[0]; ?>&op=<?php echo $_GET['op']; ?>'">Memoria</a></td>
                <td><a href="javascript:void(0)" onclick="parent.PRINCIPAL.location.href='../Alumno/frmVerActividadesAlumno.php?idalum=<?php echo $_GET['id']; ?>&iddoc=<?php echo $plan[0]; ?>&op=<?php echo $_GET['op']; ?>'">Plan</a></td>
                </tr>
                <?php
                }
		pg_result_seek($resul,0); // Inicio de nuevo para mandar los datos del form
                $row=  pg_fetch_array($resul);
		?>	
		</table>
        <br/>
        <form method="post" <?php echo "action=\"../../archivosphp/ManttoAlumnoProyectoCoor.php?id=".$_GET['id']."\""?> >
        <input type="hidden" name="estado" id="estado" value="<?php echo $row['estadoalumnoproyecto']?>" >
        <center>
        <input type="submit" class="buton" name="Aprobar" value="Aprobar"  style="width: 150px" />
        <?php
        if ($_GET['op']==1)
        echo '<input type="button" class="buton" name="Regresar" value="Regresar"  style="width: 150px" onclick="document.location.href=\'frmEmisionDocParcCoor.php\'"/>';
	else
        echo '<input type="button" class="buton" name="Regresar" value="Regresar"  style="width: 150px" onclick="document.location.href=\'frmEmisionDocCertCoor.php\'"/>';    
        ?>
        </center>
</form>
<?php
include "../../librerias/pie.php";
include "../../librerias/cerrar_conexion.php";
?>
