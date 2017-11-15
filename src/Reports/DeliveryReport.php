<?php
namespace App\Reports;

use \Mpdf\Mpdf;

class Deliveryreport implements ReportInterface
{
	private $report;

	function __construct(Mpdf $report)
	{
		$this->report = $report;
	}

	public function create(array $data) 
	{

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

		$body = '<table class="table">'.
		'<caption id="titulo" style="font-size: 40px">ROMANEIO DE ENTREGA</caption>'.
		'<thead style="border-bottom: 4px solid black">'.
        '<tr align="left" class="head">'.
        '<th colspan="9" id="headInfo">'.
        '<span class="c">Saida:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '<span class="c">Data:&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '<span class="c">KM:&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '<span class="c">Chegada:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '<span class="c">Data:&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '<span class="c">KM:&emsp;&emsp;&emsp;&emsp;&emsp;</span>'.
        '</th>'.
        '</tr>'.
        '<tr class="info">'.
        '<th width="2%">N°</th>'.
        '<th width="28%">Cliente</th>'.
        '<th width="20%">Cidade</th>'.
        '<th width="5%">G</th>'.
        '<th width="5%">M</th>'.
        '<th width="5%">P</th>'.
        '<th width="8%">TOTAL</th>'.
        '<th width="12%">FORM. PAG</th>'.
        '<th width="12%">FRETE</th>'.
        '</tr>'.
		'</thead>'.
		'<tbody class="body">';
		
        $counter = 0;
        $mTotal = 0;
        $pTotal = 0;
        $gTotal = 0;
        $sTotal = 0;
        
		foreach ($data as $customer) {
            $mTotal += $customer['mAmount'];
            $pTotal += $customer['pAmount'];
            $gTotal += $customer['gAmount'];
            $sTotal += $customer['ship']; 

			$body .= '<tr>'.
            '<td widtd="3%">'.
            ++$counter. //N
            '</td>'.
            '<td widtd="28%">'.
            $customer['customer'].// Cidade
            '</td>'.
            '<td widtd="22%">'.
            $customer['city'].//Cliente
            '</td>'.
            '<td widtd="6%">'.
            $customer['gAmount'].//G
            '</td>'.
            '<td widtd="6%">'.
            $customer['mAmount'].//M
            '</td>'.
            '<td widtd="5%">'.
            $customer['pAmount'].//P
            '</td>'.
            '<td widtd="5%">'.
            ($customer['pAmount'] + $customer['mAmount'] + $customer['gAmount']).//TOTAL
            '</td>'.
            '<td widtd="5%">'.
            $customer['formPg'].// forma pagamento
            '</td>'.
            '<td widtd="6%" align="left">'.
            'R$ '.$customer['ship'].//TOTAL
            '</td>'.
            '</tr>';
		}
        
		$body .= '</tbody>'.
		'<tfoot>'.
        '<tr class="foot">'.
        '<th colspan="3">'.
        '</th>'.
        '<th width="6%">'.
        $gTotal. //total G
        '</th>'.
        '<th width="6%">'.
        $mTotal. //total m
        '</th>'.
        '<th width="5%">'.
        $pTotal. //total P
        '</th>'.
        '<th width="6%">'.
        ($pTotal + $mTotal + $gTotal). //soma total
        '</th>'.
        '<th width="6%"></th>'.
        '<th width="6%" align="left">'.
        'R$ '.$sTotal. // total ship
        '</th>'.
        '</tr>'.
		'</tfoot>'.
        '</table>';
        
        return $body;
	}
}