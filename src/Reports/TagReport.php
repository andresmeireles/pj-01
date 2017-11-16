<?php
namespace App\Reports;

use \Mpdf\Mpdf;
use \Respect\Validation\Validator as v;
use \App\Validation\ValidatorJson;

class TagReport implements ReportInterface
{
    private $report;
    private $validator;
    
    function __construct(Mpdf $mpdf, ValidatorJson $validator)
    {
        $this->report = $mpdf;
        $this->validator = $validator;
    }
    
    public function create(array $data)
    {
        unset($data['report']);
        
        foreach ($data as $datas) {
            if (!$this->validate($datas)) {
                return $this->validator->failed();
            }
        }
        
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
                $tags['city'].' '.$tags['state'].
                '</div>'.
                '</div>'.
                '<div class="volumes">'.
                '<div class="qnt">'.
                ($tags['casado'] ? ceil(($i + 1)/2) : $i + 1).
                '</div>'. 
                '<div class="vol">vol.'.
                ' '.($tags['casado'] ? ceil($tags['amount']/2) : $tags['amount']) .
                '</div>'.
                '</div>'.
                '<div style="clear:both"></div>'.
                '<hr>';
            }       
        }
        
        return $body;
    }
    
    public function validate(array $data)
    {
        $validator = $this->validator->validate($data, [
            'customer' => v::stringType()->notEmpty(),
            'city' => v::stringType()->not(v::numeric())->notEmpty(),
            'amount' => v::numeric()->positive()->notEmpty()->noWhitespace()
            ]);
            
            if ($validator->failed()) {
                return false;
            }
            
            return true;
        }
    }