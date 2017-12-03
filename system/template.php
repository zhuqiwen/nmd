<?php
/**
 *
 */

final class Template
{
	public $template_name = NULL;
	public $data = NULL;
	public $out_put = NULL;

	public function init($template_name,$data = []) {
		$this->template_name = $template_name;
		$this->data = $data;
		$this->fetch();
	}

	public function fetch() {
		$view_file = realpath(__DIR__ . '/../view/' . $this->template_name . '.php');
		extract($this->data);
		ob_start();
		include $view_file;
		$content = ob_get_contents();
		$this->out_put = $content;
//		ob_end_clean();

	}

	public function output()
	{
		return $this->out_put;
	}
}