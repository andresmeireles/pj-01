<?php
namespace App\Controller;

/**
* HomeController: Controller responsavel por renderizar pagina inicial
*/
class HomeController extends Controller
{
    
    public function home($request, $response)
    {
        return $this->renderer->render($response, 'index.twig', [
            'info' => array(
                'title' => 'Sistema',
                'name' => 'Urnas Mart'
            ),
            ]);
        }
    }
    