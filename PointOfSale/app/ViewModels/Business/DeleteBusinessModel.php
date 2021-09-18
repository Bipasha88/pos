<?php

namespace App\ViewModels\Business;

use App\Services\Business\IBusinessService;

class DeleteBusinessModel {
    private $businessService;

    public function __construct(IBusinessService $businessService){
        $this->businessService = $businessService;
    }

    public function load($id){
        $this->businessService->deleteBusiness($id);
    }
}
