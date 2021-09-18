<?php

namespace App\ApiModels\Vendor;

use App\Http\Requests\CreateVendorRequest;
use App\Services\Vendor\IVendorService;

class CreateVendorModel{
    private $vendorService;

    public function __construct(IVendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function createVendor(CreateVendorRequest $request){
        $vendor = $request->getObject();
        return $this->vendorService->createVendor($vendor);
    }
}
