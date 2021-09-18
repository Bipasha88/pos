<?php
namespace App\Utility;

class TableData
{
    public $data;
    public $recordsTotal;
    public $recordsFiltered;

    public function __construct($data, $recordsTotal, $recordsFiltered)
    {
        $this->data = $data;
        $this->recordsTotal = $recordsTotal;
        $this->recordsFiltered = $recordsFiltered;
    }
}