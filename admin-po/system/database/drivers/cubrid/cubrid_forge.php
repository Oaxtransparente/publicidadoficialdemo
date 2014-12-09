<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_DB_cubrid_forge extends CI_DB_forge {

	function _create_database($name)
	{
		return FALSE;
	}

	function _drop_database($name)
	{
		return FALSE;
	}

	function _process_fields($fields)
	{
		$current_field_count = 0;
		$sql = '';

		foreach ($fields as $field=>$attributes)
		{
			if (is_numeric($field))
			{
				$sql .= "\n\t$attributes";
			}
			else
			{
				$attributes = array_change_key_case($attributes, CASE_UPPER);

				$sql .= "\n\t\"" . $this->db->_protect_identifiers($field) . "\"";

				if (array_key_exists('NAME', $attributes))
				{
					$sql .= ' '.$this->db->_protect_identifiers($attributes['NAME']).' ';
				}

				if (array_key_exists('TYPE', $attributes))
				{
					$sql .= ' '.$attributes['TYPE'];

					if (array_key_exists('CONSTRAINT', $attributes))
					{
						switch ($attributes['TYPE'])
						{
							case 'decimal':
							case 'float':
							case 'numeric':
								$sql .= '('.implode(',', $attributes['CONSTRAINT']).')';
								break;
							case 'enum': 	// As of version 8.4.0 CUBRID does not support
											// enum data type.
											break;
							case 'set':
								$sql .= '("'.implode('","', $attributes['CONSTRAINT']).'")';
								break;
							default:
								$sql .= '('.$attributes['CONSTRAINT'].')';
						}
					}
				}

				if (array_key_exists('UNSIGNED', $attributes) && $attributes['UNSIGNED'] === TRUE)
				{
					//$sql .= ' UNSIGNED';
					// As of version 8.4.0 CUBRID does not support UNSIGNED INTEGER data type..
				}

				if (array_key_exists('DEFAULT', $attributes))
				{
					$sql .= ' DEFAULT \''.$attributes['DEFAULT'].'\'';
				}

				if (array_key_exists('NULL', $attributes) && $attributes['NULL'] === TRUE)
				{
					$sql .= ' NULL';
				}
				else
				{
					$sql .= ' NOT NULL';
				}

				if (array_key_exists('AUTO_INCREMENT', $attributes) && $attributes['AUTO_INCREMENT'] === TRUE)
				{
					$sql .= ' AUTO_INCREMENT';
				}

				if (array_key_exists('UNIQUE', $attributes) && $attributes['UNIQUE'] === TRUE)
				{
					$sql .= ' UNIQUE';
				}
			}

			// don't add a comma on the end of the last field
			if (++$current_field_count < count($fields))
			{
				$sql .= ',';
			}
		}

		return $sql;
	}

	function _create_table($table, $fields, $primary_keys, $keys, $if_not_exists)
	{
		$sql = 'CREATE TABLE ';

		if ($if_not_exists === TRUE)
		{
			//$sql .= 'IF NOT EXISTS ';
			// As of version 8.4.0 CUBRID does not support this SQL syntax.
		}

		$sql .= $this->db->_escape_identifiers($table)." (";

		$sql .= $this->_process_fields($fields);

		// If there is a PK defined
		if (count($primary_keys) > 0)
		{
			$key_name = "pk_" . $table . "_" .
				$this->db->_protect_identifiers(implode('_', $primary_keys));
			
			$primary_keys = $this->db->_protect_identifiers($primary_keys);
			$sql .= ",\n\tCONSTRAINT " . $key_name . " PRIMARY KEY(" . implode(', ', $primary_keys) . ")";
		}

		if (is_array($keys) && count($keys) > 0)
		{
			foreach ($keys as $key)
			{
				if (is_array($key))
				{
					$key_name = $this->db->_protect_identifiers(implode('_', $key));
					$key = $this->db->_protect_identifiers($key);
				}
				else
				{
					$key_name = $this->db->_protect_identifiers($key);
					$key = array($key_name);
				}
				
				$sql .= ",\n\tKEY \"{$key_name}\" (" . implode(', ', $key) . ")";
			}
		}

		$sql .= "\n);";

		return $sql;
	}

	function _drop_table($table)
	{
		return "DROP TABLE IF EXISTS ".$this->db->_escape_identifiers($table);
	}

	function _alter_table($alter_type, $table, $fields, $after_field = '')
	{
		$sql = 'ALTER TABLE '.$this->db->_protect_identifiers($table)." $alter_type ";
		if ($alter_type == 'DROP')
		{
			return $sql.$this->db->_protect_identifiers($fields);
		}

		$sql .= $this->_process_fields($fields);

		if ($after_field != '')
		{
			$sql .= ' AFTER ' . $this->db->_protect_identifiers($after_field);
		}

		return $sql;
	}

	function _rename_table($table_name, $new_table_name)
	{
		$sql = 'RENAME TABLE '.$this->db->_protect_identifiers($table_name)." AS ".$this->db->_protect_identifiers($new_table_name);
		return $sql;
	}

}
?>