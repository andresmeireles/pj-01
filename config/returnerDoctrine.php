<?php 
namespace Config\Returner;

use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;
use \Dotenv\Dotenv;


function doctrineFactory() {

	$dotenv = new Dotenv(__DIR__.'/..');
	$dotenv->load();

	require __DIR__."/../vendor/autoload.php";
	$settings = require __DIR__.'/../src/settings.php';
	$settings = $settings['settings']['doctrine'];

	$path = array($settings['entity_path']);
	$isDevMode = true;

	$dbParams = $settings['dbparams'];

	$config = Setup::createAnnotationMetadataConfiguration($path, $isDevMode);
	$entityManager = EntityManager::create($dbParams, $config);

	return $entityManager;	
}