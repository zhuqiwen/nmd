<?php
	/**
	 *
	 */

	class Model
	{
		protected $db = NULL;

		final public function __construct()
		{
			header('Content-type:text/html;chartset=utf-8');
			$this->db = $this->load('mysql');
			$config_db = $this->config('db');
			$this->db->init(
				$config_db['db_host'],
				$config_db['db_user'],
				$config_db['db_password'],
				$config_db['db_database']
			);
		}

		final protected function table($table_name)
		{
			return $table_name;
		}


		final protected function load($lib)
		{
			return Application::$_lib[$lib];
		}

		final protected function config($config = '')
		{
			return Application::$_config[$config];
		}



	}