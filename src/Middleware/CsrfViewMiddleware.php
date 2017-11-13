<?php 
namespace App\Middleware;
/**
* 
*/
class CsrfViewMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{	
		// criação de verificaores de csrf
		$this->renderer->getEnvironment()->addGlobal('csrf', array(

			'field' => '
				<input type="hidden" id="tname" name="'. $this->csrf->getTokenNameKey() .'" value="'. $this->csrf->getTokenName() .'">
				<input type="hidden" id="tvalue" name="'. $this->csrf->getTokenValueKey() .'" value="'. $this->csrf->getTokenValue() .'">
			',

		));
		
		$response = $next($request, $response);	
		//$response = $response->withAddedHeader('X-CSRF-Token', 'ninja');
		return $response;
	}
}