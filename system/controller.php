<?php
/**
 *
 */

class Controller
{
	public function __construct()
	{
	}

	final protected function model($model)
	{
		$model_name = $model . 'Model';

		return new $model_name;
	}


	final protected function load($lib)
	{
		return Application::$_lib[$lib];
	}

	final protected function config($config)
	{
		return Application::$_config[$config];
	}


	final protected function showView($template_name, $data = [])
	{
		$template = $this->load('template');
		$template->init($template_name, $data);
		$template->outPut();
	}
}