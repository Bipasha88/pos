<?php

namespace App\ViewModels\Business;

use App\Services\Business\IBusinessService;

class EditBusinessModel {
    private $businessService;

    public function __construct(IBusinessService $businessService){
        $this->businessService = $businessService;
    }

    public function load($id) {
        return $this->businessService->getBusiness($id);
    }
}
