<?php
namespace App\Controller;

use Slim\Views\Twig;

class Controller
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __get($container)
    {
    	if ($this->container->{$container}) {
    		return $this->container->{$container};
    	}
    }
}