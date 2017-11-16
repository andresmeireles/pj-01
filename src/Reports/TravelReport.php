<?php
namespace App\Reports;

use \Mpdf\Mpdf;
use \Respect\Validation\Validator as v;
use \App\Validation\ValidatorJson;
use Respect\Validation\Exceptions\NestedValidationException;

class TravelReport
{
    private $report;
    private $validator;
    private $driver;
    
    function __construct(Mpdf $mpdf, ValidatorJson $validator)
    {
        $this->report = $mpdf;
        $this->validator = $validator;
    }
    public function create(array $data)
    {
        $this->driver = $data['driver'];
        unset($data['driver']);
        unset($data['report']);

        try {
            if (!v::stringType()->not(v::numeric())->notEmpty()->validate($this->driver)) {
                throw new NestedValidationException('Erro no nome do Motorista');
            }
        } catch (NestedValidationException $e) {
            return $e->getMessages();
        }

        foreach ($data as $datas) {
            if (!$this->validate($datas)) {
                return $this->validator->failed();
            }
        }

        $mpdf = $this->report;
        $mpdf->showImageErrors = true;
        
        $css = file_get_contents(__DIR__.'/../../reports/css/repo.css');
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
        $body = '
        <div id="content">'.
        '<div id="contentHeader">'.
        '<h1>Relatorio de Viagem: <span>'. 
        $this->driver.
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
        
        unset($data['driver']);

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

    public function validate(array $data)
    {
        $validator = $this->validator->validate($data, [
            'customer' => v::stringType()->notEmpty(),
            'city' => v::stringType()->not(v::numeric())->notEmpty(),
        ]);

        if ($validator->failed()) {
            return false;
        }

        return true;
    }
}