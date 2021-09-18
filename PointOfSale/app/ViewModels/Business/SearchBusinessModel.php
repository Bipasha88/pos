<?php

namespace App\ViewModels\Business;

use App\Services\Business\IBusinessService;

class SearchBusinessModel {
    private $businessService;

    public function __construct(IBusinessService $businessService) {
        $this->businessService = $businessService;
    }

    public function load($search_text) {
        return $this->businessService->searchBusiness($search_text);
    }
}
