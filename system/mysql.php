<?php
/**
 *
 */

final class Mysql
{
	private $db_host;
	private $db_user;
	private $db_password;
	private $db_database;
	private $conn;
	private $result;
	private $sql;


	public function init($db_host, $db_user, $db_password, $db_database)
	{
		$this->db_host = $db_host;
		$this->db_user = $db_user;
		$this->db_password = $db_password;
		$this->db_database = $db_database;
		$this->connect();
	}


	public function connect()
	{
		$this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_database);
	}

	public function conn()
	{
		return $this->conn;
	}

	public function query($query)
	{
		$this->sql = $query;
		$this->result = mysqli_query($this->conn, $this->sql);
		return $this->result;
	}

	public function prepare($query)
	{
		$this->sql = mysqli_prepare($this->conn, $query);
		return $this->sql;
	}

	public function beginTransaction()
	{
		return $this->query('START TRANSACTION');
	}


	public function commit()
	{
		return $this->query('COMMIT');
	}

	public function fetch_array()
	{
		return mysqli_fetch_array($this->result);
	}

	public function fetch_assoc()
	{
		return mysqli_fetch_assoc($this->result);
	}

	public function fetch_row()
	{
		return mysqli_fetch_row($this->result);
	}

	public function fetch_Object()
	{
		return mysqli_fetch_object($this->result);
	}

	public function fetch_all_assoc()
	{
		return mysqli_fetch_all($this->result, MYSQLI_ASSOC);
	}

	public function fetch_all_array()
	{
		return mysqli_fetch_all($this->result);
	}

	public function fetch_columns($table)
	{
		$this->query("SELECT * FROM $table LIMIT 1");
		return mysqli_fetch_fields($this->result);
	}

	public function all($table)
	{
		$this->query("SELECT * FROM $table");
	}

	public function get($table, $columnName = "*", $condition = '', $joins = [])
	{
		$condition = $condition ? ' Where ' . $condition : NULL;
		$join = '';
		foreach ($joins as $join_table => $on)
		{
			$join .= ' JOIN ' . $join_table . ' ON ' . $on;

		}
		$query = "SELECT $columnName FROM $table $join $condition";

		return $this->query($query);
	}

	public function delete($table, $condition)
	{
		return $this->query("DELETE FROM $table WHERE $condition");
	}

	public function insert($table, $columnName, $value)
	{
		return $this->query("INSERT INTO $table ($columnName) VALUES ($value)");
	}

	public function update($table, $mod_content, $condition)
	{
		$query ="UPDATE $table SET $mod_content WHERE $condition";
		return $this->query($query);
	}

	public function truncate($table)
	{
		$query ="TRUNCATE TABLE $table;";
		return $this->query($query);
	}

	public function insert_id()
	{
		return mysqli_insert_id($this->conn);
	}




}