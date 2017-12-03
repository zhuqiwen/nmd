<?php

/**
 * Class testController
 */
class testController extends Controller
{
	private $model;
	private $all_text_columns =[];

	public function __construct()
	{
		parent::__construct();
		$this->model = $this->model('test');
		$this->get_all_text_columns(['degrees', 'schools']);
	}

	private function get_all_text_columns($tables = [])
	{
		$columns = [];
		foreach ($tables as $table)
		{
			$tmp = $this->model->fetch_columns($table);
			$columns = array_merge($columns, $tmp);
		}


		foreach ($columns as $column)
		{
//			// make sure they are all text / string fields
			if($column->type == 252 || $column->type == 253 || $column->type == 254)
			{
				$this->all_text_columns[] =$column->table . '.' . $column->orgname;
			}
		}

	}

	public function index()
	{
		$data['test'] = "new media developer test ";
		$data['schools'] = $this->model->getAll('schools');
		$data['academic_levels'] = [
			'bp' => 'Bachelor',
			'mp' => 'Master',
			'dp' => 'Doctoral',
		];
		$joins = [
			'schools' => 'schools.id = degrees.school_id',
		];

		$data['programs'] = $this->model->get('degrees', 'degrees.*, schools.school', '', $joins);
		$this->showView('test', $data);
	}

	public function update()
	{
		parse_str(file_get_contents("php://input"),$putData);
		echo json_encode($this->model->update('degrees', $putData));
	}

	public function handleFileUpload()
	{
		$xml = simplexml_load_file($_FILES['xml_data']['tmp_name']);
		echo json_encode($xml);
	}

	public function import()
	{
		$degrees = [];
		$schools = [];
		$data = json_decode($_POST['degrees'], TRUE);
		foreach ($data as $degree)
		{
			$degrees[] = $degree;
			if($degree['school'] == '')
			{
				$schools[] = '--';
			}
			else
			{
				$schools[] = $degree['school'];
			}
		}

		$schools = array_unique($schools);

		if($this->model->import($schools, $degrees))
		{
			echo 'data import succeeded';
		}
		else
		{
			echo 'data import failed';
		}
	}

	public function wipe()
	{
		$this->model->truncate('degrees');
	}

	public function search()
	{
		$incoming = $_GET;
		unset($incoming['controller']);
		unset($incoming['action']);
		$condition_columns = $this->getTextSearchCondition($incoming);
		echo json_encode($this->model->search(
			$condition_columns['conditions'],
			$condition_columns['columns_to_return'],
			['degrees, schools']
		));

	}

	public function delete()
	{
		parse_str(file_get_contents("php://input"),$deleteData);

		$id = $deleteData['id'];
		echo $this->model->delete('degrees', $id);
	}

	private function getTextSearchCondition($incoming)
	{
		$q = array_pop($incoming);
		$conditions = '';
		$columns = $this->all_text_columns;
		$cnt = sizeof($columns);
		foreach ($columns as $column)
		{
			$conditions .= "$column LIKE '%$q%'";
			if($cnt != 1)
			{
				$conditions .= ' OR ';
			}
			else
			{
				$conditions .= '';
			}
			$cnt --;
		}
		$columns_to_return = $this->getColumnsToReturn($this->all_text_columns);

		return compact('conditions', 'columns_to_return');
	}

	private function getColumnsToReturn($all_text_columns)
	{
		$columns = $all_text_columns;
		$columns_to_return = '';
		$cnt = sizeof($columns);
		foreach ($columns as $column)
		{
			$columns_to_return .= " $column";

			if($cnt != 1)
			{
				$columns_to_return .= ', ';
			}
			else
			{
				$columns_to_return .= '';
			}
			$cnt --;
		}

		return $columns_to_return;
	}

}
