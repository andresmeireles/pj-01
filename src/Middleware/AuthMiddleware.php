<?php 
namespace App\Middleware;

/**
 * CheckAuthMiddleware: Middleware responsavel por verificar se o usuario está logado ao trocar de pagina.
 */
class AuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (!$this->auth->check()) {
            $this->flash->addMessage('error', 'Please login before to access this page');
            return $response->withRedirect($this->router->pathFor('home'));
        }

        $response = $next($request, $response);
        return $response;
    }
}