<?php
namespace App\Middleware;

class GestMiddleware extends Middleware
{
    public function __invoke($request, $response, $next) 
    {
        if ($this->auth->check()) {
            $this->flash->addMessage('error', 'Logout before access this page');
            return $response->withRedirect($this->router->pathFor('home'));
        }

        $response = $next($request, $response);
        return $response; 
    }
}
