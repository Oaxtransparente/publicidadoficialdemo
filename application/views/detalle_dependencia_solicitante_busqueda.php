<!DOCTYPE html>
<html lang="sp">
<head>
	<meta charset="utf-8">
	<title>Detalle dependencia solicitante busqueda</title>
        <link type="text/css" href="<?php echo base_url(); ?>listado/css/style.css" rel="stylesheet" />
        <script type="text/javascript" src="<?php echo base_url(); ?>listado/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>listado/js/funcionesdependenciasolicitantebusqueda.js"></script>
        <link type="text/css" href="<?php echo base_url(); ?>listado/css/demo_table.css" rel="stylesheet" />
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>listado/js/jquery.dataTables.js"></script>
        
        <script type="text/javascript">
        $(document).ready(function(){
		   $('#tabla_lista_campas_dependencia_solicitante_busqueda').dataTable( { 
				"sPaginationType": "full_numbers" 
			} );
		})
	</script>
</head>

<style type="text/css">

html, body{ 
color:#8D8D8D;
font-family:Arial;
font-size: 14px;
}

.tabladetalledependencia td{
	width:50%;
	text-align:center;
	height:100px;
}

.tabladetalledependencia .con_raya{	
	border-right: 1px solid #00B5E2;
}

.letra{	
	font-weight: bold;
}

.letra_azul{	
	font-weight: bold;
	color:#00B5E2;
}

.numero{	
	color:#00B5E2;
	font-size:45px;
}

#contenido a {
	color: #00B5E2;
	font-size:14px;
}

.volver{
	background: url('<?php echo base_url(); ?>imagenes/volver.gif') no-repeat;
	width:80px;
	height:28px;
	border:none;
	cursor: pointer;
	*cursor: hand;
}

</style>

<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1&appId=601013836595770";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<br/><br/>

<div class="page">

<table width="100%">
<tr>
<td width="20%">
<input type="button" value="" class="volver" onclick="history.back()" /> </td>
<td width="80%" align="right">
</td>
</tr>
</table>

<br/><br/>

<label class="letra_azul"> <?php echo $nombre_dependencia; ?> </label> 
<br/><br/>

<table width="100%" class="tabladetalledependencia"> 
<tr>
<td class="con_raya"> 
<label class="letra"> Campañas </label> <br/> solicitadas <br/> 
<label class="numero"> <?php echo $numero_campas; ?> </label> 
</td> 
<td> 
<label class="letra"> Gasto </label> <br/> total <br/>
<label class="numero"> $<?php echo number_format($monto_gastado); ?> </label> 
</td>
</tr>
</table>

<br/>

           <table cellpadding="0" cellspacing="0" border="0" class="display" 
           id="tabla_lista_campas_dependencia_solicitante_busqueda" style="margin-bottom:0px;">
                <thead>                	
                    <tr>
                        <th>Nombre de la campaña</th>
                        <th>Año</th>
                        <th>Cobertura</th>
                        <th>Monto</th>                        
                    </tr>
                </thead>
                <tfoot>               
                    <tr>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                  <tbody>
                  <div style="margin-bottom:0px;" > </div>                                                                                            
                   <?php     
                   foreach($campas_dependencias_busqueda->result() as $fila)
                   { ?>
                               <tr>
                               <td class="leftb"> 
                               <a href="../../campas/detalle_campa/<?php echo $fila->id_campa; ?> ">
							   <?php echo mb_convert_encoding($fila->nombre, "UTF-8"); ?></a> </td>
                               <td class="leftb">
							   <?php echo mb_convert_encoding($fila->anio, "UTF-8"); ?></td>
							   <td class="leftb">
							   <?php echo mb_convert_encoding($fila->tipo, "UTF-8"); ?></td>
							   <td>$
							   <?php echo number_format($fila->monto_campa); ?></td>								
                               </tr>                     
                    <?php    
					}
                    ?>
                </tbody>
            </table>

</div>
<br/>

</body>
</html>