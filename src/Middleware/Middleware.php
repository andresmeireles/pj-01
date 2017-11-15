<?php 
namespace App\Middleware;



class Middleware
{
	protected $container;
	
	function __construct($container)
	{
		$this->container = $container;
	}

	public function __get($dependency)
	{
		if ($this->container->{$dependency}) {
			return $this->container->{$dependency};
		}
	}
}