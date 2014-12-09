<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link rel="stylesheet" media="all" type="text/css" href="<?php echo base_url(); ?>css/estilo.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>ajax/ajaxs.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>calendario-jquery/calendario_dw/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>ajax/paraimagen.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>calendario-jquery/jquery.form.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>calendario-jquery/prettyForms.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>calendario-jquery/jquery-ui-1.8.6.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>calendario-jquery/jquery.ui.datepicker-es.js"></script>

<script type="text/javascript">     
   function validar_formulario(){	   	   	  																							   	  												   		   
   		if(document.getElementById('campas').value!='seleccione'){	   	   	  																							   	  	      $("#form1").submit();  														
	   	}
	   	else{
		   alert('seleccione campaña');
	   	}  														
   }      
   
</script>

<title>Nuevoa Audio</title>
</head>
<body>

<div class="grocery">
<h2> Ingrese el nuevo audio para la campaña "<?php foreach($campas->result() as $fila) { echo $fila->nombre; }?>" </h2><br/>


<table width="100%">
<form id="form1" method="post" enctype="multipart/form-data" action='<?php echo base_url();?>index.php/audios/guardar'>
<tr><td valign="top" width="20%">Campaña: </td><td>
<select id="campas" name="campas" style="width:155px; margin-bottom:15px;">
<?php foreach($campas->result() as $fila) { ?>		
        <option value="<?php echo $fila->nombre?>"><?php echo $fila->nombre?></option>        
<?php } ?>
</select>
</td></tr>
</form>
 
<form id="audioform" method="post" enctype="multipart/form-data" action='<?php echo base_url();?>ajax/ajaxnuevoaudio.php'>
<tr><td valign="top" width="20%">Audio:</td><td>


<input id="agregar_audio" name="agregar_audio" type="file" />
<div id="previewaudio" name="previewaudio">
</div>
</td></tr></table>

</form>

<input type="submit" value="Guardar audio" onClick="validar_formulario()" style="margin-right:20px;" class="boton"/>
<input type="button" onclick=" location.href='<?php echo base_url();?>/index.php/audios/principal/<?php echo $id;?>' " value="Cancelar" class="boton" /> 


</div>
            
</body>
</html>