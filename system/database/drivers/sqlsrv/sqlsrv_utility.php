<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_DB_sqlsrv_utility extends CI_DB_utility {

	function _list_databases()
	{
		return "EXEC sp_helpdb"; // Can also be: EXEC sp_databases
	}

	function _optimize_table($table)
	{
		return FALSE; // Is this supported in MS SQL?
	}

	function _repair_table($table)
	{
		return FALSE; // Is this supported in MS SQL?
	}

	function _backup($params = array())
	{
		// Currently unsupported
		return $this->db->display_error('db_unsuported_feature');
	}

}
?>