<?php
/**
 *
 */

final class Route
{
	public $url_query;
	public $route_url = [];

	public function __construct()
	{
		$this->url_query = parse_url($_SERVER['REQUEST_URI']);
	}

	public function getUrlArray()
	{
		$this->queryToArray();

		return $this->route_url;
	}

	public function queryToArray(){
		$query_array = !empty ($this->url_query['query']) ?
			explode('&', $this->url_query['query']) :
			[];

		if(count($query_array) > 0)
		{
			$this->assignQuery($query_array);
		}
	}

	private function assignQuery($query_array)
	{
		$array = [];
		foreach ($query_array as $query)
		{
			$temp = explode('=', $query);
			$array[$temp[0]] = $temp[1];
		}

		if (isset($array['app']))
		{
			$this->route_url['app'] = $array['app'];
			unset($array['app']);
		}
		if (isset($array['controller']))
		{
			$this->route_url['controller'] = $array['controller'];
			unset($array['controller']);
		}
		if (isset($array['action']))
		{
			$this->route_url['action'] = $array['action'];
			unset($array['action']);
		}
		if(count($array) > 0)
		{
			$this->route_url['params'] = $array;
		}
	}

}

