<?php

namespace App\ApiModels\Vendor;

use App\Services\Vendor\IVendorService;

class GetVendorModel{
    private $vendorService;

    public function __construct(IVendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function getVendor($id){
        return $this->vendorService->getVendorById($id);
    }
}
