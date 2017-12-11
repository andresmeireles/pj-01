<?php
namespace App\Controller;

use Respect\Validation\Validator as v;
use \App\Validation\ValidatorJson;

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
    