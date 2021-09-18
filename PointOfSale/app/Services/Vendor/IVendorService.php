<?php

namespace App\Services\Vendor;

use App\BusinessObjects\Vendor;
use App\Utility\TableData;

interface IVendorService{
    public function createVendor(Vendor $vendor);
    public function getVendors($businessId, $offeset,
                               $limit, $search, $orderColumn, $direction) : TableData;
    public function deleteVendorById($id);
    public function getVendorById($id);
    public function updateVendor($id, $vendor);
}
