<?php 
namespace App\Validation\Rules;

use \Respect\Validation\Rules\AbstractRule;
use \App\Entity\User;
/**
* Regra para verificar se existe o email citado na base de dados
* se o resultado de validate for true, então a verificação passará, caso contrario sera disparado erro.
*/
class EmailAvailable extends AbstractRule
{
	// O nome da classe se torna a regra a ser usada, por isso só ha um metodo dentro da classe chamado "validate"
	public function validate($input)
	{
		require __DIR__.'/../../../config/bootstrap.php';
		return count($entityManager->getRepository(User::class)->findBy(['userEmail' => $input])) == 0;
	}	
}