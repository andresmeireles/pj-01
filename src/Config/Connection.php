<?php
namespace App\Config;

use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;
use \Dotenv\Dotenv;
/**
* 
*/
class Connection
{
	private $settings;

	const DEV_MODE = true;

	public function __construct()
	{
		$this->settings = require __DIR__.'/../settings.php';
	}

	public function connect() 
	{
		$settings = $this->settings['settings']['doctrine'];
		$config = $this->getConfig($settings);
		$dbParams = $settings['dbparams'];
		$entityManager = EntityManager::create($dbParams, $config);
		return $entityManager;
	}

	private function getConfig(array $settings)
	{
		$path = array($settings['entity_path']);
		$isDevMod = DEV_MODE;

		$config = Setup::createAnnotationMetadataConfiguration($path, $isDevMode);

		return $config;
	}
}