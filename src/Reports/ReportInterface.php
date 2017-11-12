<?php
namespace App\Reports;

interface ReportInterface
{
    public function create(array $data);

    public function createBody(array $data);
}