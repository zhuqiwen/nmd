<?php
	/**
	 *
	 */

	final class Application
	{
		public static $_config = NULL;
		public static $_lib = NULL;

		public static function init()
		{
			self::$_lib = [
				'route' => 'route.php',
				'mysql' => 'mysql.php',
				'template' => 'template.php',
			];

			require 'model.php';
			require 'controller.php';
		}

		public static function run($config)
		{
			self::$_config = $config['system'];
			self::init();
			foreach (self::$_lib as $key => $value)
			{
				require (self::$_lib[$key]);
				$lib = ucfirst($key);
				self::$_lib[$key] = new $lib;
			}
			$url_array = self::$_lib['route']->getUrlArray();
			self::routeToControllerAndModel($url_array);
		}


		public static function routeToControllerAndModel($url_array)
		{
			$app = '';
			$parameters = '';

			$controller = self::$_config['route']['default_controller'];
			$model = self::$_config['route']['default_controller'];
			$action = self::$_config['route']['default_action'];


			if(isset($url_array['app']))
			{
				$app = $url_array['app'];
			}
			if(isset($url_array['params']))
			{
				$params = $url_array['params'];
			}
			if(isset($url_array['action']))
			{
				$action = $url_array['action'];
			}


			if(isset($url_array['controller']))
			{
				$controller = $model = $url_array['controller'];
			}

			$controller_file = realpath(__DIR__ . '/../controller/' . $controller . 'Controller.php');
			$model_file = realpath(__DIR__ . '/../model/' . $model . 'Model.php');

			require $controller_file;
			require $model_file;

			$controller = $controller.'Controller';
			$controller = new $controller;

			isset($params) ? $controller ->$action($params) : $controller ->$action();

		}
	}