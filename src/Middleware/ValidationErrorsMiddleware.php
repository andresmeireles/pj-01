<?php 
namespace App\Middleware;

use App\Middleware\Middleware;
/**
* 
*/
class ValidationErrorsMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{	
		// catch form errors
		if (isset($_SESSION['errors'])) {
			$this->renderer->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
			unset($_SESSION['errors']);
		}

		$response = $next($request, $response);

		return $response;
	}	
}