<?php
namespace App\Reports;

use \Mpdf\Mpdf;

class TravelReport
{
    private $report;
    
    function __construct(Mpdf $mpdf)
    {
        $this->report = $mpdf;
    }
    public function create(array $data)
    {
        $mpdf = $this->report;
        $mpdf->showImageErrors = true;
        
        $css = file_get_contents(__DIR__.'/../../reports/css/repo.css');
        //$html = file_get_contents(__DIR__.'/../../reports/reports/repo.html');
        $html = $this->createBody($data);
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
        exit();
    }
    
    private function createBody(array $data)
    {
        unset($data['report']);
        unset($data['driver']);
        $body = '
        <div id="content">'.
        '<div id="contentHeader">'.
        '<h1>Relatorio de Viagem: <span>'. 
        $data['driver'].
        '</span></h1>'.
        '<table>'.
        '<tr class="ninja">'.
        '<td class="n">Data: ___/___/_____</td>'.
        '<td class="n">Km:</td>'.
        '<td class="n">Hora:</td>'.
        '</tr>'.
        '<tr class="ninja">'.
        '<td class="n">Data: ___/___/_____</td>'.
        '<td class="n">Km:</td>'.
        '<td class="n">Hora:</td>'.
        '</tr>'.
        '</table>'.
        '</div>';

        
        foreach ($data as $fields) {
            $body .= 
            '<div class="cContent">'.
            '<div class="client-city">'.
            $fields['city'].
            '</div>'.
            '<div class="client-name">'.
            $fields['customer'].
            '</div>'.
            '<div style="clear: both"></div>'.
            '<table class="ntable">'.
            '<tr>'.
            '<td class="i">Data de Chegada: ___/___/____</td>'.
            '<td class="i">Hora:</td>'.
            '<td class="i">Data Saida: ___/___/____</td>'.
            '<td class="i">Hora:</td>'.
            '</tr>'.
            '</table>'.
            '<div class="line">'.
            '<hr></hr>'.
            '<hr></hr>'.
            '<hr></hr>'.
            '</div>'.
            '</div>';
        }

        $body .= '</div>';
        
        return $body;
    }
}