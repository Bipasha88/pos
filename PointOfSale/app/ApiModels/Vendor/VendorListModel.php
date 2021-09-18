<?php

namespace App\ApiModels\Vendor;

use App\BusinessObjects\Vendor;
use App\Http\Requests\GetVendorListRequest;
use App\Services\Vendor\IVendorService;
use App\Utility\TableData;

class VendorListModel{
    private $vendorService;

    public function __construct(IVendorService $vendorService)
    {
        $this->vendorService = $vendorService;
    }

    public function getVendors($customer, GetVendorListRequest $request): TableData
    {
        if($customer != null) {
            $businessId = $customer->businesses()->first()->id;
            $vendor = $request->getObject();
            $search = $vendor->search;
            $offset = $vendor->offset;
            $limit = $vendor->limit;
            $orderColumn = $vendor->column;
            $direction = $vendor->direction;

            return $this->vendorService->getVendors($businessId, $offset,
                $limit, $search, $orderColumn, $direction);
        }
    }

    public function deleteVendor($id){
        return $this->vendorService->deleteVendorById($id);
    }
}
