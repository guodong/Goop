<?php
namespace Goop;
class Response
{

	private $content;

	private static $instance = NULL;

	public static function getInstance()
	{
		if (NULL === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function append($content)
	{
		$this->content .= $content;
	}

	public function send()
	{
		echo $this->content;
	}
}