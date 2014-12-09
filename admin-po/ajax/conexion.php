<?php  
class Conexion 
{	
	protected $DB_SERVIDOR = 'server';
	protected $DB_USUARIO  = 'user';	
	protected $DB_PASSWORD = 'password';
	protected $DB_NOMBRE= '';
	
	
	public function conecta()
	{
		 $db = mysql_connect($this->DB_SERVIDOR, $this->DB_USUARIO, $this->DB_PASSWORD);
		  mysql_select_db($this->DB_NOMBRE, $db);
		 return $db;
	}	
}

?>
