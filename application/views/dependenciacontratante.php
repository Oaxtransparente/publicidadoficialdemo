<!DOCTYPE html>
<html lang="sp">
<head>
	<meta charset="utf-8">
	<title>Dependencia contratante</title>
    
        <link type="text/css" href="<?php echo base_url(); ?>listado/css/style.css" rel="stylesheet" />
        <script type="text/javascript" src="<?php echo base_url(); ?>listado/js/jquery.js"></script>
        <script type="text/javascript" language="javascript">
        $(document).ready(function(){
		   $('#tabla_lista_dependencias_contratantes').dataTable( { 
		     "sPaginationType": "full_numbers" 
			 } );
		})
        </script>
        
        <link type="text/css" href="<?php echo base_url(); ?>listado/css/demo_table.css" rel="stylesheet" />
        <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>listado/js/jquery.dataTables.js"></script>        
        <script type="text/javascript" src="<?php echo base_url(); ?>treemap/d3.v3.min.js"></script>
        

</head>

<style type="text/css">

html, body{ 
color:#8D8D8D;
font-family:Arial;
font-size: 16px;
}

.tabladependencia td{	
	text-align:center;
	height:45px;
}

.tabladependencia .con_raya{	
	border-right: 1px solid #00B5E2;
}

.tabladependencia{
	background: url('<?php echo base_url(); ?>imagenes/linea.gif') repeat-x;
	background-position:bottom;
	padding-bottom:8px;
	margin-left:-2px;
}

.tabladependencia .rellenar_dependencia{
	background: #34A6B5;		
}

label{
	font-weight: bold;
}

#contenido a {
	color: #00B5E2;
	font-size:14px;
}

/*treemap*/
	#chart {
        width: 1200px;
        height: 420px;
        margin: 0px auto;
        position: relative;
        -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
                box-sizing: border-box;
				color:#fff;
				font-size:24px;
    }

    text {
        pointer-events: none;					
    }
    .grandparent text {    
        font-size: medium;
        font-family: Arial;
		padding-left:20px;
    }

    rect {
        fill: none;
        stroke: #fff;
				
    }

    rect.parent,
    .grandparent rect {
        stroke-width: 2px;		
    }

    .grandparent rect {
        fill: #7F7F7F;		 
    }

    .children rect.parent,
    .grandparent rect {
        cursor: pointer;
		
    }

    rect.parent {
        pointer-events: all; 
    }

    .children:hover rect.child,
    .grandparent:hover rect {
        fill: #aaa;
    }

    .textdiv { /* text in the boxes */
        font-size: small;
        padding: 10px;
        font-family:Arial; 
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

<div class="page" style="font-size:16px;">

<table width="95%" style="font-size:16px; margin-top:30px; height:30px;">
<tr>
<td width="20%">
<form action="<?php echo base_url()?>index.php/dependencias/cargar_contratante_por_anio/0" method="post">

Año

<select id="anio" name="anio" onchange="this.form.submit()">
<?php foreach($anios_dependencias->result() as $fila) { ?>		
        <option value="<?php echo $fila->anio?>" 
		<?php if($fila->anio==$anio) echo "selected" ?> ><?php echo $fila->anio?></option>        
<?php } ?>
</select>
</form>

</td>

<td width="75%" align="right">
<!---redes-->
</td>
</tr>
</table>

<br/>
<table width="100%">
<tr>
<td width="100%" align="right">
<?php if (isset($ultima_actualizacion)) { ?> Última actualización: <?php echo $ultima_actualizacion; } ?></td>
</tr></table>

<br/>

<table width="100%" class="tabladependencia" style="font-size:16px;"> 
<tr>
<td width="20%" class="rellenar_dependencia">
<div>
<a href="<?php echo base_url()?>index.php/dependencias/cargar/<?=$anio?>" style="color:#fff">
Dependencia contratante</a>
</div> </td>
<td width="20%">
<div>
<a href="<?php echo base_url()?>index.php/dependencias/cargar_solicitantes/<?=$anio?>" style="color:#8D8D8D">
Dependencia solicitante</a>
</div> </td>
<td width="60%"></td>
</tr>
</table>

<br/>
<?php  
$arreglo_colores = array("#00B5E2", "#005862", "#35A6B6" , "#05C8EA9", "#6DA8C6", "#345463", "#0D95C7"); 
$numero_colores=count($arreglo_colores);
$contador=0;
?>

			<p id="chart">
            <script type="text/javascript" src="<?php echo base_url(); ?>treemap/zoomable_treemap2.js"></script>
            </p>
            
            <br/>

			<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_lista_dependencias_contratantes" 
            style="margin-bottom:0px;">
                <thead>                	
                    <tr>
                        <th>Dependencia</th>
                        <th>Monto</th>
                        <th>Año</th>                        
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
                    foreach($dependencias_contratantes->result() as $fila)
                    { 
					?>
                               <tr>
  							   <td class="leftb"> 
                               <a href="../detalle_dependencia/<?php echo $fila->id_dependencia ?>/<?php echo $fila->anio?>">
  							   <?php echo mb_convert_encoding($fila->dependencia, "UTF-8") ?></a> </td>
                               <td class="leftb">$
							   <?php echo number_format($fila->monto)?> </td>
							   <td>
							   <?php echo $fila->anio ?> </td>
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



