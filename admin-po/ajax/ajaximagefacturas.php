<?php
require_once('conexion.php');
$conexion=new Conexion();
$db = $conexion->conecta(); 
mysql_query("SET CHARACTER SET utf8 ");
			
session_start();
$path = "../archivos/imagenes_factura/";

	$valid_formats = array("jpg", "png", "gif", "bmp");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];									
			
			$imagenes="<table> <tr>";
			$imagenes_borrar="<table> <tr>";
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(1024*1024))
						{
							$actual_image_name = time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if(copy($tmp, $path.$actual_image_name))
								{																	
									
									mysql_query("insert into tp_imagenes_factura_temp (id_factura,imagen) 
									values (0,'$actual_image_name')", $db);
						
									$sql="select id_imagen_factura, imagen from tp_imagenes_factura_temp";									
									$Rec = mysql_query($sql, $db);
									$total = mysql_num_rows($Rec);					
									$Reg = mysql_fetch_assoc($Rec);	 
									$i=1;
									do{										
									
									$imagenes = $imagenes.'
									<td> 
									<img src="../../archivos/imagenes_factura/'.$Reg['imagen'].'" class="preview" > 
									</td>';

									$imagenes_borrar=$imagenes_borrar.'
									<td>
									<a style="margin-right:95px;" class="eliminar_imagen_factura" href="javascript:void(0);"
									onclick="eliminar_imagen_factura('.$Reg['id_imagen_factura'].')" >Borrar</a>
									</td>';                             
										
										if($i%9==0){
											$imagenes = $imagenes."<br/>";
										}
										
										$i++;
									}while ($Reg = mysql_fetch_assoc($Rec) );
									
									$imagenes=$imagenes."</tr> </table>";	
									$imagenes_borrar=$imagenes_borrar."</td> </table>";
									$imagenes=$imagenes.$imagenes_borrar;					
									echo $imagenes;																		
								}
							else
								echo "Fallo proceso";
						}
						else
							echo "Tamaño de imagen max 1 MB";					
						}
						else
							echo "Formato de archivo invalido..";	
				}
				
			else
				echo "Por favor seleccione una imagen..!";				
			exit;
									
		}
?>