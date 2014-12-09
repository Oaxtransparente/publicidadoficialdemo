<?php
require_once('conexion.php');
$conexion=new Conexion();
$db = $conexion->conecta(); 
mysql_query("SET CHARACTER SET utf8 ");

	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$audio = $_POST['audio'];
			$descripcion_audio= $_POST['descripcion_audio'];
			$audios="<table> 
			           <tr>";
			$audios_borrar="<table> 
			                  <tr>";
						
									mysql_query("insert into tp_audios_campa_temp (campa,audio,descripcion_audio) 
									values (0,'$audio','$descripcion_audio')", $db);
						
									$sql="select id_audio, audio from tp_audios_campa_temp";									
									$Rec = mysql_query($sql, $db);
									$total = mysql_num_rows($Rec);					
									$Reg = mysql_fetch_assoc($Rec);	 
									$i=1;
									do{																												
													
										$audios=$audios.'
										<td>
										<iframe width="120" height="120" 
										src="'.$Reg['audio'].'" frameborder="0" allowfullscreen></iframe> 
										</td>';

										$audios_borrar=$audios_borrar.'
										<td>
										<a style="margin-right:95px;" class="eliminar_audio" href="javascript:void(0);" 
										data-id="'.$Reg['id_audio'].'">Borrar</a>
										</td>';	
                            
										
										if($i%9==0){
											$audios = $audios."<br/>";
										}
										
										$i++;
									}while ($Reg = mysql_fetch_assoc($Rec) );
															
									$audios=$audios."</tr> </table>";	
									$audios_borrar=$audios_borrar."</td> </table>";
									$audios=$audios.$audios_borrar;
									exit;
									
		}
?>