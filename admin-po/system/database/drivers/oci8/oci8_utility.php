<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_DB_oci8_utility extends CI_DB_utility {

	function _list_databases()
	{
		return FALSE;
	}

	function _optimize_table($table)
	{
		return FALSE; // Is this supported in Oracle?
	}

	function _repair_table($table)
	{
		return FALSE; // Is this supported in Oracle?
	}

	function _backup($params = array())
	{
		// Currently unsupported
		return $this->db->display_error('db_unsuported_feature');
	}
}
?>