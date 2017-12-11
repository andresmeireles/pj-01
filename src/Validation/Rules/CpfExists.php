<?php
namespace App\Validation\Rules;

use \Respect\Validation\Rules\AbstractRule;
use \App\Validation\ValidatorJson;
class CpfExists extends AbstractRule 
{
	protected $em;

	public function __construct($n) 
	{
		$r = new ValidatorJson($this);
		dump($n, $r->dep->em);	 
		die('morreu');
	}

	public function validate($input) 
	{

		$em = $this->em;
		$getRepository = $em->getRepository(EnterpriseCustomer::class);
		$cpf = $getRepository->findBy(['customerCPF' => $input]);
		
		if ($cpf) {
			return false; 
		}		

		return true;
	}
}
