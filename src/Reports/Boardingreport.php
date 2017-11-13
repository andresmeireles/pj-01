<?php
namespace App\Reports;

use \Mpdf\Mpdf;

class BoardingReport implements ReportInterface
{
	private $report

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
		$body = '<table class="table">'.
		'<caption id="titulo" style="font-size: 40px">ROMANEIO DE ENTREGA</caption>'.
		'<thead style="border-bottom: 4px solid black">'.
			'<tr align="left" class="head">'.
				'<th colspan="9" id="headInfo">'.
					'<span>Saida:</span>'.
					'<span>Data:</span>'.
					'<span>KM:</span>'.
					'<span>Chegada:</span>'.
					'<span>Data:</span>'.
					'<spa>KM:</span>'.
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
				'<th width="10%">FORM. PAG</th>'.
				'<th width="11%">FRETE</th>'.
			'</tr>'.
		'</thead>'.
		'<tbody class="body">';
		
		$counter = 0;

		foreach ($data as $customer) {
			$body .= '<tr>'.
				'<td widtd="3%">'.
				$cpunter++. //N
				'</td>'.
				'<td widtd="28%">'.
				$customer.// Cidade
				'</td>'.
				'<td widtd="22%">'.
				$customer.//Cliente
				'</td>'.
				'<td widtd="6%">'
				$customer.//G
				'</td>'.
				'<td widtd="6%">'.
				$customer.//M
				'</td>'.
				'<td widtd="5%">'.
				$customer.//P
				'</td>'.
				'<td widtd="6%">'.
				$customer.//TOTAL
				'</td>'.
				'</tr>';
		}

		$body .= '</tbody>'.
		'<tfoot>'.
			'<tr class="foot">'.
				'<th colspan="3">'.
				'</th>'.
				'<th width="6%">'.
				$total. //total G
				'</th>'.
				'<th width="6%">'.
				$total. //total m
				'</th>'
				'<th width="5%">'.
				$total. //total P
				'</th>'.
				'<th width="6%">'.
				$total. //soma total
				'</th>'
			'</tr>'.
		'</tfoot>'.
	'</table>';

	return $body;
	}
}