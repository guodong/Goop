<?php

namespace Goop\Config;

use Goop\Config;

class View
{

	private $disableLayout = true;

	public function __construct(array $config)
	{
		$this->disableLayout = $config['layout']['disable'];
	}
	
	public function getDisableLayout()
	{
		return $this->disableLayout;
	}


}