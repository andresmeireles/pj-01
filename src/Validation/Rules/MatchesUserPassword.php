<?php 
namespace App\Validation\Rules;

use \Respect\Validation\Rules\AbstractRule;
use \App\Auth\Auth;
/**
* Regra para vereifca antiga senha posta pelo usuario checando se é igual a senha antiga no banco
*/
class MatchesUserPassword extends AbstractRule
{
	protected $password;

	/**
	 * Quando usamos as validações podemos mandar parametros nessa validação customizada.
	 * Atravez do metodo construtor capturamos esse paratro enviado
	 *
	 * @param string $password
	 */
	public function __construct($password) {
		$this->password = $password;
	}
	// O nome da classe se torna a regra a ser usada, por isso só ha um metodo dentro da classe chamado "validate"
	public function validate($input)
	{	
		$auth = new Auth;
		$currentPassword = $auth->userObj()->getPassword();
		return password_verify($input, $currentPassword);
	}	
}