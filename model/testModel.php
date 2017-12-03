<?php
/**
 *
 */

class testModel extends Model
{
	public function getAll($table)
	{
		$this->db->all($table);
		return $this->db->fetch_all_assoc();
	}

	public function get($table, $columnName = "*", $condition = '', $joins = [])
	{
		$this->db->get($table, $columnName, $condition , $joins);
		return $this->db->fetch_all_assoc();

	}

	public function update($table, $record = [])
	{
		$id = $record['id'];
		$mod_content = '';
		$cnt = sizeof($record);
		foreach ($record as $attribute => $value)
		{
			if($attribute != 'id')
			{
				$mod_content .= "$attribute='$value'";
				if($cnt == 1)
				{
					$mod_content .= " ";
				}
				else
				{
					$mod_content .= ", ";
				}

			}
			$cnt --;
		}
		$pk = $table . '.id';
		$condition = "$pk=$id";
		return $this->db->update($table, $mod_content, $condition);

	}

	public function delete($table, $id)
	{
		$condition = $table . ".id = " . $id;
		return $this->db->delete($table, $condition);
	}

	public function import($schools_array, $degrees_array)
	{

		if($this->importSchools($schools_array))
		{
			return $this->importDegrees($degrees_array);
		}

		return FALSE;


	}

	private function importSchools($schools_array)
	{
		$query = "INSERT INTO schools (school) VALUES (?)";
		$statement = $this->db->prepare($query);
		$statement->bind_param('s', $school);

		$this->db->beginTransaction();
		foreach ($schools_array as $school)
		{
			$statement->execute();
		}
		$statement->close();
		return $this->db->commit();


	}

	private function importDegrees($degrees_array)
	{
		$query = "INSERT INTO degrees (name, school_id, link, bp, mp, dp) VALUES (?, ?, ?, ?, ?, ?)";
		$statement = $this->db->prepare($query);
		$statement->bind_param('sissss', $name, $school_id, $link, $bp, $mp, $dp);

		$this->db->beginTransaction();
		foreach ($degrees_array as $degree)
		{

			$school = $degree['school'];
			if($school == '')
			{
				$school = '--';
			}
			$condition = "school='$school'";
			$this->db->get('schools', 'id', $condition);
			$school_id = $this->db->fetch_assoc()['id'];
			$name = $degree['name'];
			$link = $degree['link'];
			$bp = $degree['bp'];
			$mp = $degree['mp'];
			$dp = $degree['dp'];

			if($bp == '')
			{
				$bp =NULL;
			}

			if($mp == '')
			{
				$mp =NULL;
			}

			if($dp == '')
			{
				$dp =NULL;
			}


			$statement->execute();
		}
		$statement->close();
		return $this->db->commit();

	}

	public function truncate($table)
	{
		return $this->db->truncate($table);
	}

	public function fetch_columns($table)
	{
		return $this->db->fetch_columns($table);
	}

	public function search($conditions, $columns_to_return = [], $tables = [])
	{
		// I know this is ugly and sorry!
		$query = "SELECT degrees.id, degrees.school_id, $columns_to_return FROM degrees JOIN schools ON degrees.school_id = schools.id WHERE $conditions";

		$this->db->query($query);
		return $this->db->fetch_all_assoc();
	}
}