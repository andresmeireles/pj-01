<?php
namespace App\Controller;

/**
* HomeController: Controller responsavel por renderizar pagina inicial
*/
class HomeController extends Controller
{
    
    public function home($request, $response)
    {
        /**
        $mpdf = $this->report;
        
        $css = file_get_contents(__DIR__.'/../../reports/css/repo.css');
        $html = file_get_contents(__DIR__.'/../../reports/reports/repo.html');
        $header = file_get_contents(__DIR__.'/../../reports/reports/header.html');
        $footer = file_get_contents(__DIR__.'/../../reports/reports/footer.html');
        $mpdf->AddPage('P', // L - landscape, P - portrait 
        '', '', '', 'on',
        15, // margin_left
        15, // margin right
        40, // margin top
        10, // margin bottom
        10, // margin header
        5); // margin footer
        $mpdf->setHTMLHeader($header, 'O', TRUE);
        $mpdf->setHTMLHeader($header, 'E', TRUE);
        $mpdf->setHTMLFooter($footer);
        $mpdf->writeHTML($css, 1);
        $mpdf->writeHTML($html, 2);
        
        $mpdf->Output();
        die();

        */
        return $this->renderer->render($response, 'index.twig', [
            'info' => array(
                'title' => 'Sistema',
                'name' => 'Urnas Mart'
            ),
            ]);
        }
    }
    