<?php
include "../../librerias/cabecera.php";
$tipo=$_SESSION['TYPEUSER'];
?>
<center>
 
  <form id="form1" name="form1" method="post" action="">
    <?php
    if ($tipo==1 OR $tipo==2 OR $tipo==3)
    {
    echo '<img src="../../imagenes/inicioadministrador.png" width="628" height="350" alt="InicioAdmin" />
     </form>';   
    }
    else if ($tipo==4)
    {
    echo '<img src="../../imagenes/iniciotutores.png" width="628" height="350" alt="InicioTutores" />
     </form>';     
    }
    else if ($tipo==5)
    {
    echo '<img src="../../imagenes/inicioinstituciones.jpg" width="628" height="350" alt="InicioInstituciones" />
     </form>';    
    }
    else if ($tipo==6)
    {echo '<img src="../../imagenes/inicioalumnos.png" width="628" height="350" alt="InicioAlumnos" />
     </form>';
    
    }
    else
    {echo '<img src="../../imagenes/Bienvenidos.jpg" width="382" height="73" alt="Bienvenido" /></br><img src="../../imagenes/UPSJurisprudencia.jpg" width="628" height="162" alt="Servicio Social" />';   
    ?>
    <p>&nbsp;</p>
    </form>
    <hr />
</center>
<strong></strong>
 <!-- inicio contador, contador anterior:53720 idmywebacces:53725 -->
<center><b>Visitas:</b><br><img style="border: 0px solid; display: inline;" alt="contador de visitas" src="http://www.websmultimedia.com/contador-de-visitas.php?id=126060"><br></center>
<!-- fin codigo contador -->

<?php
    }
include "../../librerias/pie.php";
?>
