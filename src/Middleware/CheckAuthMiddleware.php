<?php 
namespace App\Middleware;
/**
 * CheckAuthMiddleware: Middleware responsavel por verificar se o usuario está logado ao trocar de pagina.
 */
class CheckAuthMiddleware extends Middleware
{
	public function __invoke($request, $response, $next) {
		$this->renderer->getEnvironment()->addGlobal('auth' , [
			'check' => $this->auth->check(),
			'user' => $this->auth->user(),
		]);

		$response = $next($request, $response);
		return $response;
	}
}

