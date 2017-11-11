<?php 
namespace App\Middleware;
/**
* 
*/
class OldInfoMiddleware extends Middleware
{
	public function __invoke($request, $response, $next)
	{
		$this->renderer->getEnvironment()->addGlobal('old', $_SESSION['old']);
		$_SESSION['old'] = $request->getParams();

		$response = $next($request, $response);
		return $response;
	}
}