<?php

namespace App\ApiModels\Vendor;

use App\Http\Requests\UpdateVendorRequest;
use App\Services\Vendor\IVendorService;

class UpdateVendorModel{
    private $vendorService;

    public function __construct(IVendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function updateVendor($id, UpdateVendorRequest $request){
        $vendor = $request->getObject();
        $this->vendorService->updateVendor($id, $vendor);
    }
}
