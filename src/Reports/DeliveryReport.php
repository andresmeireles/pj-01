<?php
namespace App\Reports;

use \Mpdf\Mpdf;

class Deliveryreport implements Reportinterface
{
	private $report;

	function __construct(Mpdf $report)
	{
		$this->report;
	}

	public function create(array $data) 
	{
        $mpdf = $this->report;

        
	}

	public function createBody(array $data)
	{
		
	}
}