<?php

namespace App\ViewModels\Business;

use App\Services\Business\IBusinessService;

class ArchiveBusinessModel {
    private $businessService;

    public function __construct(IBusinessService $businessService){
        $this->businessService = $businessService;
    }

    public function load($id){
        $this->businessService->archiveBusiness($id);
    }
}
