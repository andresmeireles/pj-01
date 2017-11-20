<?php
namespace App\Reports;

use \Mpdf\Mpdf;
use \Respect\Validation\Validator as v;
use \App\Validation\ValidatorJson;

class BoardingReport implements ReportInterface
{
	private $report;
    private $validator;

	function __construct(Mpdf $report, ValidatorJson $validator)
	{
        $this->report = $report;
        $this->validator = $validator;
	}
    
	public function create(array $data)
	{
        unset($data['report']);
        
        foreach ($data as $customer) {
            $fatalError = false;
            if (!$this->validate($customer)) {
                $fatalError = true;
                return $this->validator->failed();
            }
            
            if ($fatalError) {
                die('Você errou em alguma coisa');
            }
        }
        
		$mpdf = $this->report;
        
        $css = file_get_contents(__DIR__.'/../../reports/css/romaneio.css');
        $html = $this->createBody($data);
        $mpdf->AddPage('L', // L - landscape, P - portrait 
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

        $data = array_reverse($data);

		$body = '<table class="table">'.
		'<caption id="titulo" style="font-size: 40px">ROMANEIO DE ENTREGA</caption>'.
		'<thead style="border-bottom: 4px solid black">'.
        '<tr class="head">'.
        '<th colspan="7" id="headInfo">'.
        '<span class="c">Saida:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '<span class="c">Data:&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '<span class="c">KM:&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '<span class="c">Chegada:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '<span class="c">Data:&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '<span class="c">KM:&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '</th>'.
        '</tr>'.
        '<tr class="info">'.
        '<th width="3%">N°</th>'.
        '<th width="28%">Cliente</th>'.
        '<th width="22%">Cidade</th>'.
        '<th width="6%">G</th>'.
        '<th width="6%">M</th>'.
        '<th width="5%">P</th>'.
        '<th width="6%">TOTAL</th>'.
        '</tr>'.
		'</thead>'.
		'<tbody class="body">';
		
        $counter = 0;
        $mTotal = 0;
        $pTotal = 0;
        $gTotal = 0;
        
		foreach ($data as $customer) {
            $mTotal += $customer['mAmount'];
            $pTotal += $customer['pAmount'];
            $gTotal += $customer['gAmount'];

			$body .= '<tr>'.
            '<td widtd="3%" align="center">'.
            ++$counter. //N
            '</td>'.
            '<td widtd="28%" align="center">'.
            $customer['customer'].// Cliente
            '</td>'.
            '<td widtd="22%" align="center">'.
            $customer['city'].//Cidade
            '</td>'.
            '<td widtd="6%" align="center">'.
            $customer['gAmount'].//G
            '</td>'.
            '<td widtd="6%" align="center">'.
            $customer['mAmount'].//M
            '</td>'.
            '<td widtd="5%" align="center">'.
            $customer['pAmount'].//P
            '</td>'.
            '<td widtd="6%" align="center">'.
            ($customer['pAmount'] + $customer['mAmount'] + $customer['gAmount']).//TOTAL
            '</td>'.
            '</tr>';
		}
        
		$body .= '</tbody>'.
		'<tfoot>'.
        '<tr class="foot">'.
        '<th colspan="3">'.
        '</th>'.
        '<th width="6%" align="center">'.
        $gTotal. //total G
        '</th>'.
        '<th width="6%" align="center">'.
        $mTotal. //total m
        '</th>'.
        '<th width="5%" align="center">'.
        $pTotal. //total P
        '</th>'.
        '<th width="6%" align="center"  >'.
        ($pTotal + $mTotal + $gTotal). //soma total
        '</th>'.
        '</tr>'.
		'</tfoot>'.
        '</table>';
        
        return $body;
    }
    
    public function validate(array $data)
    {
        $validator = $this->validator->validate($data, [
            'customer' => v::stringType()->notEmpty(),
            'city' => v::stringType()->not(v::numeric())->notEmpty(),
            'gAmount' => v::numeric()->positive()->notEmpty()->noWhitespace(),
            'mAmount' => v::numeric()->positive()->notEmpty()->noWhitespace(),
            'pAmount' => v::numeric()->positive()->notEmpty()->noWhitespace(),
            'formPg' => v::stringType()->not(v::numeric())->notEmpty(),
            'ship' => v::numeric()->positive()->notEmpty()->noWhitespace()
        ]);
            
        if ($validator->failed()) {
            return false;
        }
            
        return true;
    }
}