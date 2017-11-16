<?php
namespace App\Controller;

class ReportController extends Controller
{
    public function __invoke($request, $response)
    {
        return $this->renderer->render($response, '/reports/report_index.twig');
    }
    
    public function createTravelReport($request, $response)
    {
        $report = str_rot13('Travel');
        return $this->renderer->render($response, '/reports/report/travel.twig', 
        [
            'report' => $report,
        ]);
    }

    public function createTagReport($request, $response)
    {
        $report = str_rot13('Tag');
        return $this->renderer->render($response, '/reports/report/tag.twig', [
            'report' => $report,
        ]);
    }

    public function createBoardingDeliveryReport($request, $reponse) 
    {
        $reportDelivery = str_rot13('Delivery');
        $reportBoarding = str_rot13('Boarding');
        return $this->renderer->render($reponse, '/reports/report/boardingDelivery.twig', [
            'reportDelivery' => $reportDelivery,
            'reportBoarding' => $reportBoarding,
        ]);
    }
    
    public function create($request, $response) 
    {
        $class = '\App\Reports\\'.str_rot13($request->getParams()['report']).'Report';
        $report = new $class($this->report, $this->validationJson);
        return $response->withJson($report->create($request->getParams()));
    }
    
    public function createReport($request, $response) 
    {
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
        return die();
    }
}