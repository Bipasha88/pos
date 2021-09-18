<?php

namespace App\ViewModels\Business;

use App\BusinessObjects\Business;
use App\Http\Requests\BusinessRequest;
use App\Services\Business\IBusinessService;

class UpdateBusinessModel {
    private $businessService;

    public function __construct(IBusinessService $businessService) {
        $this->businessService = $businessService;
    }

    public function load($id, BusinessRequest $request) {
        $business = $request->getObject();
        return $this->businessService->updateBusiness($id, $business);
    }
}
