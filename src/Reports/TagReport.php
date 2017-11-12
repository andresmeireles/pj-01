<?php
namespace App\Reports;

use \Mpdf\Mpdf;

class TagReport implements ReportInterface
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
        
        $css = file_get_contents(__DIR__.'/../../reports/css/tag.css');
        //$html = file_get_contents(__DIR__.'/../../reports/reports/repo.html');
        $html = $this->createBody($data);
        $mpdf->AddPage('P', // L - landscape, P - portrait 
        '', '', '', 'on',
        2, // margin_left
        2, // margin right
        5, // margin top
        0, // margin bottom
        0, // margin header
        0); // margin footer
        $mpdf->writeHTML($css, 1);
        $mpdf->writeHTML($html, 2);
        
        $mpdf->Output();
        exit();
        
    }
    
    public function createBody(array $data) 
    {
        unset($data['report']);
        
        $body = '';
        
        $counter = 1;

        foreach ($data as $tags) {
            for ($i=0; $i < $tags['amount']; $i++) { 
                $body .= '<hr>'.
                '<div class="logo"><img src="assets/sys_img/logov2.png" alt=""></div>'.
                '<div class="info">'.
                '<div class="c">'.
                $tags['customer'].
                '</div>'.
                '<div class="city">'.
                $tags['city'].
                '</div>'.
                '</div>'.
                '<div class="volumes">'.
                '<div class="qnt">'.
                ($i + 1).
                '</div>'. 
                '<div class="vol">vol.'.
                ' '.$tags['amount'].
                '</div>'.
                '</div>'.
                '<div style="clear:both"></div>'.
                '<hr>';
            }
            $counter++;
        }
        
        return $body;
    }
}